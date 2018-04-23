<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Repair;
use App\Entity\Service;
use App\Form\ListedServices;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $newCar = new Car();
        $services = $this->getDoctrine()->getRepository(Service::class)->findBy(['isActive'=>'1']);
        $checkedBoxes = $request->get('student_ids');
        $form = $this->createForm(CarType::class, $newCar);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            //if no services for car were checked in checkboxes
            if (!$checkedBoxes)
            {
                return $this->render('register_for_service/serviceRegistration.html.twig', [
                    'cars' => $cars,
                    'form'=>$form->createView(),
                    'services'=>$services,
                    'error'=>"Please select at least one service type for a car"
                ]);
            }

            //parse ids from checkboxes names
            $ids = array();
            foreach ($checkedBoxes as $box)
            {
                $args = explode(";", $box);
                array_push($ids, $args[0]);
            }

            $newOrder = new Order();

            $em = $this->getDoctrine()->getManager();
            //return car from database if it exists by submitted numberPlate
            $car = $this->getDoctrine()->getRepository(Car::class)->find($newCar->getNumberPlate());

            //if this car already exists, we dont need to insert it into database. otherwise we add it to our profile
            //and insert into database
            if ($car)
            {
                $newCar = $car;
                $newOrder->setCar($newCar);
            }
            else
            {
                $newCar->setProfile($profile);
                $newOrder->setCar($newCar);
                $em->persist($newCar);
            }

            $time = new \DateTime();
            $newOrder->setArrivalDate($time);
            $newOrder->setProfile($profile);
            $newOrder->setIsDone(false);

            //for each service checked we create a repair. one order has many repairs (ManyToOne)
            foreach ($ids as $id)
            {
                $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
                $repair = new Repair();
                $repair->setCost($service->getCost());
                $repair->setIsDone(false);
                $repair->setDuration($service->getDuration());
                $repair->setName($service->getName());

                $repair->setOrder($newOrder);
                $em->persist($repair);
            }

            $em->persist($newOrder);
            $em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('register_for_service/serviceRegistration.html.twig', [
            'cars' => $cars,
            'form'=>$form->createView(),
            'services'=>$services,
        ]);
    }
}
