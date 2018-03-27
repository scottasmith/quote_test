<?php

declare(strict_types=1);

namespace App\Handler;

use App\Db\Dal\GetTotals as GetTotalsDal;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class TodaysTotalsHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $totalsDal = $container->get(GetTotalsDal::class);
        $template = $container->get(TemplateRendererInterface::class);

        return new TodaysTotalsHandler($totalsDal, $template);
    }
}
