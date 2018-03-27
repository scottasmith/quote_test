<?php

declare(strict_types=1);

namespace App\Db\Dal;

use DateTime;
use PDO;

class GetTotals
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getTotal(DateTime $dateFrom , DateTime $dateTo): float
    {
        $query = '
            SELECT
                SUM(q.premium) + SUM(q.additionalPremium) AS totalPremium
            FROM
                onecall_test.Quote AS q
            WHERE
                q.createDate BETWEEN :dateFrom AND :dateTo';

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':dateFrom', $dateFrom->format('Y-m-d H:i:s'));
        $stmt->bindValue(':dateTo', $dateTo->format('Y-m-d H:i:s'));
        
        $stmt->execute();

        $result = $stmt->fetchColumn(0);
        if (!$result) {
            return 0.0;
        }

        return (float) $result;
    }

    public function getQuoteList(\DateTime $dateFrom , \DateTime $dateTo): array
    {
        $query = '
            SELECT
                cu.name AS customerName,
                c.make AS carMake,
                c.model AS carModel,
                q.premium,
                q.additionalPremium
            FROM
                onecall_test.Quote AS q
            INNER JOIN
                onecall_test.Car AS c ON c.carId = q.carId
            INNER JOIN
                onecall_test.Customer AS cu ON cu.carId = c.carId
            WHERE
                q.createDate BETWEEN :dateFrom AND :dateTo';

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':dateFrom', $dateFrom->format('Y-m-d H:i:s'));
        $stmt->bindValue(':dateTo', $dateTo->format('Y-m-d H:i:s'));
        
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
