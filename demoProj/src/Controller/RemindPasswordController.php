<?php

namespace App\Controller;

use App\Entity\ForgotPassword;
use App\Entity\User;
use App\Form\SetNewPasswordType;
use App\Form\ForgotPasswordType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;


class RemindPasswordController extends AbstractController
{

    /**
     * @Route("/remindPassword", name="remindPassword")
     */
    public function remindPassword(Request $request, \Swift_Mailer $mailer, AuthorizationCheckerInterface $authChecker)
    {
        if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('index');
        }
        $error="";
        $user = new ForgotPassword();
        $form = $this->createForm(ForgotPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
            if ($user)
            {
                $passwordResetToken = base64_encode(random_bytes(20));
                $passwordResetToken = str_replace("/","",$passwordResetToken); // because / will make errors with routes
                $user->setPasswordResetToken($passwordResetToken);
                $this->getDoctrine()->getManager()->flush();

                $message = (new \Swift_Message('Remind password - Car34'))
                    ->setFrom('car34project@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'emails/remindpass.html.twig',
                            array(
                                'token' => $passwordResetToken,
                                'username' => $user->getUsername()
                            )
                        ),
                        'text/html'
                    )
                ;

                $mailer->send($message);
                return $this->render('index.html.twig', array(
                    'success' => "Password was reset. Follow instructions in a letter we sent you in terms to change it."
                ));
            }
            else {
                $error="User with this email doesn't exist in database.";
            }
        }

        return $this->render('remindPassword.html.twig', [
            'form'=>$form->createView(),
            'action' => "reset",
            'error'=>$error
        ]);
    }

    /**
     * @Route("/remindPassword/{token}", name="setNewPassword")
     */
    public function setNewPassword(Request $request, $token, UserPasswordEncoderInterface $encoder)
    {

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['passwordResetToken' => $token]);
        if($user == null)
        {
            return $this->redirectToRoute('index');
        }
        $newPassword = new User();
        $form = $this->createForm(SetNewPasswordType::class, $newPassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $password = $encoder->encodePassword($user, $newPassword->getPassword());
            $user->setPassword($password);
            //"NULL" because it has to be a string; when doing a password reset, we must then
            // check if token is not "NULL"
            $user->setPasswordResetToken(NULL);
            $em->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render('remindPassword.html.twig', [
            'form'=>$form->createView(),
            'action' => "set",
        ]);
    }


}
