<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use App\Entity\Car;
use App\Entity\Profile;
use App\Form\CarType;
use App\Form\ProfileType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="profile")
     * @codeCoverageIgnore
     */
    public function Profile(AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        return $this->render('profile.html.twig', [
            'error' => null,
        ]);
    }

    /**
     * @Route("/editProfile", name="editProfile")
     * @codeCoverageIgnore
     */
    public function editProfile(Request $request, AuthorizationCheckerInterface $authChecker, \Swift_Mailer $mailer)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $newProfile = new Profile();
        $form = $this->createForm(ProfileType::class, $newProfile);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $error = null;
            $user = $this->getUser();
            $profile = $user->getProfile();

            $this->updateUserProfile($profile, $newProfile);

            $mail = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$newProfile->getEmail()]);
            if($this->isSendAllowed($user, $newProfile, $mail))
            {
                $this->updateUserEmail($profile, $newProfile, $user);

                $send = $this->get('app.email_activation_service');
                $send->SendActivationEmail($user->getUsername(), $user->getEmail(), $user->getRegistrationToken(), $mailer);
            }
            elseif($this->isEmailInUse($user, $newProfile))
            {
                $error = 'Email incorrect or already in use';
                return $this->render('editProfile.html.twig', [
                    'error' => $error,
                    'form'=>$form->createView()
                ]);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($profile);
            $em->flush();
            return $this->render('profile.html.twig', [
                'error' => $error,
                'success' => "Your profile was updated."
            ]);
        }

        return $this->render('editProfile.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    public function updateUserProfile(Profile $profile, Profile $newProfile) {
        $profile->setName($newProfile->getName());
        $profile->setSecondName($newProfile->getSecondName());
        $profile->setPhoneNumber($newProfile->getPhoneNumber());
        $profile->setBirthDate($newProfile->getBirthDate());
    }

    public function updateUserEmail(Profile $profile, Profile $newProfile, User $user) {
        $profile->setEmail($newProfile->getEmail());
        $user->setEmail($newProfile->getEmail());

        $user->setIsActive(false);
        $registrationToken = base64_encode(random_bytes(20));
        $registrationToken = str_replace("/","",$registrationToken); // because / will make errors with routes
        $user->setRegistrationToken($registrationToken);
    }

    public function isSendAllowed(User $user, Profile $newProfile, $mail) {
        $user->getEmail() != $newProfile->getEmail() && $mail == null;
    }

    public function isEmailInUse(User $user, Profile $newProfile) {
        return $user->getEmail() != $newProfile->getEmail();
    }

    /**
     * @Route("/addCar", name="addCar")
     * @codeCoverageIgnore
     */
    public function AddCar(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $error = null;
        $newCar = new Car();
        $form = $this->createForm(CarType::class, $newCar);
        $form->handleRequest($request);

        $car = $this->getDoctrine()->getRepository(Car::class)->findOneBy(['numberPlate'=>$newCar->getNumberPlate()]);

        if($form->isSubmitted() && $form->isValid() && $car == null)
        {
            $user = $this->getUser();
            $profile = $user->getProfile();

            $em = $this->getDoctrine()->getManager();
            $this->updateCarProfile($newCar, $profile);
            $em->persist($profile);
            $em->persist($newCar);
            $em->flush();

            return $this->render('profile.html.twig', array(
                'error'=>$error,
                'success' => "Car was added."
            ));
        }
        elseif($form->isSubmitted())
        {
            $error = 'Incorrect information or the same number plate.';

            return $this->render('editAddCar.html.twig', array(
                'error'=>$error,
                'form'=>$form->createView(),
                'action'=>"Add"
            ));
        }

        return $this->render('editAddCar.html.twig', [
            'form'=>$form->createView(),
            'action'=>"Add"
        ]);
    }

    public function updateCarProfile(Car $newCar, Profile $profile) {
        $newCar->setProfile($profile);
    }

    /**
     * @Route("/editCar/{id}", name="editCar")
     * @codeCoverageIgnore
     */
    public function editCar(Request $request, $id, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $car = $this->getDoctrine()->getRepository(Car::class)->find($id);
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->render('profile.html.twig', array(
                'success' => "Car information was updated",
            ));
        }

        return $this->render('editAddCar.html.twig', array(
            'form' => $form->createView(),
            'action' => "Edit",
        ));
    }

    /**
     * @Route("/deleteCar/{id}", name="deleteCar")
     * @codeCoverageIgnore
     */
    public function deleteCar($id, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('index');
        }

        $undoneOrdersCount= $this->getDoctrine()->getRepository(Order::class)->countOfUndoneOrders($id);

        if ( $undoneOrdersCount[0][1] != 0 )
        {
            return $this->render('profile.html.twig', [
                'error' => "Car cannot be deleted because it has undone orders."
            ]);
        }
        else
        {
            $car = $this->getDoctrine()->getRepository(Car::class)->find($id);
            $orders = $car->getOrders();

            $em = $this->getDoctrine()->getManager();
            foreach ($orders as $order)
            {
                $repairs = $order->getRepairs();
                foreach ($repairs as $repair)
                {
                    $em->remove($repair);
                    $em->flush();
                }

                $em->remove($order);
                $em->flush();
            }

            $em->remove($car);
            $em->flush();

            return $this->render('profile.html.twig', [
                'success' => "Car was deleted."
            ]);
        }
    }
}