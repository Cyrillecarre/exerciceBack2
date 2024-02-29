<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\JobOffer;
use App\Entity\DemandeCandidature;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



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

    #[Route('/candidat/{id}', name: 'app_candidat_show', methods: ['GET'])]
    public function show(JobOffer $jobOffer): Response
    {
        return $this->render('candidat/show.html.twig', [
            'job_offer' => $jobOffer,
            'postulerUrl' => $this->generateUrl('app_candidat_postulerAjax', ['id' => $jobOffer->getId()]),
        ]);
    }

    #[Route('/candidat/{id}/postuler', name: 'app_candidat_postulerAjax', methods: ['GET'])]
    public function postulerAjax(jobOffer $jobOffer, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $demandeCandidature = new DemandeCandidature();
        $demandeCandidature->setUserCandidat($user);
        $demandeCandidature->setOffreEmploi($jobOffer);
        $demandeCandidature->setIsValided(false);
        $demandeCandidature->setDate(new \DateTimeImmutable());

        $em->persist($demandeCandidature);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Votre candidature a bien été prise en compte',
        ]);

    }
}
