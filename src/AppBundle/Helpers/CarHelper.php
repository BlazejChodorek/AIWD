<?php
/**
 * Created by PhpStorm.
 * User: Blazej Chodorek
 * Date: 19.11.2017
 * Time: 12:27
 */

namespace AppBundle\Helpers;

use AppBundle\Entity\Car;

class CarHelper
{
    static function getAllCars($em, $original = false)
    {
        $cars = new Car();
        $cars = $original ? $cars->getOriginalCars($em) : $cars->getProcessedCars($em);

        return $cars;
    }

    static function deleteAllCars($em)
    {
        $car = new Car();
        $car->deleteAllCars($em);
    }

    static function insertNewCar($em, $brand = null, $model = null, $enginepower = null, $acceleration = null, $original = null)
    {
        $car = new Car($brand, $model, $enginepower, $acceleration, $original);
        $em->persist($car);
        $em->flush();
    }

    static function getAccelerations($em, $original = false)
    {
        $car = new Car();
        $cars = $original ? $car->getOriginalCars($em) : $car->getProcessedCars($em);

        $acceleration = array();

        foreach ($cars as $car) {
            $acceleration[] = $car->getAcceleration();
        }
        return $acceleration;
    }

    static function getEnginesPower($em, $original = false)
    {
        $car = new Car();
        $cars = $original ? $car->getOriginalCars($em) : $car->getProcessedCars($em);

        $enginePower = array();

        foreach ($cars as $car) {
            $enginePower[] = $car->getEnginepower();
        }
        return $enginePower;
    }

    static function getCarsByEnginePower($em, $enginePower)
    {
        $cars = new Car();
        $cars->getCarsByEnginePower($em, $enginePower);

        return $cars;
    }

    static function getCarsByAccleration($em, $acceleration)
    {
        $cars = new Car();
        $cars->getCarsByAccleration($em, $acceleration);

        return $cars;
    }

    static function getNorm()
    {
        return array("enginePowerFrom" => 20, "enginePowerTo" => 230, "accelerationFrom" => 4, "accelerationTo" => 20);
    }
}