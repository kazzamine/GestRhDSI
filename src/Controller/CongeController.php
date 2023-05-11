<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CongeController extends AbstractController
{
    #[Route('/conge', name: 'app_conge')]
    public function index(): Response
    {
        return $this->render('conge/index.html.twig', [
            'controller_name' => 'CongeController',
        ]);
    }


}
