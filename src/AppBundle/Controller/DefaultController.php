<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helpers\StatisticsHelper;

class DefaultController extends Controller
{

    /**
     * @Route("/app")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', array(
            'norm' => StatisticsHelper::getNorm(),
        ));
    }

    /**
     * @Route("/file")
     */
    public function fileAction(Request $request)
    {
        $data = $request->request->get('data', null);
        $cars = json_decode($data, true);
        $em = $this->getDoctrine()->getManager();
        StatisticsHelper::deleteAllCars($em);

        foreach ($cars as $item) {
            foreach ($item as $key => $oneCar) {
                $vehicle = new Car($item[$key]['brand'], $item[$key]['model'], $item[$key]['enginePower'], $item[$key]['acceleration'], true);
                $em->persist($vehicle);
                $em->flush();
            }
        }

        $allEnginePower = StatisticsHelper::getEnginesPower($this->getDoctrine()->getManager(), true);
        $allAcceleration = StatisticsHelper::getAccelerations($this->getDoctrine()->getManager(), true);

        foreach ($cars as $key => $item) {
            foreach ($item as $key => $oneCar) {

                $enginePower = $oneCar["enginePower"];
                $acceleration = $oneCar["acceleration"];
                $range = StatisticsHelper::getNorm();
                $newEnginePower = null;
                $newAcceleration = null;

                if (StatisticsHelper::checkTheRange($enginePower, $range["enginePowerFrom"], $range["enginePowerTo"])) {
                    $newEnginePower = $enginePower;
                } else {
                    $newEnginePower = StatisticsHelper::getAverage($allEnginePower);
                }

                if (StatisticsHelper::checkTheRange($acceleration, $range["accelerationFrom"], $range["accelerationTo"])) {
                    $newAcceleration = $acceleration;
                } else {
                    $newAcceleration = StatisticsHelper::getAverage($allAcceleration);
                }

                $vehicle = new Car($item[$key]['brand'], $item[$key]['model'], $newEnginePower, $newAcceleration, false);
                $em->persist($vehicle);
                $em->flush();
            }
        }
        return $this->render('default/file.html.twig', array(
            'data' => null,//$data,
        ));
    }

    /**
     * @Route("/data-processing")
     */
    public function dataProcessingAction(Request $request)
    {
        $car = new Car();
        $cars = $car->getOriginalCars($this->getDoctrine()->getManager());
        $enginePower = StatisticsHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = StatisticsHelper::getAccelerations($this->getDoctrine()->getManager(), false);

        return $this->render('default/dataProcessing.html.twig', array(
            'cars' => $cars,
            'norm' => StatisticsHelper::getNorm(),
            'averageEnginepower' => StatisticsHelper::getAverage($enginePower),
            'averageAcceleration' => StatisticsHelper::getAverage($acceleration),
        ));
    }

    /**
     * @Route("/data-analysis")
     */
    public function dataAnalysisAction(Request $request)
    {
        $enginePower = StatisticsHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = StatisticsHelper::getAccelerations($this->getDoctrine()->getManager(), false);

        return $this->render('default/dataAnalysis.html.twig', array(
            'minEnginepower' => min($enginePower),
            'maxEnginepower' => max($enginePower),
            'minAcceleration' => min($acceleration),
            'maxAcceleration' => max($acceleration),

            'medianEnginepower' => StatisticsHelper::getMedian($enginePower),
            'medianAcceleration' => StatisticsHelper::getMedian($acceleration),

            'averageEnginepower' => StatisticsHelper::getAverage($enginePower),
            'averageAcceleration' => StatisticsHelper::getAverage($acceleration),

            'standardDeviationEnginepower' => StatisticsHelper::getStandardDeviation($enginePower),
            'standardDeviationAcceleration' => StatisticsHelper::getStandardDeviation($acceleration),

            'quartile1Enginepower' => StatisticsHelper::getQuartile(1, $enginePower),
            'quartile2Enginepower' => StatisticsHelper::getQuartile(2, $enginePower),
            'quartile3Enginepower' => StatisticsHelper::getQuartile(3, $enginePower),
            'quartile1Acceleration' => StatisticsHelper::getQuartile(1, $acceleration),
            'quartile2Acceleration' => StatisticsHelper::getQuartile(2, $acceleration),
            'quartile3Acceleration' => StatisticsHelper::getQuartile(3, $acceleration),

            'linearRegression' => StatisticsHelper::getLinearRegression($enginePower, $acceleration),

            'pearsonCorrelation' => StatisticsHelper::getPearsonCorrelation($enginePower, $acceleration),
        ));
    }

//    /**
//     * @Route("/distant-points")
//     */
//    public function distantPointsAction(Request $request)
//    {
//        $enginePower = $this->getEnginesPower($this->getDoctrine()->getManager(), false);
//        $acceleration = $this->getAccelerations($this->getDoctrine()->getManager(), false);
//
//        $enginePowerQ1 = $this->getQuartile(1, $enginePower);
//        $enginePowerQ3 = $this->getQuartile(3, $enginePower);
//        $enginePowerIRQ = $enginePowerQ3 - $enginePowerQ1;
//
//        $accelerationQ1 = $this->getQuartile(1, $acceleration);
//        $accelerationQ3 = $this->getQuartile(3, $acceleration);
//        $accelerationIRQ = $accelerationQ3 - $accelerationQ1;
//
//        $enginePowerDistantPoints = array();
//        $accelerationDistantPoints = array();
//
//        //xi < Q1 − 1, 5(IRQ)   ||   xi > Q3 + 1, 5(IRQ)
//        foreach ($enginePower as $x) {
//            if (($x < $enginePowerQ1 - (1.5 * $enginePowerIRQ)) || ($x > $enginePowerQ3 + (1.5 * $enginePowerIRQ))) {
//                $enginePowerDistantPoints[] = $x;
//            }
//        }

//        foreach ($acceleration as $y) {
//            if (($y < $accelerationQ1 - (1.5 * $accelerationIRQ)) || ($y > $accelerationQ3 + (1.5 * $accelerationIRQ))) {
//                $accelerationDistantPoints[] = $y;
//            }
//        }
//
//        $cars = array();
//
//        foreach ($enginePowerDistantPoints as $item) {
//            $cars[] = $this->getCarsByEnginePower($this->getDoctrine()->getManager(), $item);
//        }
//
//        foreach ($accelerationDistantPoints as $item) {
//            $cars[] = $this->getCarsByAccleration($this->getDoctrine()->getManager(), $item);
//        }
//
//
//        return $this->render('default/dataAnalysis.html.twig', array(
//            'cars' => $cars,
//        ));
//    }

    /**
     * @Route("/estimation")
     */
    public function estimationAction(Request $request)
    {
        $quantity = floatval($request->request->get('data', 15));

        $enginePower = StatisticsHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = StatisticsHelper::getAccelerations($this->getDoctrine()->getManager(), false);
        $linearRegression = StatisticsHelper::getLinearRegression($enginePower, $acceleration);
        $norm = StatisticsHelper::getNorm();

        $newEnginePower = array();
        for ($i = 0; $i < $quantity; $i++) {
            $newEnginePower[] = rand($norm["enginePowerFrom"], $norm["enginePowerTo"]);
        }

        return $this->render('default/estimation.html.twig', array(
            'newEnginePower' => $newEnginePower,
            'a' => $linearRegression["a"],
            'b' => $linearRegression["b"],
            'norm' => StatisticsHelper::getNorm(),
        ));
    }

    /**
     * @Route("/calculate")
     */
    public function calculateAction(Request $request)
    {
        $formValue = floatval($request->request->get('formValue', null));
        $formUnit = $request->request->get('formUnit', null);
        $enginePower = StatisticsHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = StatisticsHelper::getAccelerations($this->getDoctrine()->getManager(), false);

        $data = array();
        $data["validate"] = null;
        $data["value"] = null;
        $data["unit"] = $formUnit == "KM" ? "s" : "KM";

        switch ($formUnit) {
            case "KM":
                if (StatisticsHelper::checkTheRange($formValue, StatisticsHelper::getNorm()["enginePowerFrom"], StatisticsHelper::getNorm()["enginePowerTo"])) {
                    $linearRegression = StatisticsHelper::getLinearRegression($enginePower, $acceleration);
                    $data["value"] = $linearRegression["a"] * $formValue + $linearRegression["b"];
                } else {
                    $data["validate"] = "podaj wartość z przedziału dla mocy silnika";
                }
                break;
            case "s":
                if (StatisticsHelper::checkTheRange($formValue, StatisticsHelper::getNorm()["accelerationFrom"], StatisticsHelper::getNorm()["accelerationTo"])) {
                    $linearRegression = StatisticsHelper::getLinearRegression($acceleration, $enginePower);
                    $data["value"] = $linearRegression["a"] * $formValue + $linearRegression["b"];
                } else {
                    $data["validate"] = "podaj wartość z przedziału dla przyspieszenia";
                }
                break;
        }

        return $this->render('default/calculate.html.twig', array(
            'data' => $data,
        ));
    }

    /**
     * @Route("/linearRegression")
     */
    public function linearRegressionAction(Request $request)
    {

        $enginePower = StatisticsHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = StatisticsHelper::getAccelerations($this->getDoctrine()->getManager(), false);
        $linearRegression = StatisticsHelper::getLinearRegression($enginePower, $acceleration);


        return new JsonResponse(array(
            "enginePower" => $enginePower,
            "acceleration" => $acceleration,
            'a' => $linearRegression["a"],
            'b' => $linearRegression["b"],
            'norm' => StatisticsHelper::getNorm(),
            'enginePowerQ1' => StatisticsHelper::getQuartile(1, $enginePower),
            'accelerationQ1' => StatisticsHelper::getQuartile(1, $acceleration),
            'enginePowerQ3' => StatisticsHelper::getQuartile(3, $enginePower),
            'accelerationQ3' => StatisticsHelper::getQuartile(3, $acceleration),
        ));
    }


}


