<?php

namespace Devio\Affiliate;

use Devio\Affiliate\Contracts\Cookie as CookieContract;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Cookie\Factory as CookieFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Url\Url;

class Cookie implements CookieContract
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

    public function redirect()
    {
        $param = $this->getReferrerParam();
        $code = $this->request->query($param);

        $cookie = $this->cookie->make(
            $this->getCookieName(), $code, $this->getCookieDuration()
        );

        return redirect()->to($this->redirectUrl($param))->withCookie($cookie);
    }

    public function shouldInstall()
    {
        return !$this->request->hasCookie($this->getCookieName()) || (bool)$this->getReferrerParam();
    }

    protected function redirectUrl($param)
    {
        // Remove affiliate query parameter form URL
        return Url::fromString($this->request->fullUrl())
            ->withoutQueryParameter($param);
    }

    protected function getReferrerParam()
    {
        return array_key_first(
            $this->request->only($this->config->get('affiliate.parameters'))
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
}
