<?php

namespace Devio\Affiliate\Factories;

use Devio\Affiliate\Manager;
use Devio\Affiliate\Referral;
use Devio\Affiliate\Tracking;

class ReferralFactory
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * ReferralFactory constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function create($model)
    {
        if (!$this->manager->manageReferrals() ||
            !$this->manager->hasCookie() ||
            !$tracking = Tracking::find($this->manager->getCookie())) {
            return;
        };

        Referral::create([
            'tracking_id' => $tracking->getKey(),
            'user_id' => $model->getKey()
        ]);

        $this->manager->flushCookie();
    }
}