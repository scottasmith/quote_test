<?php
declare(strict_types=1);

namespace App\Logic\Quote;

use App\Entities\CustomerFormEntry;

interface QuoteInterface
{
    public function createQuote(CustomerFormEntry $entry): ImmutableResponseInterface;
}
