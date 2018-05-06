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
            $user->setRegistrationDate($time);
            $user->setLastLoginTime($time);

            $user->setIsActive(false);
            $user->setIsDeleted(false);

            $user->setRole(1);

            $profile = new Profile();
            $profile->setEmail($user->getEmail());
            $profile->setUser($user);

            $registrationToken = base64_encode(random_bytes(20));
            $registrationToken = str_replace("/","",$registrationToken); // because / will make errors with routes
            $user->setRegistrationToken($registrationToken);

            // Needs to fix activation letter sending
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
        $user->setIsActive(true);
        $user->setRegistrationToken(null);
        $em->flush();
        return $this->redirectToRoute('login');
    }
}
