<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CongeRepository;
use App\Repository\AbsenceRepository;
use App\Repository\PersonnelRepository;

class DashboardController extends AbstractController
{
    #[Route('/admin_dashboard', name: 'admin_dashboard')]
    public function index(CongeRepository $congeRep,AbsenceRepository $absenceRep,PersonnelRepository $persoRep): Response
    {
        //user info
//        $userSessions = $this->getUser()->getEmail();
//        $userinfo=$persoRep->findByMail($userSessions);
//        $userName=$userinfo->getNomPerso().' '.$userinfo->getPrenomPerso();
        //total des personnes en congé
        $congeList=$congeRep->findAll();
        $congeCount=count($congeList);

        //date of the week
        $now = new \DateTimeImmutable();

        $startDate=$now->modify('this week')->setTime(0, 0, 0);
        $endDate=$now->modify('next Sunday')->setTime(23, 59, 59);
        $absenceofTheWeek=$absenceRep->findByDate_absence($startDate,$endDate);

        return $this->render('admin/pages/index.html.twig', [
            'totalConge'=>$congeCount,
            'totalDemandeConge'=>$startDate->format('Y-m-d'),
            'absenceWeek'=>$absenceofTheWeek,
        ]);
    }
}
