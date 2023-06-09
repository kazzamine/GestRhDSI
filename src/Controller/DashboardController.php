<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Repository\CongeJoursRepository;
use App\Repository\DemandeCongeRepository;
use App\Repository\GradeRepository;
use App\Repository\NotificationsRepository;
use App\Repository\PosteRepository;
use App\Repository\VisitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CongeRepository;
use App\Repository\AbsenceRepository;
use App\Repository\PersonnelRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DashboardController extends AbstractController
{
    //RH dashboard
    #[Route('/rh_dashboard', name: 'rh_dashboard')]
    public function index(NotificationsRepository $notifRepo,PersonnelRepository $persoRepo,TokenStorageInterface $tokenStorage,CongeRepository $congeRep,AbsenceRepository $absenceRep,DemandeCongeRepository $demandeCongeRepo): Response
    {

        //date of the week
        $now = new \DateTimeImmutable();
        $currentDate = new \DateTime();
        $today = $currentDate->format('Y-m-d');
        $dateTime = \DateTime::createFromFormat('Y-m-d', $today);
        //total des personnes en congé
        $congeList=$congeRep->findByDate_fin_conge($dateTime);
        $congeCount=count($congeList);

        // Retrieve the authenticated user's token
        $token = $tokenStorage->getToken();
        $username = $token?->getUser()->getUserIdentifier();
        //get employe info from mail
        $personnelInfo=$persoRepo->findBy(['mail'=>$username]);
        $empID=$personnelInfo[0]->getId();
        $notification=$notifRepo->findBy(['receivant'=>$empID]);

        $startDate=$now->modify('this week')->setTime(0, 0, 0);
        $endDate=$now->modify('next Sunday')->setTime(23, 59, 59);
        $absenceofTheWeek=$absenceRep->findByDate_absence($startDate,$endDate);

        //demande en attente
        $demandeconge=count($demandeCongeRepo->findBy(['etatDemande'=>'en cours','adminApprove'=>'accepter']));
        return $this->render('RH/pages/index.html.twig', [
            'demande'=>$demandeconge,
            'totalConge'=>$congeCount,
            'totalDemandeConge'=>$startDate->format('Y-m-d'),
            'absenceWeek'=>$absenceofTheWeek,
            'notification'=>$notification,
        ]);
    }

    //user/admin dashbaord
    #[Route('/user_dashboard', name: 'user_dashboard')]
    public function userdashboard(EntityManagerInterface $entityManager,NotificationsRepository $notifRepo,SessionInterface $session,TokenStorageInterface $tokenStorage,PersonnelRepository $persoRepo,AbsenceRepository $absenceRepo,PosteRepository $posteRepo,GradeRepository $gradeRepo,CongeJoursRepository $congeJourRepo): Response
    {

        //get postes
        $postes=$posteRepo->findAll();
        //get grades
        $grades=$gradeRepo->findAll();

        // Retrieve the authenticated user's token
        $token = $tokenStorage->getToken();
        $username = $token?->getUser()->getUserIdentifier();
        //get employe info from mail
        $personnelInfo=$persoRepo->findBy(['mail'=>$username]);
        //find employe absence
        $empID=$personnelInfo[0]->getId();
        $empAbsence=$absenceRepo->findBy(['employe_abse'=>$empID]);
        $session->set('empid', $empID);
        //find employe conge
        $empconge=$congeJourRepo->findBy(['personnelcin'=>$empID]);
        $congerest=$empconge[0]->getNombreCongeNormal();
        //calcul reste de congé
        $congePasse=22-$congerest;
        $absenceCount=0;
        if(!empty($empAbsence)){
            $absenceCount=count($empAbsence);
        }
        $notification=$notifRepo->findBy(['receivant'=>$empID]);

        $visitor=new Visitor();
        $currentDate = new DateTime();
        $todayDate = $currentDate->format('Y-m-d');
        $visitor->setVisitorIp($empID);
        $visitor->setVisitorDate($todayDate);
        $entityManager->persist($visitor);
        $entityManager->flush();

        return $this->render('user/pages/index.html.twig', [
            'empInfo'=>$personnelInfo,
            'absenceNumber'=>$absenceCount,
            'postes'=>$postes,
            'grades'=>$grades,
            'congepasse'=>$congePasse,
            'congerest'=>$congerest,
            'notification'=>$notification,
        ]);
    }

}
