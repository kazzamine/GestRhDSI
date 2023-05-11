<?php

namespace App\Controller\gestEmploye;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpMenuController extends AbstractController
{
    #[Route('/empMenu', name: 'empMenu')]
    public function index(): Response
    {
        return $this->render('admin/pages/empMenu.html.twig', [
            'controller_name' => 'empMenu',
        ]);
    }


}
