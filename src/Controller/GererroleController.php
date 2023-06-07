<?php

namespace App\Controller;

use App\Entity\Login;
use App\Entity\Personnel;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GererroleController extends AbstractController
{
    //admin
    #[Route('/superadmin/gererrole', name: 'gererrole')]
    public function index(PersonnelRepository $persoRepo,EntityManagerInterface $entityManager): Response
    {
        $personnels=$persoRepo->findBy(['role'=>'ROLE_ADMIN']);
        $rh=$persoRepo->findBy(['role'=>'ROLE_RH']);
        $users=$persoRepo->findBy(['role'=>'ROLE_USER']);
        return $this->render('superadmin/pages/gererRole.html.twig', [
            'controller_name' => 'GererroleController',
            'personnels'=>$personnels,
            'rh'=>$rh,
            'users'=>$users,
        ]);
    }
    #[Route('/superadmin/deleteadmin', name: 'deleteadmin')]
    public function deleteadmin(EntityManagerInterface $entityManager,Request $request): Response
    {
        $mailpers=$request->query->get('mailpers');
        $login=$entityManager->getRepository(Login::class)->findBy(['email'=>$mailpers]);
        $login[0]->setRoles(['1'=>'ROLE_USER']);
        $entityManager->persist($login[0]);
        $entityManager->flush();
        $pers=$entityManager->getRepository(Personnel::class)->findBy(['mail'=>$mailpers]);
        $pers[0]->setRole('ROLE_USER');
        $entityManager->persist($pers[0]);
        $entityManager->flush();
        return $this->redirectToRoute('gererrole');

    }

    //RH
    #[Route('/superadmin/deleterh', name: 'deleterh')]
    public function deleterh(EntityManagerInterface $entityManager,Request $request): Response
    {
        $mailrh=$request->query->get('mailrh');
        $login=$entityManager->getRepository(Login::class)->findBy(['email'=>$mailrh]);
        $login[0]->setRoles(['1'=>'ROLE_USER']);
        $entityManager->persist($login[0]);
        $entityManager->flush();
        $pers=$entityManager->getRepository(Personnel::class)->findBy(['mail'=>$mailrh]);
        $pers[0]->setRole('ROLE_USER');
        $entityManager->persist($pers[0]);
        $entityManager->flush();
        return $this->redirectToRoute('gererrole');

    }

    #[Route('/superadmin/addrole', name: 'addrole')]
    public function addrole(EntityManagerInterface $entityManager,Request $request): Response
    {
        $mailuser=$request->request->get('personnel');
        $role=$request->request->get('role');

        $login=$entityManager->getRepository(Login::class)->findBy(['email'=>$mailuser]);
        $login[0]->setRoles(['1'=>$role]);
        $entityManager->persist($login[0]);
        $entityManager->flush();
        $pers=$entityManager->getRepository(Personnel::class)->findBy(['mail'=>$mailuser]);
        $pers[0]->setRole($role);
        $entityManager->persist($pers[0]);
        $entityManager->flush();
        return $this->redirectToRoute('gererrole');

    }
}
