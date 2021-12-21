<?php

declare(strict_types=1);

namespace Deviget\StoreWishList\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class Data
 */
class Data extends AbstractHelper
{
    /**
     * @var TimezoneInterface
     */
    protected $timeZoneInterface;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param TimezoneInterface $timeZoneInterface
     */
    public function __construct(Context $context, TimezoneInterface $timeZoneInterface)
    {
        $this->timeZoneInterface = $timeZoneInterface;
        parent::__construct($context);
    }

    /**
     * Method to validate if the time gate
     *
     * @param string $startTimeGate
     * @param string $finishTime
     *
     * @return bool
     */
    public function validateTimeGate(string $startTimeGate, string $endTimeGate): bool
    {
        return ($this->timeZoneInterface->date($startTimeGate) <= $this->timeZoneInterface->date())
            && ($this->timeZoneInterface->date() <= $this->timeZoneInterface->date($endTimeGate));
    }
}