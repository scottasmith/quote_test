<?php

declare(strict_types=1);

namespace App;

use App\Logic;
use App\Db;
use App\Db\InvokableDalFactory;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                // HTTP Handlers
                Handler\FormHandler::class => Handler\FormHandlerFactory::class,
                Handler\FormPostHandler::class => Handler\FormPostHandlerFactory::class,
                Handler\FormPostCompleteHandler::class => Handler\FormPostCompleteHandlerFactory::class,
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                Handler\TodaysTotalsHandler::class => Handler\TodaysTotalsHandlerFactory::class,

                Handler\PersistQuote::class => Handler\PersistQuoteFactory::class,

                // Logic Classes
                Logic\Quote\QuoteInterface::class => Logic\Quote\QuoteFactory::class,

                // DB
                Db\Connection::class => Db\PdoFactory::class,
                
                // DAL
                Db\Dal\CreateCar::class => InvokableDalFactory::class,
                Db\Dal\CreateCustomer::class => InvokableDalFactory::class,
                Db\Dal\CreateCustomerAddress::class => InvokableDalFactory::class,
                Db\Dal\CreateQuote::class => InvokableDalFactory::class,
                Db\Dal\GetTotals::class => InvokableDalFactory::class,

                \Zend\Expressive\Flash\FlashMessageMiddleware::class => FlashMessageMiddlewareFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
