<?php

namespace Devio\Affiliate;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public $table = 'affiliate_referrals';

    public $guarded = [];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function user()
    {
        return $this->belongsTo(config('affiliate.user_model'));
    }
}
