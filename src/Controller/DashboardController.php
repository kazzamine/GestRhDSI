<?php

namespace App\Controller;

use App\Repository\CongeJoursRepository;
use App\Repository\DemandeCongeRepository;
use App\Repository\GradeRepository;
use App\Repository\PosteRepository;
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
    #[Route('/rh_dashboard', name: 'rh_dashboard')]
    public function index(CongeRepository $congeRep,AbsenceRepository $absenceRep,DemandeCongeRepository $demandeCongeRepo): Response
    {
        //user info
//        $userSessions = $this->getUser()->gemEmail();
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
        $demandeconge=count($demandeCongeRepo->findBy(['etatDemande'=>'en cours','adminApprove'=>'accepter']));
        return $this->render('RH/pages/index.html.twig', [
            'demande'=>$demandeconge,
            'totalConge'=>$congeCount,
            'totalDemandeConge'=>$startDate->format('Y-m-d'),
            'absenceWeek'=>$absenceofTheWeek,
        ]);
    }

    #[Route('/user_dashboard', name: 'user_dashboard')]
    public function userdashboard(SessionInterface $session,TokenStorageInterface $tokenStorage,Request $request,PersonnelRepository $persoRepo,AbsenceRepository $absenceRepo,PosteRepository $posteRepo,GradeRepository $gradeRepo,CongeJoursRepository $congeJourRepo): Response
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

        return $this->render('user/pages/index.html.twig', [
            'empInfo'=>$personnelInfo,
            'absenceNumber'=>$absenceCount,
            'postes'=>$postes,
            'grades'=>$grades,
            'congepasse'=>$congePasse,
            'congerest'=>$congerest,
        ]);
    }
}
