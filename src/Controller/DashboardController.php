<?php

namespace App\Controller;

use App\Repository\DemandeCongeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CongeRepository;
use App\Repository\AbsenceRepository;
use App\Repository\PersonnelRepository;

class DashboardController extends AbstractController
{
    #[Route('/admin_dashboard', name: 'admin_dashboard')]
    public function index(CongeRepository $congeRep,AbsenceRepository $absenceRep,DemandeCongeRepository $demandeCongeRepo): Response
    {
        //user info
//        $userSessions = $this->getUser()->getEmail();
//        $userinfo=$persoRep->findByMail($userSessions);
//        $userName=$userinfo->getNomPerso().' '.$userinfo->getPrenomPerso();
        //date of the week
        $now = new \DateTimeImmutable();
        $currentDate = new \DateTime();
        $today = $currentDate->format('Y-m-d');
        $dateTime = \DateTime::createFromFormat('Y-m-d', $today);
        //total des personnes en congé
        $congeList=$congeRep->findByDate_fin_conge($dateTime);
        $congeCount=count($congeList);

        $startDate=$now->modify('this week')->setTime(0, 0, 0);
        $endDate=$now->modify('next Sunday')->setTime(23, 59, 59);
        $absenceofTheWeek=$absenceRep->findByDate_absence($startDate,$endDate);

        //demande en attente
        $demandeconge=count($demandeCongeRepo->findBy(['etatDemande'=>'en cours']));
        return $this->render('admin/pages/index.html.twig', [
            'demande'=>$demandeconge,
            'totalConge'=>$congeCount,
            'totalDemandeConge'=>$startDate->format('Y-m-d'),
            'absenceWeek'=>$absenceofTheWeek,
        ]);
    }
}
