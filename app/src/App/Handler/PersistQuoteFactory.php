<?php

declare(strict_types=1);

namespace App\Handler;

use App\Db\Connection;
use App\Db\Dal\CreateCar as CreateCarDal;
use App\Db\Dal\CreateCustomer as CreateCustomerDal;
use App\Db\Dal\CreateCustomerAddress as CreateCustomerAddressDal;
use App\Db\Dal\CreateQuote as CreateQuoteDal;
use Psr\Container\ContainerInterface;

class PersistQuoteFactory
{
    public function __invoke(ContainerInterface $container): PersistQuote
    {
        $dbConn      = $container->get(Connection::class);
        $carDal      = $container->get(CreateCarDal::class);
        $customerDal = $container->get(CreateCustomerDal::class);
        $addressDal  = $container->get(CreateCustomerAddressDal::class);
        $quoteDal    = $container->get(CreateQuoteDal::class);

        return new PersistQuote(
            $dbConn,
            $carDal,
            $customerDal,
            $addressDal,
            $quoteDal
        );
    }
}
