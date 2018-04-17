<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\Profile;
use App\Form\CarType;
use App\Form\ProfileType;
use App\Controller\RegistrationController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="profile")
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

            $profile->setName($newProfile->getName());
            $profile->setSecondName($newProfile->getSecondName());
            $profile->setPhoneNumber($newProfile->getPhoneNumber());
            $profile->setBirthDate($newProfile->getBirthDate());

            $mail = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email'=>$newProfile->getEmail()]);
            if($user->getEmail() != $newProfile->getEmail() && $mail == null)
            {
                $profile->setEmail($newProfile->getEmail());
                $user->setEmail($newProfile->getEmail());

                /*
                $user->setIsActive(false);
                need to add email reconfirmation after changing email
                */
            }
            elseif($user->getEmail() != $newProfile->getEmail())
            {
                $error = 'Email incorrect or already in use';
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($profile);
            $em->flush();
            return $this->render('profile.html.twig', [
                'error' => $error,
            ]);
        }

        return $this->render('editProfile.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/addCar", name="addCar")
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
            $newCar->setProfile($profile);
            $em->persist($profile);
            $em->persist($newCar);
            $em->flush();

            return $this->render('profile.html.twig', array(
                'error'=>$error,
            ));
        }
        elseif($form->isSubmitted())
        {
            $error = 'Incorrect information or the same number plate';

            return $this->render('profile.html.twig', array(
                'error'=>$error,
            ));
        }

        return $this->render('addCar.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}