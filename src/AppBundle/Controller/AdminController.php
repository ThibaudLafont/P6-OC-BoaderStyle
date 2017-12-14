<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick\Category;
use AppBundle\Entity\Trick\Trick;
use AppBundle\Form\Trick\CategoryType;
use AppBundle\Form\Trick\TrickType;
use AppBundle\Form\Trick\TrickImageType;

use AppBundle\Form\User\RegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin/add/trick", name="trick_add")
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
     * @Route("/admin/edit/trick/{id}", name="trick_edit")
     */
    public function editAction(Request $request, $id)
    {

        // Get the trick related to asked id
        $trick = $this->getDoctrine()->getRepository('AppBundle:Trick\Trick')->find($id);

        // Form handling is same as addAction one

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
     * @Route("/admin/delete/trick/{id}", name="trick_delete")
     */
    public function deleteAction($id){

        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('AppBundle:Trick\Trick')->find($id); // Get the trick related to asked id

        $em->remove($trick);
        $em->flush();

        return $this->redirectToRoute('trick_list');

    }

    /**
     * @Route("/admin/add/category", name="category_add")
     */
    public function addCategory(Request $request){
        $category = new Category();

        // Creation of form
        $form = $this->get('form.factory')->create(CategoryType::class, $category);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

        }

        return $this->render('trick/_category_form.html.twig', ['form' => $form->createView()]);
    }

}
