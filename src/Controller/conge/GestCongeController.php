<?php

namespace App\Controller\conge;

use App\Entity\CongeExceptionnel;
use App\Entity\JourFerier;
use App\Repository\CongeExceptionnelRepository;
use App\Repository\JourFerierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;

class GestCongeController extends AbstractController
{
    #[Route('/super-admin/conge', name: 'gest_conge')]
    public function index(): Response
    {
        return $this->render('superadmin/pages/conge/congeMenu.html.twig', [
            'controller_name' => 'GestCongeController',
        ]);
    }

    #[Route('/super-admin/conge/congeexcept', name: 'congeexcept')]
    public function congeexcept(CongeExceptionnelRepository $congeRepo): Response
    {
        $conges=$congeRepo->findAll();
        return $this->render('superadmin/pages/conge/congeexcept.html.twig', [
            'controller_name' => 'congeexcept',
            'conges'=>$conges,
        ]);
    }
    #[Route('/super-admin/conge/deletecongeexcept', name: 'deletecongeexcept')]
    public function deletecongeexcept(Request $request,EntityManagerInterface $entityManager)
    {
        $idconge=$request->query->get('id');
        $conge=$entityManager->getRepository(CongeExceptionnel::class)->find($idconge);
        $entityManager->remove($conge);
        $entityManager->flush();
        return $this->redirectToRoute('congeexcept');
    }
    #[Route('/super-admin/conge/updatecongexcept', name: 'updatecongexcept')]
    public function updatecongexcept(Request $request,EntityManagerInterface $entityManager)
    {
        $idconge=$request->query->get('id');
        $typeconge=$request->request->get('typeconge');
        $duree=$request->request->get('duree');

        $conge=$entityManager->getRepository(CongeExceptionnel::class)->find($idconge);
        $conge->setTypeconge($typeconge);
        $conge->setDuree($duree);
        $entityManager->persist($conge);
        $entityManager->flush();
        return $this->redirectToRoute('congeexcept');
    }
    #[Route('/super-admin/conge/addcongexcept', name: 'addcongexcept')]
    public function addcongexcept(Request $request,EntityManagerInterface $entityManager)
    {
        $typeconge=$request->request->get('newtypeconge');
        $duree=$request->request->get('newduree');

        $conge=new CongeExceptionnel();
        $conge->setTypeconge($typeconge);
        $conge->setDuree($duree);
        $entityManager->persist($conge);
        $entityManager->flush();
        return $this->redirectToRoute('congeexcept');
    }
    //free days
    #[Route('/super-admin/conge/jourferier', name: 'jourferier')]
    public function jourFerier(JourFerierRepository $freedayRepo): Response
    {
        $jours=$freedayRepo->findAll();
        return $this->render('superadmin/pages/conge/jourferier.html.twig', [
            'controller_name' => 'jourferier',
            'jours'=>$jours,
        ]);
    }
    #[Route('/super-admin/conge/deletejourFerier', name: 'deletejourFerier')]
    public function deletejourFerier(Request $request,EntityManagerInterface $entityManager)
    {
        $id=$request->query->get('id');
        $jour=$entityManager->getRepository(JourFerier::class)->find($id);
        $entityManager->remove($jour);
        $entityManager->flush();
        return $this->redirectToRoute('jourferier');
    }
    #[Route('/super-admin/conge/updatejourFerier', name: 'updatejourFerier')]
    public function updatejourFerier(Request $request,EntityManagerInterface $entityManager)
    {
        $idjour=$request->query->get('id');
        $nomjour=$request->request->get('nomjour');
        $datedebut=$request->request->get('datedebut');
        $datefin=$request->request->get('datefin');

        $jourferier=$entityManager->getRepository(JourFerier::class)->find($idjour);
        $jourferier->setNomJour($nomjour);
        $datedeb = DateTimeImmutable::createFromFormat('Y-m-d', $datedebut);
        $jourferier->setDateDebutJour($datedeb);
        $datfin = DateTimeImmutable::createFromFormat('Y-m-d', $datefin);
        $jourferier->setDateFinJour($datfin);

        $entityManager->persist($jourferier);
        $entityManager->flush();
        return $this->redirectToRoute('jourferier');
    }
    #[Route('/super-admin/conge/addjourFerier', name: 'addjourFerier')]
    public function addjourFerier(Request $request,EntityManagerInterface $entityManager)
    {
        $nomjour=$request->request->get('nomjour');
        $datedebut=$request->request->get('datedebut');
        $duree=$request->request->get('duree');

        $jourferier=new JourFerier();
        $jourferier->setNomJour($nomjour);
        $datedeb = DateTimeImmutable::createFromFormat('Y-m-d', $datedebut);
        $jourferier->setDateDebutJour($datedeb);

        $datfin = $datedeb->add(new \DateInterval('P' . $duree . 'D'));
        //$datfin =DateTimeImmutable::createFromFormat('Y-m-d', $newDate);

        $jourferier->setDateFinJour($datfin);

        $jourferier->setDuree($duree);
        $entityManager->persist($jourferier);
        $entityManager->flush();
        return $this->redirectToRoute('jourferier');
    }
}
