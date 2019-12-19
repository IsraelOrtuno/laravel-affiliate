<?php

namespace Devio\Affiliate;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    public $table = 'affiliate_conversion';

    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }

    public function approve()
    {
    }

    public function reject()
    {
    }
}
