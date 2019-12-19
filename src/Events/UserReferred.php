<?php

namespace Devio\Affiliate;

class UserReferred
{
    public $user;

    /**
     * UserReferred constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
