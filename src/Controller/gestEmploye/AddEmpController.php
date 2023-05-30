<?php

namespace App\Controller\gestEmploye;

use App\Entity\Contract;
use App\Entity\Devision;
use App\Entity\Grade;
use App\Entity\Login;
use App\Entity\Personnel;
use App\Entity\Service;
use App\Repository\DevisionRepository;
use App\Repository\GradeRepository;
use App\Repository\PosteRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class AddEmpController extends AbstractController
{
    #[Route('/RH/empMenu/addEmp', name: 'addEmp')]
    public function index(PosteRepository $posteRepo,GradeRepository $gradeRepo,DevisionRepository $devrepo,ServiceRepository $servRepo): Response
    {
        //get devision
        $devisions=$devrepo->findAll();
        //get services
        $services=$servRepo->findAll();
        //get grades
        $grades=$gradeRepo->findAll();

        return $this->render('RH/pages/addEmp.html.twig', [
            'controller_name' => 'AddEmpController',
            'grades'=>$grades,
            'services'=>$services,
            'devisions'=>$devisions,
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
        $devisionId=$data['devision'];
        $serviceId=$data['service'];
        $devision=$entityManager->getRepository(Devision::class)->find($devisionId);
        $service=$entityManager->getRepository(Service::class)->find($serviceId);
        $personnelObj->setService($service);
        $personnelObj->setDevision($devision);

        $personnelObj->setSexe($data['sexe']);

        $contract = $entityManager->getRepository(Contract::class)->find($data['idcontract']);
        $personnelObj->setContract($contract);

        $entityManager->persist($personnelObj);
        $entityManager->flush();

        // Create a new login instance
        $user = new Login();
        $user->setEmail($data['mail']);

        // Encode the password
        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt']
        ]);
        $passwordHasher = $factory->getPasswordHasher('common');

        $user->setPassword( $passwordHasher->hash($data['ppr']));
        $user->setRoles(['1'=>'ROLE_USER']);
        // Persist and flush the user object using your entity manager
        $entityManager->persist($user);
        $entityManager->flush();

        $response=new Response($personnelObj->getId());
        return $response ;
    }
}
