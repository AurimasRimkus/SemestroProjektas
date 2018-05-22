<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Repair;
use App\Entity\Service;
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

        if(!$service = $this->getDoctrine()->getRepository(Service::class)->findAll())
        {
            return $this->render('index.html.twig', [
                'error' => "Sorry, no available repairs at this moment."
            ]);
        }

        $user = $this->getUser();
        $profile = $user->getProfile();
        $cars = $profile->getCars();
        $newCar = new Car();
        $services = $this->getDoctrine()->getRepository(Service::class)->findBy(['isActive'=>'1']);
        $checkedBoxes = $request->get('student_ids');
        $orderTime = $request->get('chosenTime');
        $comment = $request->get('comment');
        $form = $this->createForm(CarType::class, $newCar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            //order's duration in time
            $orderDuration = 0;
            //parse ids from checkboxes names
            $ids = array();
            foreach ($checkedBoxes as $box)
            {
                $args = explode(";", $box);
                array_push($ids, $args[0]);
                $orderDuration += (int)$args[2];
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

            $startFinishTimes = explode("/", $orderTime);
            $startTime = new \DateTime($startFinishTimes[0]);
            $finishTime = new \DateTime($startFinishTimes[1]);
            $newOrder->setStartDate($startTime);
            $newOrder->setFinishDate($finishTime);
            $newOrder->setDuration($orderDuration);
            $newOrder->setProfile($profile);
            $newOrder->setComment($comment);
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

            return $this->render('index.html.twig', [
                'success' => "Car with plate number: \"" . $newCar->getNumberPlate() . "\" was applied for a service."
            ]);
        }

        return $this->render('register_for_service/serviceRegistration.html.twig', [
            'cars' => $cars,
            'form'=>$form->createView(),
            'services'=>$services,
        ]);
    }

    /**
     * @Route("/availableServiceTimes", name="availableServiceTimes")
     */
    public function ajaxAction(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return $this->redirectToRoute('index');
        }

        if($request->isXmlHttpRequest() && $request->request->get('date'))
        {
            $date = $request->request->get('date');
            $duration = $request->request->get('duration');

            $time = array (8, 9, 10, 11, 12, 13, 14, 15, 16);
            $orders = $this->getDoctrine()->getRepository(Order::class)->findByDate($date);

            // iterate through orders
            foreach ($orders as $order)
            {
                $startHour = $order->getStartDate()->format("H");
                $finishHour = $order->getFinishDate()->format("H");

                //remove hours from array what are already taken
                for ( $i = (int)$startHour; $i < (int)$finishHour; $i++ )
                {
                    $key = array_search($i, $time);
                    unset($time[$key]);
                }
            }

            $time = $this->findAvailableHours($duration, array_values($time));

            $arrData = ['times' => $time];
            return new JsonResponse($arrData);
        }

        return $this->redirectToRoute('index');
    }

    private function findAvailableHours($duration, $hours)
    {
        $availableHours = array();

        // for every hour
        for ( $i = 0; $i < count($hours); $i++ )
        {
            $count = 0;
            // for every single service hour (duration)
            for ( $j = 0; $j < $duration; $j++ )
            {
                if ( array_search($hours[$i]+$j, $hours) !== false )
                {
                    $count++;
                }
            }

            if ( $count == $duration )
            {
                $data = $hours[$i] . ":00 - " . ($hours[$i]+$duration) . ":00";
                array_push($availableHours, $data);
            }
        }

        return $availableHours;
    }
}
