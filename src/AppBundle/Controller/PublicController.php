<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller
{
    /**
     * @Route("/", name="trick_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Trick');
        $tricks = $em->findAll();

        return $this->render('trick/_list.html.twig', compact('tricks'));
    }

    /**
     * @Route("/trick/{id}", name="trick_show")
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Trick');
        $trick = $em->find($id);

        return $this->render('trick/_show.html.twig', compact('trick'));
    }
}
