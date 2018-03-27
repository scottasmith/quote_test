<?php
declare(strict_types=1);

namespace App\Logic\Quote;

use App\Entities\CustomerFormEntry;

class Quote implements QuoteInterface
{
    private $adjustment;

    public function __construct(AdjustmentInterface $adjustment)
    {
        $this->adjustment = $adjustment;
    }


    public function createQuote(CustomerFormEntry $entry): ImmutableResponseInterface
    {
        $premium = $this->getBasePremium();

        $response = new QuoteResponse($premium);

        $this->adjustment->apply($entry, $response);

        return $response;
    }

    private function getBasePremium(): float
    {
        return mt_rand(1000, 7000);
    }
}
