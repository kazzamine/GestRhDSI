<?php

namespace App\Controller\gererAdministration;

use App\Entity\Devision;
use App\Entity\Direction;
use App\Entity\Login;
use App\Entity\Personnel;
use App\Entity\Service;
use App\Repository\DevisionRepository;
use App\Repository\DirectionRepository;
use App\Repository\GradeRepository;
use App\Repository\PersonnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GererdivisionController extends AbstractController
{
    #[Route('/super-admin/gererdivision', name: 'gererdivision')]
    public function index(): Response
    {
        return $this->render('superadmin/pages/devisions/division.html.twig', [
            'controller_name' => 'GererdivisionController',
        ]);
    }

    #[Route('/super-admin/gererdivision/listedevisions', name: 'listedevisions')]
    public function listedevisions(DevisionRepository $devRepo): Response
    {
        $devisions=$devRepo->findAll();
        return $this->render('superadmin/pages/devisions/listedevisions.html.twig', [
            'controller_name' => 'GererdivisionController',
            'devisions'=>$devisions
        ]);
    }

    #[Route('/super-admin/gererdivision/ajouterdevision', name: 'ajouterdevision')]
    public function ajouterdevision(DirectionRepository $directRepo,PersonnelRepository $persoRepo,GradeRepository $gradeRepo): Response
    {
        //get high grades
        $grades=$gradeRepo->findBy(['nom_grade'=>'INGENIEUR EN CHEF 1 ER GRADE']);
        $infoDirection=$directRepo->findAll();
        $respos=$persoRepo->findBy(['grade'=>$grades[0]->getId()]);
        return $this->render('superadmin/pages/devisions/adddevision.html.twig', [
            'controller_name' => 'GererdivisionController',
            'directions'=>$infoDirection,
            'respos'=>$respos,
        ]);
    }
    #[Route('/super-admin/gererdivision/insertdevision', name: 'insertdevision')]
    public function insertdevision(Request $request,EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        //getting direction
        $direction=$entityManager->getRepository(Direction::class)->find($data['direction']);
        //getting responasble
        $respo=$entityManager->getRepository(Personnel::class)->find($data['responsable']);
        $respo->setRole('ROLE_ADMIN');
        $entityManager->persist($respo);
        $entityManager->flush();
        //new devision
        $devison=new Devision();
        $devison->setNomDevision($data['nomdivision']);
        $devison->setDirection($direction);
        $devison->setResponsable($respo);
        $entityManager->persist($devison);
        $entityManager->flush();

        $login=$entityManager->getRepository(Login::class)->findBy(['email'=>$respo->getMail()]);
        $login[0]->setRoles(['1'=>'ROLE_ADMIN']);
        $entityManager->persist($login[0]);
        $entityManager->flush();

        $id=$devison->getId();
        return new Response($id);
    }

    #[Route('/super-admin/deletedevision', name: 'deletedevision')]
    public function deletedevision()
    {
        return $this->render('superadmin/pages/devisions/division.html.twig', [
            'controller_name' => 'GererdivisionController',
        ]);
    }

    //gerer devision admin
    #[Route('/admin/gererdev', name: 'gererdev')]
    public function gererdev(EntityManagerInterface $entityManager,SessionInterface $session): Response
    {
        $adminid=$session->get('empid');
        $admin=$entityManager->getRepository(Personnel::class)->find($adminid);
        $devision=$entityManager->getRepository(Devision::class)->findBy(['responsable'=>$admin]);
        $personnels=$entityManager->getRepository(Personnel::class)->findBy(['role'=>'ROLE_USER']);
        $serv=$entityManager->getRepository(Service::class)->findBy(['devision'=>$devision]);
        $personnelsDev=$entityManager->getRepository(Personnel::class)->findBy(['devision'=>$devision]);
        return $this->render('admin/updateDivision.html.twig', [
            'controller_name' => 'GererdivisionController',
            'services'=>$serv,
            'users'=>$personnels,
            'devisionid'=>$devision,
            'employes'=>$personnelsDev,
        ]);
    }

    #[Route('/admin/gererdev/updatedev', name: 'updatedev')]
    public function updatedev(Request $request,EntityManagerInterface $entityManager): Response
    {
        $personnel=$request->request->get('personnel');
        $service=$request->request->get('service');
        $devid=$request->request->get('devisionid');
        $perso=$entityManager->getRepository(Personnel::class)->find($personnel);
        $serv=$entityManager->getRepository(Service::class)->find($service);
        $devi=$entityManager->getRepository(Devision::class)->find($devid);
        $perso->setService($serv);
        $perso->setDevision($devi);
        $entityManager->persist($perso);
        $entityManager->flush();
        return $this->redirectToRoute('gererdev');
    }
}
