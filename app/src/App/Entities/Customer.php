<?php
declare(strict_types=1);

namespace App\Entities;

class Customer
{
    private $customerId;
    private $name;
    private $dob;
    private $licenseNumber;

    public static function create(array $data): Customer
    {
        // would normally validate data isset, etc

        $customer = new static();
        $customer->name          = $data['name'];
        $customer->dob           = $data['dob'];
        $customer->licenseNumber = $data['licenseNumber'];

        return $customer;
    }

    public function setId($customerId)
    {
        $this->customerId = $customerId;
    }

    public function getId()
    {
        return $this->customerId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDob(): string
    {
        return $this->dob;
    }

    public function getLicenseNumber(): string
    {
        return $this->licenseNumber;
    }
}
