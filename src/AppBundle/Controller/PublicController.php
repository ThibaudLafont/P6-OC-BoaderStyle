<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User\UserImage;
use AppBundle\Entity\User\User;
use AppBundle\Form\User\LoginType;
use AppBundle\Form\User\RegisterType;
use AppBundle\Service\Sluggifier;
use AppBundle\Service\TrickImageUploader;
use AppBundle\Service\Uploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Trick\Trick');
        $trick = $em->find($id);

        return $this->render('trick/_show.html.twig', compact('trick'));
    }

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
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
    public function loginAction(Request $request, SessionInterface $session){
        $user = new User();

        // Creation of form
        $form = $this->get('form.factory')->create(LoginType::class, $user);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            $expectUser = $this
                ->getDoctrine()
                ->getRepository('AppBundle:User\User')
                ->findOneBy([
                    'userName'=>$user->getUserName()
                ]);

            // When a user is found with same username/password
            if(sha1($user->getPlainPassword()) === $expectUser->getPassword()){
//                echo '<pre>';
//                var_dump($request->headers);
//                echo '</pre>';
            }

        }

        return $this->render('user/_login.html.twig', ['form' => $form->createView(), 'session' => $session]);
    }


    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction(SessionInterface $session){

        return $this->redirectToRoute('trick_list');

    }
}
