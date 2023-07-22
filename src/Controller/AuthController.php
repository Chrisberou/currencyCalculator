<?php
// src/Controller/AuthController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends AbstractController
{
    #[Route("/api/get_is_admin", methods: ['GET'])]
    public function getIsAdmin(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $isAdmin = $session->get('isAdmin', false);

        return new JsonResponse(['isAdmin' => $isAdmin]);
    }
}
