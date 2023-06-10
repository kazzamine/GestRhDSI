<?php

namespace App\Controller;

use Predis\Client;
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
    public function logout(Client $redis,TokenStorageInterface $tokenStorage): RedirectResponse
    {
        $token = $tokenStorage->getToken();
        $username = $token?->getUser()->getUserIdentifier();
        $redis->srem('active_users', $username);

        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        $session->invalidate();
        $this->tokenStorage->setToken(null);

        return $this->redirectToRoute('app_login');
    }
}