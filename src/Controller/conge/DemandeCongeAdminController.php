<?php

namespace App\Controller\conge;

use App\Entity\DemandeConge;
use App\Repository\CongeJoursRepository;
use App\Repository\DemandeCongeRepository;
use App\Service\CommonService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeCongeAdminController extends AbstractController
{
    #[Route('/admin/conge/demande', name: 'conge_admin')]
    public function index(DemandeCongeRepository $demandeCongeRepo): Response
    {
        $congeList=$demandeCongeRepo->findBy(['etatDemande'=>'en cours','adminApprove'=>'en cours']);

        return $this->render('admin/demandeConge.html.twig', [
            'controller_name' => 'CongeController',
            'congeList'=>$congeList,
        ]);
    }

    #[Route('/admin/conge/acceptdemande', name: 'acceptdemande')]
    public function acceptdemande(DemandeCongeRepository $demandeCongeRepo,Request $request,EntityManagerInterface $entityManager): Response
    {

        $id=$request->query->get('id');
        $entity = $entityManager->getRepository(DemandeConge::class)->find($id);
        $entity->setAdminApprove('accepter');

        $entityManager->flush();
        $congeList=$demandeCongeRepo->findBy(['etatDemande'=>'en cours','adminApprove'=>'en cours']);

        return $this->render('admin/demandeConge.html.twig', [
            'controller_name' => 'CongeController',
            'congeList'=>$congeList,
        ]);
    }

    #[Route('/admin/conge/declinedemande', name: 'declinedemande')]
    public function declinedemande(DemandeCongeRepository $demandeCongeRepo,Request $request,EntityManagerInterface $entityManager): Response
    {
        $id=$request->query->get('id');
        $entity = $entityManager->getRepository(DemandeConge::class)->find($id);
        $entity->setAdminApprove('refuser');
        $entityManager->flush();
        $congeList=$demandeCongeRepo->findBy(['etatDemande'=>'en cours','adminApprove'=>'en cours']);

        return $this->render('admin/demandeConge.html.twig', [
            'controller_name' => 'CongeController',
            'congeList'=>$congeList,
        ]);
    }
}
