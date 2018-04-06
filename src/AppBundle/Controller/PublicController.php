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
     * @Route("/{id}/tricks", name="category_trick_list")
     */
    public function listByCategoryAction($id)
    {
        // Get Doctrine Categories Entity Manager
        $cm = $this->getDoctrine()->getManager()
            ->getRepository('AppBundle:Trick\Category');  // Get the Category Entity Manager

        // Get all categories for filter option
        $categories = $cm->findBy([],['name' => 'ASC']);

        // Then loop on every found entry to check if one matche with URL given name
        $category = $cm->find($id);

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
     * @Route("/trick/{id}/{chatPage}", name="trick_show")
     */
    public function showAction(Request $request, $id, $chatPage = 1)
    {

        // Getting trick related to given id
        $trick = $this->getDoctrine()->getRepository('AppBundle:Trick\Trick')->find($id);

        // Getting the messages set from given chat page
        $all = $trick->getMessages();  // Get all messages
        $allCount = $all->count();     // Define number of messages

        if($allCount <= 10){
            $messages = $all;     // If there is under 10 messages store it
            $pgNbr = null;        // Set the page number to 0
        }
        else // Else messages needs to be paginate
        {
            $start = ($chatPage-1) * 10;          // Define witch is the first message
            $pgNbr = intval($allCount / 10) + 1;  // Then define number of pages
            if($start <= $allCount){
                $messages = $trick->getMessages($start);    // If message exists get the slice
            }else{                                          // If it doesn't redirect to first page
                return $this->redirectToRoute('trick_show', ['id' => $id, 'chatPage' => 1]);
            }
        }

        //
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

                // TODO: add flash message

                return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);
            }
        }

        // In other cases, render the page in get
        return $this->render(
            'trick/_show.html.twig',
            [
                'trick' => $trick,
                'pgNbr' => $pgNbr,
                'messages'=>$messages,
                'form' => $form->createView()
            ]
        );
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
