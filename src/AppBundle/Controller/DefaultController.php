<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
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
        $car = new Car();
        $car->deleteAllCars($em);

        foreach ($cars as $item) {
            foreach ($item as $key => $oneCar) {
                $vehicle = new Car($item[$key]['brand'], $item[$key]['model'], $item[$key]['enginePower'], $item[$key]['acceleration']);
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
        $cars = $car->getAllCars($this->getDoctrine()->getManager());

        return $this->render('default/dataProcessing.html.twig', array(
            'cars' => $cars,
        ));
    }

    /**
     * @Route("/data-analysis")
     */
    public function dataAnalysisAction(Request $request)
    {
        $car = new Car();
        $cars = $car->getAllCars($this->getDoctrine()->getManager());

        $enginePower = array();
        $acceleration = array();

        foreach ($cars as $car) {
            $enginePower[] = $car->getEnginepower();
            $acceleration[] = $car->getAcceleration();
        }

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
        ));
    }

    private function getMedian($array)
    {
        sort($array);
        $median = null;
        $quantity = count($array);

        if ($quantity % 2 == 0) {
            $ma = ($quantity - 1) / 2;
            $median = ($array[$ma] + $array[$ma + 1]) / 2;
        } else {
            $median = $array[($quantity - 1) / 2];
        }

        return $median;
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

        return round(sqrt(array_sum($tmpArr) / (count($array) - 1)), 3);
    }

    private function getQuartile($num, $array)
    {
        sort($array);
        $index = round((count($array) + 1) * $num / 4) - 1;

        return $array[$index];
    }

    public function getLinearRegression($arrayA, $arrayB)
    {
        $equation = null;
        $arrXY = array();
        $squareA = array();
        $a = null;
        $b = null;

        foreach ($arrayA as $x) {
            foreach ($arrayB as $y) {
                $arrXY[] = $x * $y;
            }
            $squareA[] = $x * $x;
        }

        $a = ((count($arrayA) * array_sum($arrXY)) - array_sum($arrayA) * array_sum($arrayB))
            / ((count($arrayA) * array_sum($squareA)) - (array_sum($arrayA) * array_sum($arrayA)));

        $b = (1 / count($arrayB)) * (array_sum($arrayB) - $a * array_sum($arrayA));

        return array("a" => $a, "b" => $b, "equation" => "Y = " . $a . " * X + " . $b);
    }


}
