<?php
declare(strict_types=1);

namespace App\Logic\Quote;

use App\Entities\CustomeFormEntry;

interface MutableResponseInterface
{
    public function addAdditionalPremium(float $additionalPremium);
}
