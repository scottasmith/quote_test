<?php

declare(strict_types=1);

namespace App\Db\Dal;

use App\Entities\Customer;
use App\Entities\Address;
use PDO;

class CreateCustomerAddress
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function create(Customer $customer, Address $address): int
    {
        $query = '
            INSERT INTO onecall_test.CustomerAddress(
                customerId,
                line1,
                line2,
                town,
                postcode
            ) VALUES (
                :customerId,
                :line1,
                :line2,
                :town,
                :postcode
            )';

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':customerId', $customer->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':line1', $address->getLine1());
        $stmt->bindValue(':line2', $address->getLine2());
        $stmt->bindValue(':town', $address->getTown());
        $stmt->bindValue(':postcode', $address->getPostcode());

        $stmt->execute();

        if (!$stmt->rowCount()) {
            throw new \Exception('Failed to insert Address details');
        }

        return $stmt->rowCount();
    }
}
