<?php

namespace Devio\Affiliate;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public $table = 'affiliate_partners';

    public function user()
    {
        return $this->belongsTo(config('affiliate.user_model'));
    }

    public function tracking()
    {
        return $this->belongsTo(Tracking::class);
    }

    public function referrals()
    {
        return $this->hasManyThrough(Referral::class, Tracking::class);
    }

    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    public static function findUserByCode($code)
    {
        $partner = static::findByCode($code);

        return $partner->user ?? null;
    }
}
