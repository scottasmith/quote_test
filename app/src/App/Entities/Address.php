<?php
declare(strict_types=1);

namespace App\Entities;

class Address
{
    private $line1;
    private $line2;
    private $town;
    private $postcode;

    public static function create(array $data): Address
    {
        // would normally validate data isset, etc

        $addr = new static();
        $addr->line1    = $data['line1'];
        $addr->line2    = $data['line2'];
        $addr->town     = $data['town'];
        $addr->postcode = $data['postcode'];

        return $addr;
    }

    public function getLine1(): string
    {
        return $this->line1;
    }

    public function getLine2(): string
    {
        return $this->line2;
    }

    public function getTown(): string
    {
        return $this->town;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }
}
