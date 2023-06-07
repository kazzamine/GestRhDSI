<?php

namespace App\Controller\conge;

use App\Entity\Conge;
use App\Entity\CongeExceptionnel;
use App\Entity\DemandeConge;
use App\Entity\Devision;
use App\Entity\Notifications;
use App\Entity\Personnel;
use App\Entity\TypeConge;
use App\Repository\CongeExceptionnelRepository;
use App\Repository\JourFerierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;

class DemanderCongeController extends AbstractController
{
    #[Route('/user/demanderconge', name: 'demander_conge')]
    public function index(CongeExceptionnelRepository $congeExceptionnelRepo): Response
    {
        $congeExcep=$congeExceptionnelRepo->findAll();
        return $this->render('user/pages/demanderConge.html.twig', [
            'controller_name' => 'DemanderCongeController',
            'congeexceps'=>$congeExcep,
        ]);
    }

    #[Route('/user/requestConge', name: 'requestConge')]
    public function requestConge(CongeExceptionnelRepository $congeExceptionnelRepo,SessionInterface $session,Request $request,EntityManagerInterface $entityManager,JourFerierRepository $vacanceRepo): Response
    {
        //retrieve data from ajax
        $data = json_decode($request->getContent(), true);
        $datedubet=DateTimeImmutable::createFromFormat('Y-m-d', $data['dataDebut']);
        $datefin=DateTimeImmutable::createFromFormat('Y-m-d', $data['dateFin']);
        $explication=null;
        if($data['explication']!=null){
            $reason=$entityManager->getRepository(CongeExceptionnel::class)->find($data['explication']);
            $explication=$reason->getTypeconge();
        }

        //adding new conge
        $conge=new Conge();
        if($data['type']==2){
            $datefin=$datedubet->modify('+' . $reason->getDuree() . ' days');
        }
        $conge->setDateDebutConge($datedubet);
        $conge->setDateFinConge($datefin);
        $typeconge = $entityManager->getRepository(TypeConge::class)->find($data['type']);
        $conge->setTypeConge($typeconge);


        //flushing data to database
        $entityManager->persist($conge);
        $entityManager->flush();

        //adding demandeconge
        $demandeconge=new DemandeConge();
        $demandeconge->setEtatDemande('en cours');
        $demandeconge->setAdminApprove('en cours');
        $demandeconge->setReasonConge($explication);
        $demandeconge->setCongeDemande($conge);
        //get employe from session
        $empid=$session->get("empid");
        $employe=$entityManager->getRepository(Personnel::class)->find($empid);
        $demandeconge->setPersonnelDemande($employe);
        //flushing data to database
        $entityManager->persist($demandeconge);
        $entityManager->flush();
        //sending notification
        $notify=new Notifications();
        $devisionrespo=$employe->getDevision()->getResponsable();
        $notify->setReceivant($devisionrespo);
        $notify->setContent($employe->getNomPerso().' '.$employe->getPrenomPerso().' a demander un congé');
        $entityManager->persist($notify);
        $entityManager->flush();

        $congeExcep=$congeExceptionnelRepo->findAll();
        return $this->render('user/pages/demanderConge.html.twig', [
            'controller_name' => 'DemanderCongeController',
            'congeexceps'=>$congeExcep,
        ]);
    }
}
