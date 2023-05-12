<?php

namespace App\Controller\absence;

use App\Repository\PersonnelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbsenceController extends AbstractController
{
    #[Route('/admin/absence/absencemenu', name: 'absencemenu')]
    public function index(): Response
    {
        return $this->render('admin/pages/absencemenu.html.twig', [
            'controller_name' => 'AbsenceController',
        ]);
    }
    #[Route('/admin/absence/absencemenu/saisiabsence', name: 'saisiabsence')]
    public function saisiAbsence(PersonnelRepository $persoRep): Response
    {
        $personnelsListe=$persoRep->findAll();
        return $this->render('admin/pages/saisiabsence.html.twig', [
            'controller_name' => 'AbsenceController',
            'persoListe'=>$personnelsListe,
        ]);
    }

    #[Route('/admin/absence/absencemenu/consulterAbsence', name: 'consulterAbsence')]
    public function consulterAbsence(): Response
    {
        return $this->render('admin/pages/saisiabsence.html.twig', [
            'controller_name' => 'AbsenceController',
        ]);
    }
}
