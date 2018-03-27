<?php
declare(strict_types=1);

namespace App\Logic\Quote;

use App\Entities\CustomerFormEntry;

interface AdjustmentInterface
{
    public function getName(): string;
    public function apply(CustomerFormEntry $entry, MutableResponseInterface $response);
}
