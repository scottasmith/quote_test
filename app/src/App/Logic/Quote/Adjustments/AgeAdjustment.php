<?php
declare(strict_types=1);

namespace App\Logic\Quote\Adjustments;

use App\Entities\Customer as CustomerEntity;
use App\Entities\CustomerFormEntry;
use App\Logic\Quote\AdjustmentInterface;
use App\Logic\Quote\MutableResponseInterface;
use DateTime;
use DateTimeZone;

class AgeAdjustment implements AdjustmentInterface
{
    public function getName(): string
    {
        return 'Age Adjustment';
    }

    public function apply(CustomerFormEntry $entry, MutableResponseInterface $response)
    {
        $customer = $entry->getCustomer();

        $age = $this->getAge($customer);
        if ($age > 70) {
            $response->addAdditionalPremium(100);
        }
    }

    private function getAge(CustomerEntity $customer): int
    {
        $tz = new DateTimeZone('Europe/London');

        $dobTs = DateTime::createFromFormat('Y-m-d', $customer->getDob(), $tz);
        if (false === $dobTs) {
            throw new \Exception('Date Error (should be handled more elegantly)');
        }
        
        $nowTs = new DateTime('now', $tz);

        return $dobTs->diff($nowTs)->y;
    }
}
