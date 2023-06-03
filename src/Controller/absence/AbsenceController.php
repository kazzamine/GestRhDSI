<?php

namespace App\Controller\absence;

use App\Entity\Absence;
use App\Entity\Personnel;
use App\Repository\AbsenceRepository;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;

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
    public function ajouterabsence(Request $request,AbsenceRepository $absenceRepo,EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $personeel=$entityManager->getRepository(Personnel::class)->find($data['idperso']);

        $absence=new Absence();
        $absence->setEmployeAbse($personeel);
        $dateJour=DateTimeImmutable::createFromFormat('Y-m-d', $data['dateJour']);

        $absence->setDateAbsence($dateJour);
        $absence->setJustification('non justifié');
        $entityManager->persist($absence);
        $entityManager->flush();
        return new Response('success');
    }
    #[Route('/RH/absence/absencemenu/entresortie', name: 'entresortie')]
    public function saisieentresortie(Request $request,AbsenceRepository $absenceRepo,EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $personeel=$entityManager->getRepository(Personnel::class)->find($data['idperso']);

        $absence=new Absence();
        $absence->setEmployeAbse($personeel);
        $dateJour=DateTimeImmutable::createFromFormat('Y-m-d', $data['dateJour']);

        $absence->setDateAbsence($dateJour);
        $absence->setJustification('non justifié');
        $entityManager->persist($absence);
        $entityManager->flush();
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


