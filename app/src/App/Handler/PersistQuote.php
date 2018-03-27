<?php

declare(strict_types=1);

namespace App\Handler;

use App\Db\Dal\CreateCar as CreateCarDal;
use App\Db\Dal\CreateCustomer as CreateCustomerDal;
use App\Db\Dal\CreateCustomerAddress as CreateCustomerAddressDal;
use App\Db\Dal\CreateQuote as CreateQuoteDal;
use App\Entities\CustomerFormEntry;
use App\Logic\Quote\ImmutableResponseInterface;
use PDO;

class PersistQuote
{
    private $dbConn;
    private $createCarDal;
    private $createCustomerDal;
    private $createAddressDal;
    private $createQuoteDal;

    public function __construct(
        PDO $dbConn,
        CreateCarDal $createCarDal,
        CreateCustomerDal $createCustomerDal,
        CreateCustomerAddressDal $createAddressDal,
        CreateQuoteDal $createQuoteDal
    ) {
        $this->dbConn            = $dbConn;
        $this->createCarDal      = $createCarDal;
        $this->createCustomerDal = $createCustomerDal;
        $this->createAddressDal  = $createAddressDal;
        $this->createQuoteDal    = $createQuoteDal;
    }

    public function persist(CustomerFormEntry $entry, ImmutableResponseInterface $quoteResponse)
    {
        try {
            $this->dbConn->beginTransaction();

            $this->createCarDal->create($entry->getCar());
            $this->createCustomerDal->create($entry->getCar(), $entry->getCustomer());
            $this->createAddressDal->create($entry->getCustomer(), $entry->getAddress());
            $this->createQuoteDal->create($entry->getCar(), $quoteResponse);

            $this->dbConn->commit();
        } catch (\Exception $exc) {
            $this->dbConn->rollBack();

            throw new \Exception('Failed to insert data into database: ' . $exc->getMessage(), 0, $exc);
        }
    }
}
