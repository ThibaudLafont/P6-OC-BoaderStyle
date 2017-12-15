<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message\Message;
use AppBundle\Entity\User\UserImage;
use AppBundle\Entity\User\User;
use AppBundle\Form\Type\MessageType;
use AppBundle\Form\Type\User\LoginType;
use AppBundle\Form\Type\User\RegisterType;
use AppBundle\Service\TrickImageUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PublicController extends Controller
{
    /**
     * @Route("/", name="trick_list")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Trick\Trick');
        $tricks = $em->findAll();

        return $this->render('trick/_list.html.twig', compact('tricks'));
    }

    /**
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

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);

        }

        return $this->render('trick/_show.html.twig', ['trick' => $trick, 'form' => $form->createView()]);
    }

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        // Creation of new User entity
        $user = new User();
        $img = new UserImage();
        $user->setImg($img);

        // Creation of form
        $form = $this->get('form.factory')->create(RegisterType::class, $user);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('trick_list');

        }

        return $this->render('user/_register.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/login", name="user_login")
     */
    public function loginAction(Request $request){
        // Creation of new User entity
        $user = new User();

        // Creation of form
        $form = $this->get('form.factory')->create(LoginType::class, $user);

        return $this->render('user/_login.html.twig', ['form' => $form->createView()]);
    }
}
