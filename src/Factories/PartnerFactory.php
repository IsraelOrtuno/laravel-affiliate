<?php

namespace Devio\Affiliate\Factories;

use Devio\Affiliate\Contracts\PartnerCodeGenerator;
use Devio\Affiliate\Events\PartnerCreated;
use Devio\Affiliate\Partner;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

class PartnerFactory
{
    protected $codeGenerator;

    /**
     * PartnerFactory constructor.
     *
     * @param PartnerCodeGenerator $codeGenerator
     */
    public function __construct(PartnerCodeGenerator $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;
    }

    /**
     *
     *
     * @param $user
     * @param array $data
     * @return mixed
     */
    public function create($user, $data = [])
    {
        $data['code'] = $this->codeGenerator->generate($user);
        $partner = $user->partner()->create($data);

        event(new PartnerCreated($partner));

        return $partner;
    }
}
