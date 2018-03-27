<?php
declare(strict_types=1);

namespace App\Entities;

class Car
{
    private $carId;
    private $registration;
    private $make;
    private $model;

    public static function create(array $data): Car
    {
        // would normally validate data isset, etc

        $car = new static();
        $car->registration = $data['registration'];
        $car->make         = $data['make'];
        $car->model        = $data['model'];

        return $car;
    }

    public function setId($carId)
    {
        $this->carId = $carId;
    }

    public function getId()
    {
        return $this->carId;
    }

    public function getRegistration(): string
    {
        return $this->registration;
    }

    public function getMake(): string
    {
        return $this->make;
    }

    public function getModel(): string
    {
        return $this->model;
    }
}
