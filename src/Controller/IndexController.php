<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Connection;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['POST'])]
    public function index(Request $request, Connection $connection): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
       // Check if the required keys exist in the $data array
    if (!isset($data['email']) || !isset($data['password'])) {
        return new JsonResponse(['error' => 'Email and password are required.'], Response::HTTP_BAD_REQUEST);
    }

    $email = $data['email'];
    $password = $data['password'];

        // Your login logic and database interaction here.
        // Check if the provided email and password are valid.

        // For demonstration purposes, let's use basic validation.
        // In a real application, you should use a more secure approach (e.g., password hashing).
        $query = 'SELECT * FROM users WHERE email = :email';
        $user = $connection->executeQuery($query, ['email' => $email])->fetchAssociative();

        if ($user && $user['password'] === $password) {
            // Successfully logged in, return JSON response indicating success.
            return new JsonResponse(['success' => true]);
        } else {
            // Invalid credentials or user not found, return JSON response indicating failure.
            return new JsonResponse(['success' => false]);
        }
    }

    #[Route('/main', name: 'main_index')]
    public function login(): Response
    {
        
        return $this->render('index/main.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}