<?php

// src/Security/AuthenticationSuccessHandler.php

// src/Security/AuthenticationSuccessHandler.php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Routing\RouterInterface;

class CustomAuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        if ($this->isRh($token)) {
            return $this->redirectToRoute('rh_dashboard');
        }else if($this->isAdmin($token)){
            return $this->redirectToRoute('user_dashboard');
        }else if($this->isSuperAdmin($token)){
            return $this->redirectToRoute('super_admin_dashboard');
        }

        // Redirect to another route for regular users
        return $this->redirectToRoute('user_dashboard');
    }

    private function isRh(TokenInterface $token): bool
    {
        // Replace this logic with your own to determine if the user is a super admin
        return in_array('ROLE_RH', $token->getRoleNames());
    }
    private function isAdmin(TokenInterface $token): bool
    {
        // Replace this logic with your own to determine if the user is a super admin
        return in_array('ROLE_ADMIN', $token->getRoleNames());
    }
    private function isSuperAdmin(TokenInterface $token): bool
    {
        // Replace this logic with your own to determine if the user is a super admin
        return in_array('ROLE_SUPER_ADMIN', $token->getRoleNames());
    }

    private function redirectToRoute(string $route): Response
    {
        $url = $this->router->generate($route);

        return new Response(null, Response::HTTP_FOUND, ['Location' => $url]);
    }
}