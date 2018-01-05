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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{
    /**
     * Register route
     *
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {

        // Check if user is already logged in, if it's the case redirect and inform him
        if($this->isGranted('ROLE_ADMIN')){
            $this->addFlash('info', 'Vous êtes déjà inscris');
            return $this->redirectToRoute('trick_list');
        }

        // Creation of new User entity
        $user = new User();
        $img = new UserImage();
        $user->setImg($img);

        // Creation of form
        $form = $this->get('form.factory')->create(RegisterType::class, $user);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {

            // Get Entity Manager and persist the new user
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Add flash message and redirect to user_login
            $this->addFlash('success', 'Vous êtes bien inscris à SnowTricks, connectez-vous !');
            return $this->redirectToRoute('user_login');

        }

        // If no submission or invalid datas, render the form's view
        return $this->render('user/_register.html.twig', ['form' => $form->createView()]);

    }

    /**
     * Login route
     *
     * @Route("/login", name="user_login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils){

        // Check if user is already logged in, if it's the case redirect and inform him
        if($this->isGranted('ROLE_ADMIN')){
            $this->addFlash('info', 'Vous êtes déjà authentifié');
            return $this->redirectToRoute('trick_list');
        }

        // Creation of form
        $user = new User();
        $form = $this->get('form.factory')->create(LoginType::class, $user);

        // If there is an authentification problem, add flash for inform user
        $error = $authUtils->getLastAuthenticationError();
        if($error) $this->addFlash('error', 'Identifiants inconnus');


        // Render the view
        return $this->render('user/_login.html.twig', ['form' => $form->createView(), 'error' => $error]);

    }

    /**
     * This page is for the request for resetting a password
     * If username is knowed, a mail will be send to the related email with the link leading
     * to a valid user_resetpwd
     *
     * @Route("/user/mot-de-passe-oublie", name="user_resetpwd_form")
     */
    public function resetPwdFormAction(Request $request){

        // Check if user is already logged in, if it's the case redirect and inform him he can edit his profil
        if($this->isGranted('ROLE_ADMIN')){
            $this->addFlash('info', 'Vous êtes connecté, vous pouvez changer votre mot de pass ici');
            return $this->redirectToRoute('user_edit');
        }

        // Creation of form
        $user = new User();
        $form = $this->get('form.factory')->create(PwdResetRequestType::class, $user);
        $form->handleRequest($request);

        // Action if submitted data are valid
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Check if user exists
            $user = $em->getRepository('AppBundle:User\User')->findOneBy(['userName' => $user->getUserName()]);
            if(!is_null($user)){

                // Check if a reset request is already pending
                $pending_reset =
                    $em->getRepository('AppBundle:User\ResetPassword')
                        ->findOneBy([
                            'user' => $user,
                            'disabled' => false
                        ]);
                if(is_null($pending_reset)){

                    // Creation and persist of reset_password entity
                    $resetPassword = new ResetPassword();
                    $resetPassword->setUser($user);
                    $em->persist($resetPassword);
                    $em->flush();

                    // If knowed username, display a informative flash message
                    $this->addFlash(
                        'success',
                        'Votre demande de réinitialisation a bien été enregistrée, vérifiez vos emails.'
                    );
                }
                else{
                    // If a reset_password_request is already pending
                    $this->addFlash('error', 'Vous avez déjà fait une demande de réinitialisation de mot de passe, vérifiez vos emails.');
                }
            }else{
                // If no match with the given username
                $this->addFlash('error', 'Aucun compte connu avec cet identifiant');
            }
        }

        // If no submission, render the form
        return $this->render('user/_pwd_reset.html.twig', ['form' => $form->createView()]);

    }

    /**
     * Will display a reset password form if a request is pending thought the given url
     *
     * @Route("/user/reset-password/{token}", name="user_resetpwd")
     */
    public function resetPwdAction(Request $request, $token){

        // Try to find an input in DB from URL parsing
        $em = $this->getDoctrine()->getManager();
        $passwordReset =
            $em->getRepository('AppBundle:User\ResetPassword')
                ->findOneBy([
                    'token' => $token,
                    'disabled' => false
                ]);

        // If a pending request is found in DB
        if(!is_null($passwordReset)){

            // Creation of form
            $user = $passwordReset->getUser();
            $form = $this->get('form.factory')->create(PwdResetActionType::class, $user);
            $form->handleRequest($request);

            // Action if submitted data are valid
            if ($form->isSubmitted() && $form->isValid()) {

                // Disable the request
                $passwordReset->setDisabled(true);
                $em->flush();

                // Add a flash message, then redirect to user_login
                $this->addFlash('success', 'Votre mot de passe a été ré-initalisé, connectez-vous !');
                return $this->redirectToRoute('user_login');

            }

            // If URL lead to valid pending request in GET method, render the reset password form's view
            return $this->render('user/_pwd_reset.html.twig', ['form' => $form->createView()]);
        }
        else
        {
            // If no valid request is found though URL parsing
            $this->addFlash(  // Add Flash Message
                'error',
                'Aucune demande de modification de mot passe à cette adresse, ou la réinitialisation a déjà été effectuée'
            );
            return $this->redirectToRoute('user_login');  // Redirect to user_login
        }

    }

    /**
     * Allow the anthenticate user to edit his profil informations
     *
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

        // If no submission, render the form
        return $this->render('user/_edit.html.twig', ['form' => $form->createView(), 'user', $user]);
    }
}
