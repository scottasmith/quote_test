<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\PersistQuote;
use App\Logic\Quote\QuoteInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;

class FormPostHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        $quotePersist = $container->get(PersistQuote::class);
        $router       = $container->get(RouterInterface::class);
        $quote        = $container->get(QuoteInterface::class);

        return new FormPostHandler(
            $quotePersist,
            $router,
            $quote
        );
    }
}
