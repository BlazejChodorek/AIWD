<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PopupController extends Controller
{
    /**
     * @Route("/popup")
     */
    public function popupAction(Request $request)
    {
        $action = $request->request->get('action', null);
        switch ($action) {
            case "logout":
                return $this->render('popup/logout.html.twig', array());
            case "estimation":
                return $this->render('popup/estimation.html.twig', array());
        }
    }

}
