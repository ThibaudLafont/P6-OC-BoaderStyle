<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="trick_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Trick');
        $tricks = $em->findAll();

        return $this->render('list.html.twig', compact('tricks'));
    }

    /**
     * @Route("/trick/{id}", name="trick_show")
     */
    public function Action(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Trick');
        $trick = $em->find($id);

        return $this->render('show.html.twig', compact('trick'));
    }
}
