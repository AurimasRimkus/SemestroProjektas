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
        $message = $this->generateActivationEmail($name, $email, $token);
        $mailer->send($message);
    }
	
	public function generateActivationEmail($name, $email, $token) {
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
			
		return $message;
	}

    public function SendAllServiceDoneEmail($name, $email, $carModel, \Swift_Mailer $mailer)
    {
        $message = $this->GenerateAllServiceDoneEmail($name, $carModel, $email);
        $mailer->send($message);
    }
	
	public function GenerateAllServiceDoneEmail($name, $carModel, $email) {
		$message = (new \Swift_Message('Car completion - Car34'))
            ->setFrom('car34project@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'emails/servicesDone.html.twig',
                    array(
                        'username' => $name,
                        'model' => $carModel,
                    )
                ),
                'text/html'
            );
			
		return $message;
	}
}