<?php

namespace App\Controller;

use App\Entity\DemandeCandidature;
use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConsultantController extends AbstractController
{
    #[Route('/consultant/job-offers', name: 'consultant_job_offers')]
    /**
     * @Route("/consultant/job-offers", name="consultant_job_offers")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $jobOffers = $em->getRepository(JobOffer::class)->findBy(['isPublished' => false]);

        $demandeCandidature = $em->getRepository(DemandeCandidature::class)->findBy(['isValided' => false]);

        // Traiter la validation ou la suppression d'une offre d'emploi
        $jobOfferId = $request->get('jobOfferId');
        if ($jobOfferId) {
            $jobOffer = $em->getRepository(JobOffer::class)->find($jobOfferId);

            if ($request->get('action') === 'validate') {
                $jobOffer->setIsPublished(true);
                $em->flush();
                $this->addFlash('success', 'L\'offre d\'emploi a été validée avec succès.');
            } elseif ($request->get('action') === 'reject') {
                $em->remove($jobOffer);
                $em->flush();
                $this->addFlash('success', 'L\'offre d\'emploi a été supprimée avec succès.');
            }

            return $this->redirectToRoute('consultant_job_offers');
        }

        return $this->render('consultant/job-offers/index.html.twig', [
            'jobOffers' => $jobOffers,
            'demandes' => $demandeCandidature,
        ]);
    }



    #[Route('/consultant/demande/{id}/valider', name: 'app_consultant_valider_demande', methods: ['POST'])]
    public function validerDemande(EntityManagerInterface $em, int $id)
    {
        $demande = $em->getRepository(DemandeCandidature::class)->find($id);

        if ($demande) {
            $demande->setIsValided(true);
            $em->flush();

            return $this->redirectToRoute('consultant_demandeRelation');
        }
    }

    #[Route('/consultant/demande/{id}/refuser', name: 'app_consultant_refuser_demande', methods: ['DELETE'])]
    public function refuserDemande(EntityManagerInterface $em, int $id)
    {
        $demande = $em->getRepository(DemandeCandidature::class)->find($id);

        if ($demande) {
            $em->remove($demande);
            $em->flush();

            return $this->redirectToRoute('consultant_demandeRelation');
        }
    }
}
