<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message\Message;
use AppBundle\Entity\Trick\Category;
use AppBundle\Form\Type\MessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class PublicController extends Controller
{
    /**
     * Home page of the website, display a list of all tricks
     *
     * @Route("/", name="trick_list")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {
        // Store manager
        $em = $this->getDoctrine()->getManager();

        // Store all tricks
        $tricks = $em->getRepository('AppBundle:Trick\Trick')
                    ->findBy([], ['name' => 'ASC']);

        // Store all categories for filter
        $categories = $em->getRepository('AppBundle:Trick\Category')
                    ->findBy([], ['name' => 'ASC']);

        // Render the home page
        return $this->render('trick/_list.html.twig', compact('tricks', 'categories'));

    }

    /**
     * Find all tricks witch belong to a category and render list template
     *
     * @Route(
     *     "/{slugName}/tricks",
     *     name="category_trick_list",
     *     requirements={
     *          "cat"="([a-z]+|-)+"
     *     }
     * )
     * @Method({"GET"})
     */
    public function listByCategoryAction($slugName)
    {
        // Get Doctrine Categories Entity Manager
        $cm = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Trick\Category');  // Get the Category Entity Manager

        // Then loop on every found entry to check if one matche with URL given name
        $category = $cm->findOneBy(['slugName' => $slugName]);

        // If no category is related to the URL given name
        if(is_null($category)){
            $this->addFlash('error', 'Catégorie introuvable');  // First add an error flash message
            return $this->redirectToRoute('trick_list');        // Then redirect to home_page and stop execution
        }

        // Get all the stored tricks in asked category
        $tricks = $category->getTricks();

        // Get all categories for filter option
        $categories = $cm->findBy([],['name' => 'ASC']);

        // Render the list_template with found tricks and category collection
        return $this->render('trick/_list.html.twig', compact('tricks', 'categories'));
    }


    /**
     * Show page of a trick, display chat messages related to the trick
     * Authentificate user can post new messages and anon user only can read then
     * Handle the submission of the form too
     *
     * @Route(
     *     "/tricks/{slugName}/{chatPage}",
     *     name="trick_show"
     * )
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, $slugName, $chatPage = 1)
    {

        // Getting trick related to given id
        $objects = $this->getDoctrine()->getRepository('AppBundle:Trick\Trick')
            ->findWithMessages($slugName, $chatPage);

        // Store Trick
        $trick = $objects['trick'];

        // Creation of new message entity
        $message = new Message();
        $message->setTrick($trick);

        // Creation of form
        $form = $this->get('form.factory')->create(MessageType::class, $message);

        // Check if user is granted
        if($this->isGranted('ROLE_ADMIN')){
            // If granted, handle request
            $form->handleRequest($request);

            // Action if submitted data are valid and user is logged
            if ($form->isSubmitted() && $form->isValid()) {

                // Get the manager, then persist
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();

                // Add flash message
                $this->addFlash('success', 'Votre message a bien été posté');

                return $this->redirectToRoute('trick_show', ['slugName' => $trick->getSlugName()]);
            }
        }

        // In other cases, render the page in get
        return $this->render(
            'trick/_show.html.twig',
            [
                'trick' => $trick,
                'pgNbr' => $trick->getMessagesPagesNumber(),
                'messages'=> $objects['messages'],
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Learn more about cookies policy
     *
     * @Route("/utilisation-cookies", name="cookies_chart")
     * @Method({"GET"})
     */
    public function cookiesChartAction(){
        return $this->render('app/_cookie_chart.html.twig');
    }

}
