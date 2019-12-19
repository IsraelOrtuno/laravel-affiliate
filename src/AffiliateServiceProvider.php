<?php

namespace Devio\Affiliate;

use Devio\Affiliate\Contracts\PartnerCodeGenerator;
use Illuminate\Support\ServiceProvider;
use Spatie\Url\Url;

class AffiliateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database');
        $this->mergeConfigFrom(__DIR__ . '/../config/affiliate.php', 'affiliate');

        Url::macro('withoutQueryParameters', function (...$params) {
            $url = clone $this;

            foreach ($params as $param) {
                $url->query->unset($param);
            }

            return $url;
        });
    }

    public function register()
    {
        $this->app->bind(PartnerCodeGenerator::class, CodeGenerator::class);
    }
}
