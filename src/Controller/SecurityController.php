<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
class SecurityController extends AbstractController
{
    private $tokenStorage;
    private $requestStack;

    public function __construct(TokenStorageInterface $tokenStorage, RequestStack $requestStack)
    {
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): RedirectResponse
    {
        // Perform any additional logout logic if needed

        // Clear the user's session and redirect to the homepage
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        $session->invalidate();
        $this->tokenStorage->setToken(null);

        return $this->redirectToRoute('app_login');
    }
}