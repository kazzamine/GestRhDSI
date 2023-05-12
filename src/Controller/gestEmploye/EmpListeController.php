<?php

namespace App\Controller\gestEmploye;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PersonnelRepository;

class EmpListeController extends AbstractController
{
    #[Route('/admin/empMenu/listEmp', name: 'listEmp')]
    public function index(PersonnelRepository $persoRep): Response
    {

        $personnelsListe=$persoRep->findAll();

        return $this->render('admin/pages/empListe.html.twig', [
            'controller_name' => 'listeEmploye',
            'persoListe'=>$personnelsListe,
        ]);
    }


}
