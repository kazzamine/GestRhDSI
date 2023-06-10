<?php

namespace App\Controller\gestEmploye;

use App\Entity\CongeJours;
use App\Entity\Personnel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PersonnelRepository;

class EmpListeController extends AbstractController
{
    #[Route('/RH/empMenu/listEmp', name: 'listEmp')]
    public function index(PersonnelRepository $persoRep): Response
    {

        $personnelsListe=$persoRep->findAll();

        return $this->render('RH/pages/empListe.html.twig', [
            'controller_name' => 'listeEmploye',
            'persoListe'=>$personnelsListe,
        ]);
    }

    #[Route('/RH/empMenu/deleteemp', name: 'deleteEmploye')]
    public function deleteEmp(Request $request,EntityManagerInterface $entityManager): Response
    {
        $empid=$request->request->get('id');
        $personTodelete=$entityManager->getRepository(Personnel::class)->findBy(['id'=>$empid]);

        $deletefromConge=$entityManager->getRepository(CongeJours::class)->findBy(['personnelcin'=>$empid]);
        $entityManager->remove($deletefromConge[0]);
        $entityManager->flush();
        $entityManager->remove($personTodelete);
        $entityManager->flush();

        return $this->redirectToRoute('listEmp');
    }

}
