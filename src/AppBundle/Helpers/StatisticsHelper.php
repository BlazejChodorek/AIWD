<?php
/**
 * Created by PhpStorm.
 * User: Blazej Chodorek
 * Date: 18.11.2017
 * Time: 20:11
 */

namespace AppBundle\Helpers;

use AppBundle\Entity\Car;

class StatisticsHelper
{
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

    static function getMedian($array)
    {
        $quantity = count($array);
        $median = null;
        sort($array);

        if ($quantity % 2 == 0) {
            $ma = ($quantity - 1) / 2;
            $median = ($array[$ma] + $array[$ma + 1]) / 2;
        } else {
            $median = $array[($quantity - 1) / 2];
        }
        return $median;
    }

    static function deleteAllCars($em)
    {
        $car = new Car();
        $car->deleteAllCars($em);
    }

    static function getAllCars($em, $original = false)
    {
        $cars = new Car();
        $cars = $original ? $cars->getOriginalCars($em) : $cars->getProcessedCars($em);

        return $cars;
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

    static function getAverage($array)
    {
        return round(array_sum($array) / count($array), 3);
    }

    static function getStandardDeviation($array)
    {
        $tmpArr = array();

        foreach ($array as $item) {
            $tmpArr[] = ($item - StatisticsHelper::getAverage($array)) * ($item - StatisticsHelper::getAverage($array));
        }
        $standardDeviation = round(sqrt(array_sum($tmpArr) / (count($array) - 1)), 3);

        return $standardDeviation;
    }

    static function getPearsonCorrelation($arrayA, $arrayB)
    {
        $r = null;
        $arrXY = array();

        foreach ($arrayA as $x) {
            foreach ($arrayB as $y) {
                $arrXY[] = $x * $y;
            }
        }

        $r = (((1 / count($arrayA))) - (StatisticsHelper::getAverage($arrayA) * StatisticsHelper::getAverage($arrayB))) / StatisticsHelper::getStandardDeviation($arrayA) * StatisticsHelper::getStandardDeviation($arrayB);

        return array("r" => round($r, 3), "rModulus" => abs($r));
    }

    static function getQuartile($num, $array)
    {
        sort($array);
        $index = round((count($array) + 1) * $num / 4) - 1;

        return $array[$index];
    }

    static function getLinearRegression($arrayA, $arrayB)
    {
        $n = count($arrayA);
        $x_sum = array_sum($arrayA);
        $y_sum = array_sum($arrayB);

        $xx_sum = 0;
        $xy_sum = 0;

        for ($i = 0; $i < $n; $i++) {
            $xy_sum += ($arrayA[$i] * $arrayB[$i]);
            $xx_sum += ($arrayA[$i] * $arrayA[$i]);
        }

        $a = (($n * $xy_sum) - ($x_sum * $y_sum)) / (($n * $xx_sum) - ($x_sum * $x_sum));
        $b = ($y_sum - ($a * $x_sum)) / $n;

        $a = round($a, 3);
        $b = round($b, 3);

        return array("a" => $a, "b" => $b, "equation" => "Y = " . $a . " * X + " . $b);
    }

    static function getNorm()
    {
        return array("enginePowerFrom" => 50, "enginePowerTo" => 220, "accelerationFrom" => 6, "accelerationTo" => 20);
    }


    static function checkTheRange($data, $from, $to)
    {
        return (($data == $from || $data == $to) || ($data > $from && $data < $to));
    }
}