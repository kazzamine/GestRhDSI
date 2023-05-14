<?php

namespace App\Controller\conge;

use App\Entity\Conge;
use App\Entity\CongeJours;
use App\Entity\Personnel;
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
    public function logconge(): Response
    {
        return $this->render('admin/pages/logconge.html.twig', [
            'controller_name' => 'CongeController',
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

}
