<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/app")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/file")
     */
    public function fileAction(Request $request)
    {
        $data = $request->request->get('data', null);
        $cars = json_decode($data, true);
        $em = $this->getDoctrine()->getManager();
        $this->deleteAllCars($em);

        foreach ($cars as $item) {
            foreach ($item as $key => $oneCar) {
                $vehicle = new Car($item[$key]['brand'], $item[$key]['model'], $item[$key]['enginePower'], $item[$key]['acceleration'], true);
                $em->persist($vehicle);
                $em->flush();
            }
        }

        $allEnginePower = $this->getEnginesPower($this->getDoctrine()->getManager(), true);
        $allAcceleration = $this->getAccelerations($this->getDoctrine()->getManager(), true);

        foreach ($cars as $key => $item) {
            foreach ($item as $key => $oneCar) {

                $enginePower = $oneCar["enginePower"];
                $acceleration = $oneCar["acceleration"];
                $range = $this->getNorm();
                $newEnginePower = null;
                $newAcceleration = null;

                if ($this->checkTheRange($enginePower, $range["enginePowerFrom"], $range["enginePowerTo"])) {
                    $newEnginePower = $enginePower;
                } else {
                    $newEnginePower = $this->getAverage($allEnginePower);
                }

                if ($this->checkTheRange($acceleration, $range["accelerationFrom"], $range["accelerationTo"])) {
                    $newAcceleration = $acceleration;
                } else {
                    $newAcceleration = $this->getAverage($allAcceleration);
                }


                $vehicle = new Car($item[$key]['brand'], $item[$key]['model'], $newEnginePower, $newAcceleration, false);
                $em->persist($vehicle);
                $em->flush();


            }
        }
        return $this->render('default/file.html.twig', array(
            'data' => $data,
        ));
    }

    /**
     * @Route("/data-processing")
     */
    public function dataProcessingAction(Request $request)
    {
        $car = new Car();
        $cars = $car->getOriginalCars($this->getDoctrine()->getManager());
        $enginePower = $this->getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = $this->getAccelerations($this->getDoctrine()->getManager(), false);

        return $this->render('default/dataProcessing.html.twig', array(
            'cars' => $cars,
            'norm' => $this->getNorm(),
            'averageEnginepower' => $this->getAverage($enginePower),
            'averageAcceleration' => $this->getAverage($acceleration),
        ));
    }

    /**
     * @Route("/data-analysis")
     */
    public function dataAnalysisAction(Request $request)
    {
        $enginePower = $this->getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = $this->getAccelerations($this->getDoctrine()->getManager(), false);

        return $this->render('default/dataAnalysis.html.twig', array(
            'minEnginepower' => min($enginePower),
            'maxEnginepower' => max($enginePower),
            'minAcceleration' => min($acceleration),
            'maxAcceleration' => max($acceleration),

            'medianEnginepower' => $this->getMedian($enginePower),
            'medianAcceleration' => $this->getMedian($acceleration),

            'averageEnginepower' => $this->getAverage($enginePower),
            'averageAcceleration' => $this->getAverage($acceleration),

            'standardDeviationEnginepower' => $this->getStandardDeviation($enginePower),
            'standardDeviationAcceleration' => $this->getStandardDeviation($acceleration),

            'quartile1Enginepower' => $this->getQuartile(1, $enginePower),
            'quartile2Enginepower' => $this->getQuartile(2, $enginePower),
            'quartile3Enginepower' => $this->getQuartile(3, $enginePower),
            'quartile1Acceleration' => $this->getQuartile(1, $acceleration),
            'quartile2Acceleration' => $this->getQuartile(2, $acceleration),
            'quartile3Acceleration' => $this->getQuartile(3, $acceleration),

            'linearRegression' => $this->getLinearRegression($enginePower, $acceleration),

            'pearsonCorrelation' => $this->getPearsonCorrelation($enginePower, $acceleration),
        ));
    }

    /**
     * @Route("/estimation")
     */
    public function estimationAction(Request $request)
    {
        $quantity = floatval($request->request->get('data', 5));

        $enginePower = $this->getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = $this->getAccelerations($this->getDoctrine()->getManager(), false);
        $linearRegression = $this->getLinearRegression($enginePower, $acceleration);
        $norm = $this->getNorm();

        $newEnginePower = array();
        for ($i = 0; $i < $quantity; $i++) {
            $newEnginePower[] = rand($norm["enginePowerFrom"], $norm["enginePowerTo"]);
        }

        return $this->render('default/estimation.html.twig', array(
            'newEnginePower' => $newEnginePower,
            'a' => $linearRegression["a"],
            'b' => $linearRegression["b"],
            'norm' => $this->getNorm(),
        ));
    }

    /**
     * @Route("/calculate")
     */
    public function calculateAction(Request $request)
    {
        $formValue = floatval($request->request->get('formValue', null));
        $formUnit = $request->request->get('formUnit', null);
        $enginePower = $this->getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = $this->getAccelerations($this->getDoctrine()->getManager(), false);

        $data = array();
        $data["unit"] = $formUnit == "KM" ? "s" : "KM";

        switch ($formUnit) {
            case "KM":
                $linearRegression = $this->getLinearRegression($enginePower, $acceleration);
                $data["value"] = $linearRegression["a"] * $formValue + $linearRegression["b"];
                break;
            case "s":
                $linearRegression = $this->getLinearRegression($acceleration, $enginePower);
                $data["value"] = $linearRegression["a"] * $formValue + $linearRegression["b"];
                break;
        }

        return $this->render('default/calculate.html.twig', array(
            'data' => $data,
        ));
    }

    private function getAccelerations($em, $original)
    {
        $car = new Car();
        $cars = $original ? $car->getOriginalCars($em) : $car->getProcessedCars($em);

        $acceleration = array();

        foreach ($cars as $car) {
            $acceleration[] = $car->getAcceleration();
        }
        return $acceleration;
    }

    private function getEnginesPower($em, $original)
    {
        $car = new Car();
        $cars = $original ? $car->getOriginalCars($em) : $car->getProcessedCars($em);

        $enginePower = array();

        foreach ($cars as $car) {
            $enginePower[] = $car->getEnginepower();
        }
        return $enginePower;
    }

    private function getMedian($array)
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

    private function deleteAllCars($em)
    {
        $car = new Car();
        $car->deleteAllCars($em);
    }

    private function getAverage($array)
    {
        return round(array_sum($array) / count($array), 3);
    }

    private function getStandardDeviation($array)
    {
        $tmpArr = array();

        foreach ($array as $item) {
            $tmpArr[] = ($item - $this->getAverage($array)) * ($item - $this->getAverage($array));
        }
        $standardDeviation = round(sqrt(array_sum($tmpArr) / (count($array) - 1)), 3);

        return $standardDeviation;
    }

    private function getPearsonCorrelation($arrayA, $arrayB)
    {
        $r = null;
        $arrXY = array();

        foreach ($arrayA as $x) {
            foreach ($arrayB as $y) {
                $arrXY[] = $x * $y;
            }
        }
        $r = ((1 / count($arrayA) * array_sum($arrXY)) - ($this->getAverage($arrayA) * $this->getAverage($arrayB))) / ($this->getStandardDeviation($arrayA) * $this->getStandardDeviation($arrayB));

        return array("r" => round($r, 3), "rModulus" => round(abs($r), 3));
    }

    private function getQuartile($num, $array)
    {
        sort($array);
        $index = round((count($array) + 1) * $num / 4) - 1;

        return $array[$index];
    }

    private function getLinearRegression($arrayA, $arrayB)
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

    private function getNorm()
    {
        return array("enginePowerFrom" => 70, "enginePowerTo" => 190, "accelerationFrom" => 8, "accelerationTo" => 15);
    }


    private function checkTheRange($data, $from, $to)
    {
        return (($data == $from || $data == $to) || ($data > $from && $data < $to));
    }


}
