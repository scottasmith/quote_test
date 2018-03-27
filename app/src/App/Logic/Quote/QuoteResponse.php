<?php
declare(strict_types=1);

namespace App\Logic\Quote;

class QuoteResponse implements ImmutableResponseInterface, MutableResponseInterface
{
    private $premium = 0;
    private $additionalPremium = 0;

    public function __construct(float $premium)
    {
        $this->premium = $premium;
    }

    public function addAdditionalPremium(float $additionalPremium)
    {
        $this->additionalPremium += $additionalPremium;
    }

    public function getPremium(): float
    {
        return $this->premium;
    }

    public function getAdditionalPremium(): float
    {
        return $this->additionalPremium;
    }
}
