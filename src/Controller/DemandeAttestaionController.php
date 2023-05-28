<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAttestaionController extends AbstractController
{
    #[Route('/user/attestaion', name: 'demande_attestaion')]
    public function index(): Response
    {
        return $this->render('user/pages/demandeattestation.html.twig', [
            'controller_name' => 'DemandeAttestaionController',
        ]);
    }
}
