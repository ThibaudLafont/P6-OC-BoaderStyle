<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User\User;
use AppBundle\Entity\User\UserImage;
use AppBundle\Form\Type\Trick\TrickImageType;
use AppBundle\Form\Type\User\LoginType;
use AppBundle\Form\Type\User\RegisterType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
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
