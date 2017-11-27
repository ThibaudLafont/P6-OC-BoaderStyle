<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home_trickList")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Figure');
        $tricks = $em->findAll();

        return $this->render('list.html.twig', compact('tricks'));
    }
}
