<?php

namespace App\Controller\conge;

use App\Repository\DemandeCongeRepository;
use App\Service\CommonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeCongeAdminController extends AbstractController
{
    #[Route('/admin/conge/demande', name: 'conge_admin')]
    public function index(DemandeCongeRepository $demandeCongeRepo): Response
    {
        $congeList=$demandeCongeRepo->findBy(['etatDemande'=>'en cours']);
        $commonser=new CommonService();

        return $this->render('admin/demandeConge.html.twig', [
            'controller_name' => 'CongeController',
            'congeList'=>$congeList,
        ]);
    }
}
