<?php
/**
 * Created by PhpStorm.
 * User: Blazej Chodorek
 * Date: 18.11.2017
 * Time: 20:11
 */

namespace AppBundle\Helpers;


class StatisticsHelper
{


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

    static function getDistantPoints($em, $arrayA, $arrayB)
    {
        $xiQ1 = StatisticsHelper::getQuartile(1, $arrayA);
        $xiQ3 = StatisticsHelper::getQuartile(3, $arrayA);
        $xiIRQ = $xiQ3 - $xiQ1;

        $yiQ1 = StatisticsHelper::getQuartile(1, $arrayB);
        $yiQ3 = StatisticsHelper::getQuartile(3, $arrayB);
        $yiIRQ = $yiQ3 - $yiQ1;

        $allCars = CarHelper::getAllCars($em, false);
        $keys = array();

//      xi < Q1 − 1, 5(IRQ)   ||   xi > Q3 + 1, 5(IRQ)
        foreach ($allCars as $key => $car) {
            $xi = $car->getEnginepower();
            $yi = $car->getAcceleration();

            if ((($xi < $xiQ1 - (1.5 * $xiIRQ)) || ($xi > $xiQ3 + (1.5 * $xiIRQ))) && (($yi < $yiQ1 - (1.5 * $yiIRQ)) || ($yi > $yiQ3 + (1.5 * $yiIRQ)))) {
                $keys[] = $key;
            }
        }

        $distantPoints = array();

        foreach ($allCars as $key => $car) {
            foreach ($keys as $oneKey) {
                if ($key == $oneKey) {
                    $distantPoints[] = $car;
                }
            }
        }

        return $distantPoints;
    }

    static function checkTheRange($data, $from, $to)
    {
        return (($data == $from || $data == $to) || ($data > $from && $data < $to));
    }
}