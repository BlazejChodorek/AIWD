<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class StartController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function startAction()
    {
        return $this->render('AppBundle:Start:start.html.twig', array(// ...
        ));
    }

}
