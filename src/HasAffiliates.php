<?php

namespace Devio\Affiliate;

use Devio\Affiliate\Factories\ReferralFactory;

trait HasAffiliates
{
    public static function bootHasAffiliates()
    {
        static::created(function ($model) {
            app(ReferralFactory::class)->create($model);
        });
    }

    public function partner()
    {
        return $this->hasOne(Partner::class);
    }

    public function referral()
    {
        return $this->hasOne(Referral::class);
    }

    public function isPartner()
    {
        return (bool)$this->partner;
    }

    public function isReferral()
    {
        return (bool)$this->referral;
    }
}
