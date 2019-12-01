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

/**
 * Class ChangePasswordController
 * @package App\Controller
 * @codeCoverageIgnore
 */
class ChangePasswordController extends Controller
{
    /**
     * @Route("/changePassword", name="changePassword")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $newPassword = new User();
        $user = $this->getUser();
        $error = "";

        $form = $this->createForm(ChangePasswordType::class, $newPassword);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            if($this->isPasswordValid($encoder, $user, $newPassword))
            {
                //The old password which user used is correct.
                //So we can change the password in user object
                $this->setUserEncodedPassword($encoder, $user, $newPassword);

                $em->persist($user);
                $em->flush();
                return $this->render('index.html.twig', array(
                    'success' => "Password was changed."
                ));
            }else{
                $error = "Old password is not correct.";
            }
        }


        return $this->render('changePassword.html.twig', array(
            'error' => $error,
            'form'=>$form->createView(),
        ));
    }

    public function isPasswordValid(UserPasswordEncoderInterface $encoder, User $user, User $userWithNewPassword) {
        return $encoder->isPasswordValid($user, $userWithNewPassword->getPassword());
    }

    public function setUserEncodedPassword(UserPasswordEncoderInterface $encoder, User $user, User $userWithNewPassword) {
        $user->setPassword($encoder->encodePassword($user, $userWithNewPassword->getNewPassword()));
    }

    public function show()
    {
        return $this->render('changePassword.html.twig', [

        ]);
    }
}
