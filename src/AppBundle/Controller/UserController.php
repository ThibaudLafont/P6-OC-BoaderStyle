<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User\ResetPassword;
use AppBundle\Entity\User\User;
use AppBundle\Entity\User\UserImage;
use AppBundle\Form\Type\Trick\TrickImageType;
use AppBundle\Form\Type\User\EditType;
use AppBundle\Form\Type\User\LoginType;
use AppBundle\Form\Type\User\PwdResetActionType;
use AppBundle\Form\Type\User\PwdResetRequestType;
use AppBundle\Form\Type\User\PwdResetType;
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

            $this->addFlash('success', 'Vous êtes bien inscris à SnowTricks, connectez-vous !');

            return $this->redirectToRoute('user_login');

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


    /**
     * @Route("/user/mot-de-passe-oublie", name="user_resetpwd_form")
     */
    public function resetPwdFormAction(Request $request){
        // Creation of new User entity
        $user = new User();

        // Creation of form
        $form = $this->get('form.factory')->create(PwdResetRequestType::class, $user);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Check if user exists
            $user = $em->getRepository('AppBundle:User\User')->findOneBy(['userName' => $user->getUserName()]);
            if(!is_null($user)){

                // Check if a reset request is already pending
                $pending_reset = $em->getRepository('AppBundle:User\ResetPassword')->findOneBy(['user' => $user, 'disabled' => false]);
                if(is_null($pending_reset)){

                    // Creation and persist of reset_password entity
                    $resetPassword = new ResetPassword();
                    $resetPassword->setUser($user);
                    $em->persist($resetPassword);
                    $em->flush();

                    $this->addFlash('info', 'Votre demande de réinitialisation a bien été enregistrée, vérifiez vos emails.');
                }
                else{
                    $this->addFlash('error', 'Vous avez déjà fait une demande de réinitialisation de mot de passe, vérifiez vos emails.');
                }
            }else{
                $this->addFlash('error', 'Aucun compte connu avec cet identifiant');
            }
        }

        return $this->render('user/_pwd_reset.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user/reset-password/{token}", name="user_resetpwd")
     */
    public function resetPwdAction(Request $request, $token){
        $em = $this->getDoctrine()->getManager();
        $passwordReset = $em->getRepository('AppBundle:User\ResetPassword')->findOneBy(['token' => $token, 'disabled' => false]);

        if(!is_null($passwordReset)){
            // Creation of form
            $user = $passwordReset->getUser();
            $form = $this->get('form.factory')->create(PwdResetActionType::class, $user);
            $form->handleRequest($request);

            // Action if submitted data are valid
            if ($form->isSubmitted() && $form->isValid()) {

                $passwordReset->setDisabled(true);
                $em->flush();

                $this->addFlash('success', 'Votre mot de passe a été ré-initalisé, connectez-vous !');
                return $this->redirectToRoute('user_login');

            }

            return $this->render('user/_pwd_reset.html.twig', ['form' => $form->createView()]);
        }
        else
        {
            $this->addFlash('error', 'Aucune demande de modification de mot passe à cette adresse, ou la réinitialisation a déjà été effectuée');
            return $this->redirectToRoute('user_login');
        }

    }

    /**
     * @Route("/admin/user", name="user_edit")
     */
    public function userEditAction(Request $request){
        // Fetch user object from authentificated session
        $user = $this->getUser();

        // Creation of form
        $form = $this->get('form.factory')->create(EditType::class, $user);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            // Get Entity Manager and update user entry in DB
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            // Flash message and redirection to the tricks list
            $this->addFlash('success', 'Votre profil a bien été modifié !');
            return $this->redirectToRoute('trick_list');

        }

        return $this->render('user/_edit.html.twig', ['form' => $form->createView(), 'user', $user]);
    }
}
