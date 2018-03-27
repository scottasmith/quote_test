<?php
declare(strict_types=1);

namespace App\Logic\Quote\Adjustments;

use App\Entities\CustomerFormEntry;
use App\Logic\Quote\AdjustmentInterface;
use App\Logic\Quote\MutableResponseInterface;

class CarAdjustment implements AdjustmentInterface
{
    const LUCKY_MAKE = 'vauxhall';
    const LUCKY_MODEL = 'agila';

    public function getName(): string
    {
        return 'Car Adjustments';
    }

    public function apply(CustomerFormEntry $entry, MutableResponseInterface $response)
    {
        $car = $entry->getCar();

        if (self::LUCKY_MAKE == strtolower($car->getMake())
            && self::LUCKY_MODEL == strtolower($car->getModel())
        ) {
            $response->addAdditionalPremium(100);
        }
    }
}
