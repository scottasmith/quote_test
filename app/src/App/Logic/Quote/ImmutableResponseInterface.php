<?php
declare(strict_types=1);

namespace App\Logic\Quote;

interface ImmutableResponseInterface
{
    public function getPremium(): float;
    public function getAdditionalPremium(): float;
}
