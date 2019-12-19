<?php

namespace Devio\Affiliate;

use Arcanedev\Support\Database\Model;

class Tracking extends Model
{
    public $table = 'affiliate_trackings';

    public $guarded = [];

    public $casts = [
        'tracking' => 'json',
        'extra' => 'json'
    ];
}