<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\UserType;
use App\Form\ProfileType;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmailActivationController extends AbstractController
{
    public function SendActivationEmail($name, $email, $token, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Account activation - Car34'))
            ->setFrom('car34project@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'emails/activation.html.twig',
                    array(
                        'token' => $token,
                        'username' => $name,
                    )
                ),
                'text/html'
            );

        $mailer->send($message);
    }
}