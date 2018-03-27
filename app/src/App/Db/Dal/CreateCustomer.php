<?php

declare(strict_types=1);

namespace App\Db\Dal;

use App\Entities\Car;
use App\Entities\Customer;
use PDO;

class CreateCustomer
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function create(Car $car, Customer $customer): int
    {
        $query = '
            INSERT INTO onecall_test.Customer(
                carId,
                name,
                dob,
                licenseNumber
            ) VALUES (
                :carId,
                :name,
                :dob,
                :licenseNumber
            )';

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':carId', $car->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $customer->getName());
        $stmt->bindValue(':dob', $customer->getDob());
        $stmt->bindValue(':licenseNumber', $customer->getLicenseNumber());

        $stmt->execute();

        if (!$stmt->rowCount()) {
            throw new \Exception('Failed to insert Customer details');
        }

        $customer->setId($this->conn->lastInsertId());

        return $stmt->rowCount();
    }
}
