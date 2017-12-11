<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick;
use AppBundle\Form\TrickType;
use AppBundle\Form\TrickImageType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/add/trick", name="trick_add")
     */
    public function addAction(Request $request)
    {
        $trick = new Trick();

        // Creation of form
        $form = $this->get('form.factory')->create(TrickType::class, $trick);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        return $this->render('trick/_form.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/edit/{id}", name="trick_edit")
     */
    public function editAction(Request $request, $id)
    {

        // Get the trick related to asked id
        $trick = $this->getDoctrine()->getRepository('AppBundle:Trick')->find($id);

        // Form handling is same as addAction one

        // Creation of form
        $form = $this->get('form.factory')->create(TrickType::class, $trick);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

//            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        return $this->render('trick/_form.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/delete/{id}", name="trick_delete")
     */
    public function deleteAction($id){

        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('AppBundle:Trick')->find($id); // Get the trick related to asked id

        $em->remove($trick);
        $em->flush();

        return $this->redirectToRoute('trick_list');

    }

}
