<?php

namespace Devio\Affiliate\Contracts;

interface Cookie
{
    public function redirect();

    public function shouldInstall();
}