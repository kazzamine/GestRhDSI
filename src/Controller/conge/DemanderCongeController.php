<?php

namespace App\Controller\conge;

use App\Entity\Conge;
use App\Entity\DemandeConge;
use App\Entity\Personnel;
use App\Entity\TypeConge;
use App\Repository\TypeCongeRepository;
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
    public function index(TypeCongeRepository $typeCongeRepos): Response
    {
        $typeconge=$typeCongeRepos->findAll();

        return $this->render('user/pages/demanderConge.html.twig', [
            'controller_name' => 'DemanderCongeController',
            'typesconge'=>$typeconge,
        ]);
    }

    #[Route('/user/requestConge', name: 'requestConge')]
    public function requestConge(TypeCongeRepository $typeCongeRepos,SessionInterface $session,Request $request,EntityManagerInterface $entityManager): Response
    {
        //retrieve data from ajax
        $data = json_decode($request->getContent(), true);
        $datedubet=DateTimeImmutable::createFromFormat('Y-m-d', $data['dataDebut']);
        $datefin=DateTimeImmutable::createFromFormat('Y-m-d', $data['dateFin']);
        //adding new conge
        $conge=new Conge();
        $conge->setDateDebutConge($datedubet);
        $conge->setDateFinConge($datefin);
        $typeconge = $entityManager->getRepository(TypeConge::class)->find($data['typeconge']);
        $conge->setTypeConge($typeconge);
        //calcul duree du congé
        $dureeconge=calculjourConge( );
        $conge->setDureeConge();
        //flushing data to database
        $entityManager->persist($conge);
        $entityManager->flush();

        //adding demandeconge
        $demandeconge=new DemandeConge();
        $demandeconge->setEtatDemande('en cours');
        $demandeconge->setReasonConge($data['explication']);
        $demandeconge->setCongeDemande($conge);
        //get employe from session
        $empid=$session->get("empid");
        $employe=$entityManager->getRepository(Personnel::class)->find($empid);
        $demandeconge->setPersonnelDemande($employe);
        //flushing data to database
        $entityManager->persist($demandeconge);
        $entityManager->flush();


        $typeconge=$typeCongeRepos->findAll();
        return $this->render('user/pages/demanderConge.html.twig', [
            'controller_name' => 'DemanderCongeController',
            'typesconge'=>$typeconge,
        ]);
    }
}
