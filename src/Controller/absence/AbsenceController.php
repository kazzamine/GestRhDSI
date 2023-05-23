<?php

namespace App\Controller\absence;

use App\Repository\AbsenceRepository;
use App\Repository\PersonnelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbsenceController extends AbstractController
{
    #[Route('/RH/absence/absencemenu', name: 'absencemenu')]
    public function index(): Response
    {
        return $this->render('RH/pages/absencemenu.html.twig', [
            'controller_name' => 'AbsenceController',
        ]);
    }
    #[Route('/RH/absence/absencemenu/saisiabsence', name: 'saisiabsence')]
    public function saisiAbsence(PersonnelRepository $persoRep): Response
    {
        $personnelsListe=$persoRep->findAll();
        return $this->render('RH/pages/saisiabsence.html.twig', [
            'controller_name' => 'AbsenceController',
            'persoListe'=>$personnelsListe,
        ]);
    }

    #[Route('/RH/absence/absencemenu/ajouterabsence', name: 'ajouterabsence')]
    public function ajouterabsence(PersonnelRepository $persoRep): Response
    {
        $personnelsListe=$persoRep->findAll();

        return new Response('success');
    }

    #[Route('/RH/absence/absencemenu/consulterAbsence', name: 'consulterAbsence')]
    public function consulterAbsence(PersonnelRepository $persoRep,AbsenceRepository $absenceRepo): Response
    {
        $objects = [];
        $personnelsListe=$persoRep->findAll();
//        $absence=$absenceRepo->findAll();
        foreach($personnelsListe as $personnel){
            $object = new \stdClass();
            $object->persoId = $personnel->getId();
            $object->persoNom =$personnel->getNomPerso();
            $object->persoPrenom =$personnel->getPrenomPerso();
            $object->totalAbsence =0;
            $absence=$absenceRepo->findByEmployeAbse($personnel->getId());
            if(!empty($absence)){
                $object->totalAbsence=$absence;
            }
            $objects[] = $object;
        }
        return $this->render('RH/pages/listeAbsence.html.twig', [
            'controller_name' => 'AbsenceController',
            'persoListe'=>$personnelsListe,
            'absence'=>$objects,
        ]);
    }
}


