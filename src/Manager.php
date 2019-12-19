<?php

namespace Devio\Affiliate;

use Devio\Affiliate\Factories\TrackingFactory;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Cookie\Factory as CookieFactory;
use Illuminate\Http\Request;
use Spatie\Url\Url;

class Manager
{
    protected $config;
    protected $request;
    protected $cookie;

    public function __construct(Repository $config, Request $request, CookieFactory $cookie)
    {
        $this->config = $config;
        $this->request = $request;
        $this->cookie = $cookie;
    }

    public function shouldInstall()
    {
        $hasReferrer = (bool)$this->getReferrerParam();

        return !$this->hasCookie() && $hasReferrer;
    }

    public function redirect()
    {
        $param = $this->getReferrerParam();
        $code = $this->request->query($param);
        $tracking = app(TrackingFactory::class)->create($code);

        // Remove referral query parameter from URL. This is intended to provide
        // a cleaner URL to the end user and will also prevent the posibility
        // of causing infinite redirects when checking for referral params.
        $url = Url::fromString($this->request->fullUrl())->withoutQueryParameter($param);

        $redirect = redirect()->to($url);

        if ($tracking) {
            $redirect->withCookie($this->buildCookie($tracking));
        }

        return $redirect;
    }

    public function hasCookie()
    {
        return $this->request->hasCookie($this->getCookieName());
    }

    public function getCookie()
    {
        return $this->request->cookie($this->getCookieName());
    }

    public function flushCookie()
    {
        cookie()->queue(cookie()->forget($this->getCookieName()));
    }

    public function manageReferrals()
    {
        return $this->config->get('affiliate.manage_referrals');
    }

    protected function buildCookie(Tracking $tracking)
    {
        return $this->cookie->make(
            $this->getCookieName(), $tracking->getKey(), $this->getCookieDuration()
        );
    }

    protected function getCookieName()
    {
        return $this->config->get('affiliate.cookie.name');
    }

    protected function getCookieDuration()
    {
        return $this->config->get('affiliate.cookie.duration') ?? 2628000;
    }

    protected function getReferrerParam()
    {
        return array_key_first(
            array_filter(
                $this->request->only($this->config->get('affiliate.parameters'))
            )
        );
    }
}