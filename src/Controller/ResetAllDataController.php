<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Conge;
use App\Entity\CongeJours;
use App\Entity\DemandeConge;
use App\Entity\HoraireES;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetAllDataController extends AbstractController
{
    #[Route('/super-admin/resetall', name: 'resetall')]
    public function index(): Response
    {

        return $this->render('superadmin/pages/resetall.html.twig', [

        ]);
    }
    #[Route('/super-admin/resetall/remove', name: 'resetallremove')]
    public function resetall(EntityManagerInterface $entityManager): Response
    {
        //update reste du congé
        $congejours=$entityManager->getRepository(CongeJours::class)->findAll();
        foreach ($congejours as $congeday) {
            $congeday->setNombreCongeNormal(22);
            $congeday->setNombreCongeExcep(10);
        }
        $entityManager->flush();
        //remove demandeconge
        $demandesconge=$entityManager->getRepository(DemandeConge::class)->findAll();
        foreach ($demandesconge as $demandeconge) {
            $entityManager->remove($demandeconge);
        }
        $entityManager->flush();
        //remove conges
        $conges=$entityManager->getRepository(Conge::class)->findAll();
        foreach ($conges as $conge) {
            $entityManager->remove($conge);
        }
        $entityManager->flush();
        //remove absence
        $absences=$entityManager->getRepository(Absence::class)->findAll();
        foreach ($absences as $absence) {
            $entityManager->remove($absence);
        }
        $entityManager->flush();

        $entres=$entityManager->getRepository(HoraireES::class)->findAll();
        foreach ($entres as $entre) {
            $entityManager->remove($entre);
        }
        $entityManager->flush();

        return $this->redirectToRoute('resetall');

    }
}