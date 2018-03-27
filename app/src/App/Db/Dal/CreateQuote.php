<?php

declare(strict_types=1);

namespace App\Db\Dal;

use App\Logic\Quote\ImmutableResponseInterface;
use App\Entities\Car;
use PDO;

class CreateQuote
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function create(Car $car, ImmutableResponseInterface $quote): int
    {
        $query = '
            INSERT INTO onecall_test.Quote(
                carId,
                premium,
                additionalPremium,
                createDate
            ) VALUES (
                :carId,
                :premium,
                :additionalPremium,
                NOW()
            )';

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':carId', $car->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':premium', $quote->getPremium());
        $stmt->bindValue(':additionalPremium', $quote->getAdditionalPremium());

        $stmt->execute();

        if (!$stmt->rowCount()) {
            throw new \Exception('Failed to insert Quote details');
        }

        return $stmt->rowCount();
    }
}
