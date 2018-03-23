<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ChangePasswordController extends Controller
{
    /**
     * @Route("/changePassword", name="changePassword")
     */
    public function changePassword(Request $request, AuthenticationUtils $authenticationUtils, UserPasswordEncoderInterface $encoder, AuthorizationCheckerInterface $authChecker)
    {
        // if user is not authenticated, redirect to index
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }
        $naujasPassword = new User();
        $user = $this->getUser();
        $error = "";

        $form = $this->createForm(ChangePasswordType::class, $naujasPassword);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            if($encoder->isPasswordValid($user, $naujasPassword->getPassword()))
            {
                //The old password which user used is correct.
                //So we can change the password in user object
                $user->setPassword($encoder->encodePassword($user, $naujasPassword->getNewPassword()));

                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('index');
            }else{
                $error = "Old password is not correct";
            }
        }


        return $this->render('changePassword.html.twig', array(
            'error' => $error,
            'form'=>$form->createView(),
        ));
    }

    public function show()
    {
        return $this->render('changePassword.html.twig', [

        ]);
    }
}
