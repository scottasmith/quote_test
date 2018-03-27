<?php

declare(strict_types=1);

namespace App;

use Application\FlashMessages;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Flash\FlashMessageMiddleware;

class FlashMessageMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new FlashMessageMiddleware(
            FlashMessages::class,
            FlashMessages::class . '::FLASH_NEXT',
            'flash-messages'
        );
    }
}