<?php

namespace App\Controller\gestEmploye;

use App\Entity\Contract;
use App\Entity\Grade;
use App\Entity\Personnel;
use App\Entity\Poste;
use App\Repository\GradeRepository;
use App\Repository\PosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;


class AddEmpController extends AbstractController
{
    #[Route('/RH/empMenu/addEmp', name: 'addEmp')]
    public function index(PosteRepository $posteRepo,GradeRepository $gradeRepo): Response
    {
        //get postes
        $postes=$posteRepo->findAll();
        //get grades
        $grades=$gradeRepo->findAll();

        return $this->render('RH/pages/addEmp.html.twig', [
            'controller_name' => 'AddEmpController',
            'postes'=>$postes,
            'grades'=>$grades,
        ]);
    }

    #[Route('/RH/empMenu/addEmp/add', name: 'addEmployee')]
    public function addEmp(Request $request,EntityManagerInterface $entityManager): Response
    {
        //retrieve data from ajax
        $data = json_decode($request->getContent(), true);

        $personnelObj=new Personnel();

        $personnelObj->setNomPerso($data['nom']);
        $personnelObj->setNomArabic($data['arabnom']);
        $personnelObj->setPrenomPerso($data['prenom']);
        $personnelObj->setCIN($data['cin']);
        $personnelObj->setPPR($data['ppr']);
        $datenaiss = DateTimeImmutable::createFromFormat('Y-m-d', $data['datenaiss']);
        $personnelObj->setDateNaiss($datenaiss);
        $personnelObj->setAdresse($data['adresse']);
        $personnelObj->setTelephone($data['telephone']);
        $personnelObj->setMail($data['mail']);

        $grade = $entityManager->getRepository(Grade::class)->find($data['grade']);
        $personnelObj->setGrade($grade);

        $poste = $entityManager->getRepository(Poste::class)->find($data['poste']);
        $personnelObj->setPoste($poste);
        $personnelObj->setService(null);
        $personnelObj->setDevision(null);

        $personnelObj->setSexe($data['sexe']);

        $contract = $entityManager->getRepository(Contract::class)->find($data['idcontract']);
        $personnelObj->setContract($contract);

        $entityManager->persist($personnelObj);
        $entityManager->flush();


        $response=new Response($personnelObj->getId());
        return $response ;
    }
}
