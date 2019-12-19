<?php

namespace Devio\Affiliate\Contracts;

interface PartnerCodeGenerator
{
    public function generate($user): string;
}
