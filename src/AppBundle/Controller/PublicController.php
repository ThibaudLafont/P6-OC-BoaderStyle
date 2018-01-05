<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message\Message;
use AppBundle\Entity\Trick\Category;
use AppBundle\Form\Type\MessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class PublicController extends Controller
{
    /**
     * Home page of the website, display a list of all tricks
     *
     * @Route("/", name="trick_list")
     */
    public function listAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();                                // Get Entity Manager
        $tricks = $em->getRepository('AppBundle:Trick\Trick')->findAll();        // Get all tricks
        $categories = $em->getRepository('AppBundle:Trick\Category')->findAll(); // Get all categories for filter feature

        // Render the home page
        return $this->render('trick/_list.html.twig', compact('tricks', 'categories'));

    }

    /**
     * Find all tricks witch belong to a category and render list template
     *
     * @Route("/tricks/{cat_name}", name="category_trick_list")
     */
    public function listByCategoryAction($cat_name)
    {
        // Get Doctrine Categories Entity Manager
        $cm = $this->getDoctrine()->getManager()->getRepository('AppBundle:Trick\Category');  // Get the Category Entity Manager

        // Get all categories for filter option
        $categories = $cm->findAll();

        // Then loop on every found entry to check if one matche with URL given name
        $category = null;                        // Init $category for below success test
        foreach($categories as $cat)
        {
            if($cat->getName() === $cat_name){
                $category = $cat;               // If a category match, store it
                break;
            }
        }

        // If no category is related to the URL given name
        if(is_null($category)){
            $this->addFlash('error', 'Catégorie introuvable');  // First add an error flash message
            return $this->redirectToRoute('trick_list');        // Then redirect to home_page and stop execution
        }

        // Get all the stored tricks in asked category
        $tricks = $category->getTricks();

        // Render the list_template with found tricks and category collection
        return $this->render('trick/_list.html.twig', compact('tricks', 'categories'));
    }


    /**
     * Show page of a trick, display chat messages related to the trick
     * Authentificate user can post new messages and anon user only can read then
     * Handle the submission of the form too
     *
     * @Route("/trick/{id}", name="trick_show")
     */
    public function showAction(Request $request, $id)
    {
        // Getting trick related to given id
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Trick\Trick');
        $trick = $em->find($id);

        // Creation of new message entity
        $message = new Message();
        $message->setTrick($trick);

        // Creation of form
        $form = $this->get('form.factory')->create(MessageType::class, $message);
        $form->handleRequest($request);

        // Action if submitted data are valid and user is logged
        if ($form->isSubmitted() && $form->isValid() && $this->isGranted('ROLE_ADMIN')) {

            // Get the manager, then persist
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            // TODO: add flash message

            // TODO: Pertinent ?
            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        // In other cases, render the page in get
        return $this->render('trick/_show.html.twig', ['trick' => $trick, 'form' => $form->createView()]);
    }

    /**
     * Learn more about cookies policy
     *
     * @Route("/utilisation-cookies", name="cookies_chart")
     */
    public function cookiesChartAction(){
        return $this->render('app/_cookie_chart.html.twig');
    }

}
