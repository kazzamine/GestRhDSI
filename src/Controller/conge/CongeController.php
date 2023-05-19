<?php

namespace App\Controller\conge;

use App\Entity\CongeJours;
use App\Entity\DemandeConge;
use App\Entity\Personnel;
use App\Repository\CongeJoursRepository;
use App\Repository\DemandeCongeRepository;
use App\Repository\JourFerierRepository;
use App\Service\CommonService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CongeController extends AbstractController
{
    #[Route('/admin/conge/congemenu', name: 'congemenu')]
    public function index(): Response
    {
        return $this->render('admin/pages/congeMenu.html.twig', [
            'controller_name' => 'CongeController',
        ]);
    }

    #[Route('/admin/conge/congemenu/logconge', name: 'logconge')]
    public function logconge(DemandeCongeRepository $demandeCongeRepo): Response
    {
        $congeList=$demandeCongeRepo->findBy(['etatDemande'=>'accepter']);
        return $this->render('admin/pages/logconge.html.twig', [
            'controller_name' => 'CongeController',
            'congeList'=>$congeList,
        ]);
    }

    #[Route('/admin/conge/congemenu/demandeConge', name: 'demandeConge')]
    public function demandeConge(DemandeCongeRepository $demandeCongeRepo): Response
    {
        $congeList=$demandeCongeRepo->findBy(['etatDemande'=>'en cours']);
        return $this->render('admin/pages/demandeConge.html.twig', [
            'controller_name' => 'CongeController',
            'congeList'=>$congeList,
        ]);
    }

    #[Route('/admin/empMenu/conge/jourConge/add', name: 'jourConge')]
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

    #[Route('/admin/empMenu/conge/acceptconge', name: 'acceptconge')]
    public function acceptconge(Request $request,EntityManagerInterface $entityManager,CongeJoursRepository $jourRepo,JourFerierRepository $vacanceRepo): Response
    {
        $persoid=$request->query->get('persoid');
        $congeid=$request->query->get('congeid');
        $entity = $entityManager->getRepository(DemandeConge::class)->findBy(['personnel_demande'=>$persoid,'id'=>$congeid]);
        $entity[0]->setEtatDemande('accepter');

        $days=[];
        $jourFerier=$vacanceRepo->findAll();
        foreach ($jourFerier as $freeday){
            $days[]=$freeday->getDateDebutJour();
        }


        $getjour=$jourRepo->findBy(['personnelcin'=>$persoid]);
        $datedebut=$entity[0]->getCongeDemande()->getDateDebutConge();
        $datefin=$entity[0]->getCongeDemande()->getDateFinConge();
        $commonser=new CommonService();
        $totalDays=$commonser->calculjourConge($datedebut,$datefin,$days);
        $daysToRemove= $getjour[0]->getNombreCongeNormal()-$totalDays;
        if($entity[0]->getCongeDemande()->getTypeConge()==1){
            $getjour[0]->setNombreCongeNormal($daysToRemove);
            $entityManager->flush();
        }else if($entity[0]->getCongeDemande()->getTypeConge()==2){
            $getjour[0]->setNombreCongeExcep($daysToRemove);
            $entityManager->flush();
        }
        return new Response('success');
    }

    #[Route('/admin/empMenu/conge/declineconge', name: 'declineconge')]
    public function declineconge(Request $request,EntityManagerInterface $entityManager)
    {
        $persoid=$request->query->get('persoid');
        $congeid=$request->query->get('congeid');
        $entity = $entityManager->getRepository(DemandeConge::class)->findBy(['personnel_demande'=>$persoid,'id'=>$congeid]);
        $entity[0]->setEtatDemande('refuser');
        $entityManager->flush();

    }

}
