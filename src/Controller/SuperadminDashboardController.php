<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Repository\VisitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SuperadminDashboardController extends AbstractController
{
    #[Route('/super-admin/dashboard', name: 'super_admin_dashboard')]
    public function analytics(EntityManagerInterface $entityManager): Response
    {
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder
            ->select('v.visitorDate AS visitDate, COUNT(v.id) AS visitCount')
            ->from('App\Entity\Visitor', 'v')
            ->groupBy('visitDate')
            ->orderBy('visitDate');

        $result = $queryBuilder->getQuery()->getArrayResult();

        $labels = array_column($result, 'visitDate');
        $data = array_column($result, 'visitCount');

        $allvisitors=$entityManager->getRepository(Visitor::class)->findAll();
        $totalvisitors=count($allvisitors);

        return $this->render('superadmin/pages/index.html.twig', [
            'labels' => $labels,
            'data' => $data,
            'total'=>$totalvisitors,
        ]);
    }

}
