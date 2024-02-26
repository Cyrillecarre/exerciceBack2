<?php

namespace App\Controller;

use App\Entity\Recruiters;
use App\Form\RegistrationFormTypeRecruiter;
use App\Security\ConsultantAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationRecruiterController extends AbstractController
{
    #[Route('/registerRecruiter', name: 'app_register_recruiter')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, ConsultantAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Recruiters();
        $form = $this->createForm(RegistrationFormTypeRecruiter::class, $user);
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

        return $this->render('registrationRecruiter/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
