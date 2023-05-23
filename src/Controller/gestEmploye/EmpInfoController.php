<?php
namespace App\Controller\gestEmploye;

use App\Entity\Grade;
use App\Entity\Personnel;
use App\Entity\Poste;
use App\Repository\CongeJoursRepository;
use App\Service\CommonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PersonnelRepository;
use App\Repository\AbsenceRepository;
use App\Repository\PosteRepository;
use App\Repository\GradeRepository;
use Doctrine\ORM\EntityManagerInterface;


class EmpInfoController extends AbstractController
{
    #[Route('/RH/empMenu/listEmp/empInfo', name: 'empInfo')]
    public function index(Request $request,PersonnelRepository $persoRepo,AbsenceRepository $absenceRepo,PosteRepository $posteRepo,GradeRepository $gradeRepo,CongeJoursRepository $congeJourRepo): Response
    {
        //get postes
        $postes=$posteRepo->findAll();
        //get grades
        $grades=$gradeRepo->findAll();
        //get ppr of selected employe
        $pprParam=$request->query->get('ppr');
        //find employe by ppr
        $personnelInfo=$persoRepo->findBy(['PPR'=>$pprParam]);
        //find employe absence
        $empID=$personnelInfo[0]->getId();
        $empAbsence=$absenceRepo->findBy(['employe_abse'=>$empID]);
        //find employe conge
        $empconge=$congeJourRepo->findBy(['personnelcin'=>$empID]);
        $congerest=$empconge[0]->getNombreCongeNormal();
        $congePasse=22-$congerest;
        $absenceCount=0;
        if(!empty($empAbsence)){
            $absenceCount=count($empAbsence);
        }

//        $commonser=new CommonService();
//        $totalDays=$commonser->calculjourConge($datedebut,$datefin,$days);
//        $daysToRemove= $getjour[0]->getNombreCongeNormal()-$totalDays;

        return $this->render('RH/pages/infoPersonnel.html.twig', [
            'controller_name' => 'employeInfo',
            'empInfo'=>$personnelInfo,
            'absenceNumber'=>$absenceCount,
            'postes'=>$postes,
            'grades'=>$grades,
            'congepasse'=>$congePasse,
            'congerest'=>$congerest
        ]);
    }

    #[Route('/empMenu/listEmp/empInfo/updateinfo', name: 'updateinfo', methods: 'POST')]
    public function updateEmpInfo(Request $request,EntityManagerInterface $entityManager): Response {
        $data = json_decode($request->getContent(), true);
        $cin=$data['cin'];
        $telephone=$data['telephone'];
        $adresse=$data['adresse'];
        $posteId=$data['poste'];
        $gradeId=$data['grade'];
        $entity = $entityManager->getRepository(Personnel::class)->findBy(['CIN'=>$cin]);
        $response=null;
        if ($entity) {
            $entity[0]->setTelephone($telephone);
            $entity[0]->setAdresse($adresse);

            $poste = $entityManager->getRepository(Poste::class)->find($posteId);
            $entity[0]->setPoste($poste);
            $grade = $entityManager->getRepository(Grade::class)->find($gradeId);
            $entity[0]->setGrade($grade);
            $entityManager->flush();
            $response=new Response('success');
        }

        return $response;
    }

}