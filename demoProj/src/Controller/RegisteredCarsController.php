<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Repair;
use App\Entity\User;
use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use App\Controller\EmailActivationController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RegisteredCarsController extends AbstractController
{

    /**
     * @Route("/registeredCars", name="registeredCars")
     */
    public function showAllServices(AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }


        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('registeredCars.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/showServices/{id}", name="showServices")
     */
    public function showServices($id)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        $repairs = $this->getDoctrine()->getManager()->getRepository(Repair::class)->findAll();
        return $this->render('editCarServices.html.twig', array(
            'order' => $order,
            'repairs'=>$repairs,
        ));
    }
    /**
     * @Route("/changeIsDoneOrder/{id}", name="changeIsDoneOrder")
     */
    public function changeIsDoneOrder(Request $request, $id, \Swift_Mailer $mailer)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->find($id);
        $repairs = $order->getRepairs();
        $order->setIsDone(true);

        foreach ($repairs as $repair)
        {
                $repair->setIsDone(true);
        }

        $this->getDoctrine()->getManager()->flush();

//        $user = $this->getUser();
//        $send = $this->get('app.email_activation_service');
//        $send->SendAllServiceDoneEmail($user->getUsername(), $user->getEmail(), $repairs->getOrder()->getCar()->getModel(), $mailer);


        return $this->redirectToRoute('registeredCars');
    }

}