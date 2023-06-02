<?php

namespace App\Controller;

use App\Repository\PersonnelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DemandeAttestaionController extends AbstractController
{
    #[Route('/user/attestaion', name: 'demande_attestaion')]
    public function index(PersonnelRepository $personnelRepo,TokenStorageInterface $tokenStorage): Response
    {
        // Retrieve the authenticated user's token
        $token = $tokenStorage->getToken();
        $username = $token?->getUser()->getUserIdentifier();
        //get employe info from mail
        $personnelInfo=$personnelRepo->findBy(['mail'=>$username]);

        return $this->render('user/pages/demandeattestation.html.twig', [
            'controller_name' => 'DemandeAttestaionController',
            'persoid'=>$personnelInfo[0]->getId(),
        ]);
    }
}
