<?php

namespace App\Controller;

use App\Entity\Candidates;
use App\Form\RegistrationFormTypeCandidate;
use App\Security\ConsultantAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Service\FileUploader;

class RegistrationCandidateController extends AbstractController
{
    #[Route('/registerCandidate', name: 'app_register_Candidate')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, ConsultantAuthenticator $authenticator, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $user = new Candidates();
        $form = $this->createForm(RegistrationFormTypeCandidate::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $cvFile = $form->get('cv')->getData();
            if ($cvFile) {
                $cvFileName = $fileUploader->upload($cvFile);
                $user->setCvFilename($cvFileName);
            }

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registrationCandidate/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
