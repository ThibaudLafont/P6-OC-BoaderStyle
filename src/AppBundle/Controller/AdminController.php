<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trick\Category;
use AppBundle\Entity\Trick\Trick;
use AppBundle\Form\Type\Trick\CategoryType;
use AppBundle\Form\Type\Trick\TrickType;
use AppBundle\Form\Type\Trick\TrickImageType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 * @package AppBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * This route lead to the form wich allow an authentificated user to add a new trick
     * Handle the submission of the form to
     *
     * @Route("/admin/add/trick", name="trick_add")
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        // Creation of form
        $trick = new Trick();
        $form = $this->get('form.factory')->create(TrickType::class, $trick);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            // Persist the trick
            $em = $this->getDoctrine()->getManager();
            $em->persist($trick);
            $em->flush();

            // In case of succed, redirection to trick_list with flash message
            $this->addFlash(
                'success',
                "Vous bien ajouté un article"
            );

            return $this->redirectToRoute('trick_list');

        }

        // If the form is not submitted, render the form view
        return $this->render('trick/_form.html.twig', ['form' => $form->createView()]);

    }

    /**
     * This route lead to the form wich allow an authentificated user to edit a existent trick
     * Handle the submission of the form to
     *
     * @Route("/admin/edit/trick/{id}", name="trick_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {

        // Get the trick related to asked id
        $trick = $this->getDoctrine()->getRepository('AppBundle:Trick\Trick')->find($id);

        // Creation of form
        $form = $this->get('form.factory')->create(TrickType::class, $trick);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Vous bien modifié "' . $trick->getName() . '"');
            return $this->redirectToRoute('trick_list');

        }

        return $this->render(
            'trick/_form.html.twig',
            ['form' => $form->createView(), 'title' => $trick->getName()]
        );
    }

    /**
     * This route lead to the form wich allow an authentificated user to delete a trick
     *
     * @Route("/admin/delete/trick/{id}", name="trick_delete")
     * @Method({"POST"})
     */
    public function deleteAction($id){
        // Get EntityManager and Trick Manager
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('AppBundle:Trick\Trick')->find($id); // Get the trick related to asked id

        // Remove the trick related to ID found in URL
        $em->remove($trick);
        $em->flush();

        // Redirect the user after success, add a flash message for inform user
        $this->addFlash('success', 'Vous bien supprimé "' . $trick->getName() . '"');
        return $this->redirectToRoute('trick_list');  // Return to the home page
    }

    /**
     * This route lead to the form wich allow an authentificated user to add a new trick's category
     * Handle the submission of the form to
     *
     * @Route("/admin/add/category", name="category_add")
     * @Method({"GET", "POST"})
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


            $this->addFlash('success', 'Vous avez ajouté la catégorie "' . $category->getName() . '"');
            return $this->redirectToRoute('trick_list');
        }

        return $this->render('trick/_category_form.html.twig', ['form' => $form->createView()]);
    }

}
