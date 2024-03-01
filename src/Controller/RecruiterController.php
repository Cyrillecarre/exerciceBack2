<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DemandeCandidature;
use App\Entity\Candidates;

class RecruiterController extends AbstractController
{
    #[Route('/recruiter', name: 'app_recruiter')]
    public function index(): Response
    {
        return $this->render('recruiter/index.html.twig', [
            'controller_name' => 'RecruiterController',
        ]);
    }

    #[Route('/recruiter/candidature', name: 'app_recruiter_candidature')]
    public function validatedApplications(EntityManagerInterface $em)
    {
    $demandesCandidatures = $em->getRepository(DemandeCandidature::class)->findBy(['isValided' => true]);
    
    foreach ($demandesCandidatures as $demande) {
        $demande->cvFilename = $demande->getUserCandidat()->getCvFilename();
    }


    return $this->render('recruiter/candidature.html.twig', [
        'demandesCandidatures' => $demandesCandidatures,
    ]);
    }
    
}
