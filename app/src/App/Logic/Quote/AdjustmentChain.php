<?php
declare(strict_types=1);

namespace App\Logic\Quote;

use App\Entities\CustomerFormEntry;

class AdjustmentChain implements AdjustmentInterface
{
    private $name;
    private $adjustments;

    public function __construct($name = 'Adjustment Chain')
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addAdjustment(AdjustmentInterface $adjustment)
    {
        $this->adjustments[] = $adjustment;
        return $this;
    }

    public function apply(CustomerFormEntry $entry, MutableResponseInterface $response)
    {
        foreach ($this->adjustments as $adjustment) {
            $adjustment->apply($entry, $response);
        }
    }
}
