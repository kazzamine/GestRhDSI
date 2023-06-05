<?php

namespace App\Controller;

use App\Entity\Direction;
use App\Entity\Ministre;
use App\Repository\MinistreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DirectionController extends AbstractController
{
    #[Route('/super-admin/direction/adddirection', name: 'adddirection')]
    public function addDirection(MinistreRepository $ministreRepo): Response
    {
        $ministres=$ministreRepo->findAll();
        return $this->render('superadmin/pages/direction/addDirection.html.twig', [
            'controller_name' => 'DirectionController',
            'ministres'=>$ministres,
        ]);
    }
    #[Route('/super-admin/direction/insertdirection', name: 'insertdirection')]
    public function insertdirection(Request $request,EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $direction=new Direction();
        $direction->setNomDirection($data['nomdirection']);
        $ministre=$entityManager->getRepository(Ministre::class)->find($data['ministre']);
        $direction->setMinistereD($ministre);
        $direction->setLocation($data['location']);
        $entityManager->persist($direction);
        $entityManager->flush();

        return $this->redirectToRoute('adddirection');

    }
}
