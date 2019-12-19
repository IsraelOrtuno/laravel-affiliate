<?php


namespace Devio\Affiliate;


use Devio\Affiliate\Contracts\PartnerCodeGenerator;

class CodeGenerator implements PartnerCodeGenerator
{
    public function generate($user): string
    {
        return 'CODE-' . $user->getKey();
    }
}
