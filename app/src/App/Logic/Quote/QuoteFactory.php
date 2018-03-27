<?php
declare(strict_types=1);

namespace App\Logic\Quote;

use App\Logic\Quote\Adjustments;
use Psr\Container\ContainerInterface;

class QuoteFactory
{
    public function __invoke(ContainerInterface $container) : QuoteInterface
    {
        $adjustments = new AdjustmentChain();
        $adjustments->addAdjustment(new Adjustments\AgeAdjustment());
        $adjustments->addAdjustment(new Adjustments\CarAdjustment());

        return new Quote($adjustments);
    }
}
