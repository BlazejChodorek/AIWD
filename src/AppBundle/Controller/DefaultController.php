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

        foreach ($cars as $car) {
            foreach ($car as $key => $oneCar) {

                $vehicle = new Car($car[$key]['brand'], $car[$key]['model'], $car[$key]['enginePower'], $car[$key]['acceleration']);
                $this->getDoctrine()->getManager()->persist($vehicle);
                $this->getDoctrine()->getManager()->flush();
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


}
