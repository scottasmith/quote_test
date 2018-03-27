<?php
declare(strict_types=1);

namespace App\Entities;

class CustomerFormEntry
{
    private $customer;
    private $address;
    private $car;

    public static function create(array $data): CustomerFormEntry
    {
        // would normally validate data isset, etc

        $entry = new static();
        $entry->customer = Customer::create($data['customer']);
        $entry->address = Address::create($data['address']);
        $entry->car = Car::create($data['car']);

        return $entry;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getCar(): Car
    {
        return $this->car;
    }
}
