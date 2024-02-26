<?php

namespace App\Controller;

use App\Entity\Consultants;
use App\Form\RegistrationFormTypeConsultant;
use App\Security\ConsultantAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationConsultantController extends AbstractController
{
    #[Route('/registerConsultant', name: 'app_register_Consultant')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, ConsultantAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Consultants();
        $form = $this->createForm(RegistrationFormTypeConsultant::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registrationConsultant/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
