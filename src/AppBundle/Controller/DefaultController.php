<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helpers\StatisticsHelper;
use AppBundle\Helpers\CarHelper;

class DefaultController extends Controller
{

    /**
     * @Route("/app")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', array(
            'norm' => CarHelper::getNorm(),
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
        CarHelper::deleteAllCars($em);

        foreach ($cars as $item) {
            foreach ($item as $key => $oneCar) {
                CarHelper::insertNewCar($em, $item[$key]['brand'], $item[$key]['model'], $item[$key]['enginePower'], $item[$key]['acceleration'], true);
            }
        }

        $allEnginePower = CarHelper::getEnginesPower($this->getDoctrine()->getManager(), true);
        $allAcceleration = CarHelper::getAccelerations($this->getDoctrine()->getManager(), true);

        foreach ($cars as $key => $item) {
            foreach ($item as $key => $oneCar) {

                $enginePower = $oneCar["enginePower"];
                $acceleration = $oneCar["acceleration"];
                $range = CarHelper::getNorm();
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

                CarHelper::insertNewCar($em, $item[$key]['brand'], $item[$key]['model'], $newEnginePower, $newAcceleration, false);
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
        $cars = CarHelper::getAllCars($this->getDoctrine()->getManager(), false);
        $enginePower = CarHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = CarHelper::getAccelerations($this->getDoctrine()->getManager(), false);

        return $this->render('default/dataProcessing.html.twig', array(
            'cars' => $cars,
            'norm' => CarHelper::getNorm(),
            'averageEnginepower' => StatisticsHelper::getAverage($enginePower),
            'averageAcceleration' => StatisticsHelper::getAverage($acceleration),
        ));
    }

    /**
     * @Route("/data-analysis")
     */
    public function dataAnalysisAction(Request $request)
    {
        $enginePower = CarHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = CarHelper::getAccelerations($this->getDoctrine()->getManager(), false);

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

    /**
     * @Route("/distant-points")
     */
    public function distantPointsAction(Request $request)
    {
        $enginePower = CarHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = CarHelper::getAccelerations($this->getDoctrine()->getManager(), false);

        return $this->render('default/distantPoints.html.twig', array(
            'cars' => StatisticsHelper::getDistantPoints($this->getDoctrine()->getManager(), $enginePower, $acceleration),
        ));
    }

    /**
     * @Route("/estimation")
     */
    public function estimationAction(Request $request)
    {
        $quantity = floatval($request->request->get('data', 15));

        $enginePower = CarHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = CarHelper::getAccelerations($this->getDoctrine()->getManager(), false);
        $linearRegression = StatisticsHelper::getLinearRegression($enginePower, $acceleration);
        $norm = CarHelper::getNorm();

        $newEnginePower = array();
        for ($i = 0; $i < $quantity; $i++) {
            $newEnginePower[] = rand($norm["enginePowerFrom"], $norm["enginePowerTo"]);
        }

        return $this->render('default/estimation.html.twig', array(
            'newEnginePower' => $newEnginePower,
            'a' => $linearRegression["a"],
            'b' => $linearRegression["b"],
            'norm' => $norm,
        ));
    }

    /**
     * @Route("/calculate")
     */
    public function calculateAction(Request $request)
    {
        $formValue = floatval($request->request->get('formValue', null));
        $formUnit = $request->request->get('formUnit', null);
        $enginePower = CarHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = CarHelper::getAccelerations($this->getDoctrine()->getManager(), false);

        $data = array();
        $data["validate"] = null;
        $data["value"] = null;
        $data["unit"] = $formUnit == "KM" ? "s" : "KM";

        switch ($formUnit) {
            case "KM":
                if (StatisticsHelper::checkTheRange($formValue, CarHelper::getNorm()["enginePowerFrom"], CarHelper::getNorm()["enginePowerTo"])) {
                    $linearRegression = StatisticsHelper::getLinearRegression($enginePower, $acceleration);
                    $data["value"] = $linearRegression["a"] * $formValue + $linearRegression["b"];
                } else {
                    $data["validate"] = "podaj wartość z przedziału dla mocy silnika";
                }
                break;
            case "s":
                if (StatisticsHelper::checkTheRange($formValue, CarHelper::getNorm()["accelerationFrom"], CarHelper::getNorm()["accelerationTo"])) {
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
        $enginePower = CarHelper::getEnginesPower($this->getDoctrine()->getManager(), false);
        $acceleration = CarHelper::getAccelerations($this->getDoctrine()->getManager(), false);
        $linearRegression = StatisticsHelper::getLinearRegression($enginePower, $acceleration);

        return new JsonResponse(array(
            "enginePower" => $enginePower,
            "acceleration" => $acceleration,
            'a' => $linearRegression["a"],
            'b' => $linearRegression["b"],
            'norm' => CarHelper::getNorm(),
            'enginePowerQ1' => StatisticsHelper::getQuartile(1, $enginePower),
            'accelerationQ1' => StatisticsHelper::getQuartile(1, $acceleration),
            'enginePowerQ3' => StatisticsHelper::getQuartile(3, $enginePower),
            'accelerationQ3' => StatisticsHelper::getQuartile(3, $acceleration),
        ));
    }


}