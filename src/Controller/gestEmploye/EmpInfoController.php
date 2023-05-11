<?php
namespace App\Controller\gestEmploye;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PersonnelRepository;

class EmpInfoController extends AbstractController
{
    #[Route('/empMenu/listEmp/empInfo', name: 'empInfo')]
    public function index(Request $request,PersonnelRepository $persoRepo): Response
    {

        $pprParam=$request->query->get('ppr');
        $personnelInfo=$persoRepo->findBy(['PPR'=>$pprParam]);
        return $this->render('admin/pages/infoPersonnel.html.twig', [
            'controller_name' => 'employeInfo',
            'empInfo'=>$personnelInfo,
        ]);
    }


}