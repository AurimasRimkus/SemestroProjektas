<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Car;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Form\CarType;

class ServiceRegistrationController extends Controller
{
    /**
     * @Route("/serviceRegistration", name="serviceRegistration")
     */
    public function serviceRegistration(Request $request, AuthorizationCheckerInterface $authorizationChecker)
    {
        if (!$authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return $this->redirectToRoute('index');
        }

        $user = $this->getUser();
        $profile = $user->getProfile();
        $cars = $profile->getCars();
        $newOrder = new Order();

        $newCar = new Car();
        $form = $this->createForm(CarType::class, $newCar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $newCar->setProfile($profile);

            $time = new \DateTime();
            $newOrder->setArrivalDate($time);
            $newOrder->setProfile($profile);
            $newOrder->setCar($newCar);
            $newOrder->setIsDone(false);

            //$em->persist($profile);
            $em->persist($newCar);
            $em->persist($newOrder);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('register_for_service/serviceRegistration.html.twig', [
            'cars' => $cars,
            'form'=>$form->createView()
        ]);
    }
}
