<?php

declare(strict_types=1);

namespace App\Db\Dal;

use App\Entities\Car;
use PDO;

class CreateCar
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function create(Car $car): int
    {
        $query = '
            INSERT INTO onecall_test.Car(
                registration,
                make,
                model
            ) VALUES (
                :registration,
                :make,
                :model
            )';

        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            ':registration' => $car->getRegistration(),
            ':make'         => $car->getMake(),
            ':model'        => $car->getModel(),
        ]);

        if (!$stmt->rowCount()) {
            throw new \Exception('Failed to insert Car details');
        }
        
        $car->setId($this->conn->lastInsertId());

        return $stmt->rowCount();
    }
}
