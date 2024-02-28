<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\JobOffer;

class CandidatController extends AbstractController
{
    #[Route('/candidat', name: 'app_candidat')]
    public function index(EntityManagerInterface $em): Response
    {

        $jobOfferRepository = $em->getRepository(JobOffer::class);
        $offres = $jobOfferRepository->findAll();

        return $this->render('candidat/index.html.twig', [
            'controller_name' => 'CandidatController',
            'offres' => $offres,
        ]);
    }
}
