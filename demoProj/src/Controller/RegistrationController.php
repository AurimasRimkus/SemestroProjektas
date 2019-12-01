<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param AuthorizationCheckerInterface $authChecker
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, AuthorizationCheckerInterface $authChecker, \Swift_Mailer $mailer)
    {
        if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('index');
        }

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $time = new \DateTime();
            $this->setInfoForNewUser($user);

            $profile = new Profile();
            $profile->setEmail($user->getEmail());
            $profile->setUser($user);

            $user->setRegistrationToken($this->getRegistrationToken());

            $send = $this->get('app.email_activation_service');
            $send->SendActivationEmail($user->getUsername(), $user->getEmail(), $user->getRegistrationToken(), $mailer);

            $em->persist($profile);
            $em->persist($user);
            $em->flush();

            return $this->render('login/login.html.twig', array(
                'success'=> "User ". $user->getUsername(). " was created.",
                'last_username' => $user->getUsername()
            ));
        }

        return $this->render('register/register.html.twig', array(
           'form'=>$form->createView(),
        ));
    }
	
	public function setInfoForNewUser($user) {
            $user->setRegistrationDate($time);
            $user->setLastLoginTime($time);

            $user->setIsActive(false);
            $user->setIsDeleted(false);
			
            $user->setRole(1);
	}
	
	public function getRegistrationToken() {
		$seed = random_bytes(20);
		return $this->createRegistrationTokenFromSeed($seed);
	}
	
	public function createRegistrationTokenFromSeed ($seed) {
		$registrationToken = base64_encode($seed);
        $registrationToken = str_replace("/","",$registrationToken); // because / will make errors with routes
		return $registrationToken;
	}

    /**
     * @Route("/activate/{token}", name="activateAccount")
     */
    public function Activate(Request $request, $token)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['registrationToken' => $token]);
        if($user == null)
        {
            return $this->redirectToRoute('index');
        }
        $em = $this->getDoctrine()->getManager();
        $this->makeUserActivated($user);
        $em->flush();
        return $this->redirectToRoute('login');
    }
	
	public function makeUserActivated ($user) {
		$user->setIsActive(true);
        $user->setRegistrationToken(null);
	}

    /**
     * @Route("/resend/", name="resendActivationMail")
     */
    public function resendActivationMail(\Swift_Mailer $mailer){
        $user = $this->getUser();
        if($user == null || $user->getIsActive() == true){
            return $this->render('index.html.twig', array(
                'error'=>'Your account is already activated',
            ));
        }
        $send = $this->get('app.email_activation_service');
        $send->SendActivationEmail($user->getUsername(), $user->getEmail(), $user->getRegistrationToken(), $mailer);
        return $this->render('index.html.twig', array(
           'success'=>'Activation e-mail resent!',
        ));
    }
}
