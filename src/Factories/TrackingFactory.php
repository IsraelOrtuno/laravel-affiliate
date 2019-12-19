<?php


namespace Devio\Affiliate\Factories;

use Devio\Affiliate\Partner;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Spatie\Url\Url;

class TrackingFactory
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * TrackingFactory constructor.
     * @param Repository $config
     * @param Request $request
     */
    public function __construct(Repository $config, Request $request)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function create($code)
    {
        $partner = Partner::findByCode($code);

        return $partner ? $partner->tracking()->create([
            'code' => $code,
            'origin' => $this->getOrigin(),
            'destination' => $this->getDestination(),
            'ip' => $this->request->getClientIp(),
            'country' => $this->getCountry(),
            'tracking' => $this->getTracking(),
            'partner_id' => $partner->getKey()
        ]) : null;
    }

    protected function getTracking()
    {
        return $this->request->only($this->getTrackingParameters());
    }

    protected function getOrigin()
    {
        return $this->request->headers->get('referer');
    }

    protected function getDestination()
    {
        $parameters = array_merge(
            $this->config->get('affiliate.parameters'), $this->config->get('affiliate.tracking_parameters')
        );

        return (string)$this->getUrlInstance()->withoutQueryParameters(...$parameters);
    }

    protected function getCountry()
    {
        return null;
    }

    protected function getUrlInstance()
    {
        return Url::fromString($this->request->fullUrl());
    }

    protected function getTrackingParameters()
    {
        return $this->config->get('affiliate.tracking_parameters');
    }
}