<?php

namespace App\Controller\conge;

use App\Entity\CongeJours;
use App\Entity\DemandeConge;
use App\Entity\Notifications;
use App\Entity\Personnel;
use App\Repository\CongeJoursRepository;
use App\Repository\DemandeCongeRepository;
use App\Repository\JourFerierRepository;
use App\Repository\PersonnelRepository;
use App\Service\CommonService;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CongeController extends AbstractController
{
    #[Route('/RH/conge/congemenu', name: 'congemenu')]
    public function index(): Response
    {
        return $this->render('RH/pages/congeMenu.html.twig', [
            'controller_name' => 'CongeController',
        ]);
    }

    #[Route('/RH/conge/congemenu/logconge', name: 'logconge')]
    public function logconge(DemandeCongeRepository $demandeCongeRepo): Response
    {
        $congeList=$demandeCongeRepo->findBy(['etatDemande'=>'accepter']);

        return $this->render('RH/pages/logconge.html.twig', [
            'controller_name' => 'CongeController',
            'congeList'=>$congeList,
        ]);
    }

    #[Route('/RH/conge/congemenu/demandeConge', name: 'demandeConge')]
    public function demandeConge(DemandeCongeRepository $demandeCongeRepo): Response
    {
        $congeList=$demandeCongeRepo->findBy(['etatDemande'=>'en cours','adminApprove'=>'accepter']);
        return $this->render('RH/pages/demandeConge.html.twig', [
            'controller_name' => 'CongeController',
            'congeList'=>$congeList,
        ]);
    }

    // add congeJours for each employe
    #[Route('/RH/empMenu/conge/jourConge/add', name: 'jourConge')]
    public function addCongeJours(Request $request,EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $congeObj=new CongeJours();

        $personnel = $entityManager->getRepository(Personnel::class)->find($data['idpersonnel']);

        $congeObj->setPersonnelcin($personnel);
        $congeObj->setNombreCongeNormal(22);
        $congeObj->setNombreCongeExcep(10);

        $entityManager->persist($congeObj);
        $entityManager->flush();
        return new Response('success');
    }

    #[Route('/RH/empMenu/conge/acceptconge', name: 'acceptconge')]
    public function acceptconge(PersonnelRepository $persRepo,Request $request,EntityManagerInterface $entityManager,CongeJoursRepository $jourRepo,JourFerierRepository $vacanceRepo): Response
    {
        $persoid=$request->query->get('persoid');
        $id=$request->query->get('id');
        $entity = $entityManager->getRepository(DemandeConge::class)->find($id);
        $entity->setEtatDemande('accepter');
        $entityManager->flush();
        $days=[];
        $jourFerier=$vacanceRepo->findAll();
        foreach ($jourFerier as $freeday){
            $days[]=$freeday->getDateDebutJour();
        }
        $getjour=$jourRepo->find(['id'=>$persoid]);

        $datedebut=$entity->getCongeDemande()->getDateDebutConge();
        $datefin=$entity->getCongeDemande()->getDateFinConge();

        $commonser=new CommonService();
        $totalDays=$commonser->calculjourConge($datedebut,$datefin,$days);
        $persoinfo=$persRepo->find($persoid);
        $responssable=$persoinfo->getDevision()->getResponsable()->getNomPerso().' '.$persoinfo->getDevision()->getResponsable()->getPrenomPerso();
        $reason=$entity->getCongeDemande()->getTypeConge()->getConges();
        $data = [
            'nom'         => $persoinfo->getNomPerso(),
            'prenom'      => $persoinfo->getPrenomPerso(),
            'grade' => $persoinfo->getGrade()->getNomGrade(),
            'ppr'        => $persoinfo->getPPR(),
            'datedebut'=>$datedebut,
            'datefin'=>$datefin,
            'responsable'=>$responssable,

        ];
        $html =  $this->renderView('pdf_generator/congeexceptionel.html.twig', $data);
        if($entity->getCongeDemande()->getTypeConge()->getId()==1){
            $daysToRemove=$getjour->getNombreCongeNormal()-$totalDays;
            $getjour->setNombreCongeNormal($daysToRemove);
            $entityManager->flush();
            $html =  $this->renderView('pdf_generator/congeannuel.html.twig', $data);

        }else if($entity->getCongeDemande()->getTypeConge()->getId()==2){
            $daysToRemove=$getjour->getNombreCongeExcep()-$totalDays;
            $getjour->setNombreCongeExcep($daysToRemove);
            $entityManager->flush();
            $html =  $this->renderView('pdf_generator/congeexceptionel.html.twig', $data);
        }
        //sending notification
        $notify=new Notifications();
        $notify->setReceivant($persoinfo);
        $notify->setContent('Votre demande de congé a été accepter veuillez le recuperer demain');
        $entityManager->persist($notify);
        $entityManager->flush();
        //generate attestation

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        return new Response (
            $dompdf->stream('conge-'.$persoinfo->getNomPerso(), ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Route('/RH/empMenu/conge/declineconge', name: 'declineconge')]
    public function declineconge(Request $request,EntityManagerInterface $entityManager,DemandeCongeRepository $demandeCongeRepo)
    {
        $id=$request->query->get('id');
        $entity = $entityManager->getRepository(DemandeConge::class)->find($id);
        $entity->setEtatDemande('refuser');
        $entityManager->flush();
        $congeList=$demandeCongeRepo->findBy(['etatDemande'=>'en cours','adminApprove'=>'accepter']);
        return $this->render('RH/pages/demandeConge.html.twig', [
            'controller_name' => 'CongeController',
            'congeList'=>$congeList,
        ]);
    }

}
