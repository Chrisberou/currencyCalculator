<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;


class IndexController extends AbstractController
{
    
    #[Route('/', name: 'app_index', methods: ['GET', 'POST'])]
    public function index(Request $request, Connection $connection, Security $security): Response
    {

        if ($request->isMethod('GET')) {
            // Handle the GET request here, e.g., display the login form.
            return $this->render('index/index.html.twig', [
                'controller_name' => 'IndexController',
            ]);
        } else {
            $data = json_decode($request->getContent(), true);
            // Check if the required keys exist in the $data array
            if (!isset($data['email']) || !isset($data['password'])) {
                return $this->json(['error' => 'Email and password are required.'], Response::HTTP_BAD_REQUEST);
            }
    
            $email = $data['email'];
            $password = $data['password'];

        // Your login logic and database interaction here.
        

        // For demonstration purposes, let's use basic validation.
        // In a real application, you should use a more secure approach (e.g., password hashing).
        $query = 'SELECT * FROM users WHERE email = :email';
        $user = $connection->executeQuery($query, ['email' => $email])->fetchAssociative();

        if ($user && $user['password'] === $password) {
            $session = $request->getSession();
            $isAdmin = $user['admin'] === 1 ? true : false;
              $session->set('isLogged', true);
              $session->set('isAdmin',$isAdmin);
            // Successfully logged in, return JSON response indicating success.
            return new JsonResponse(['success' => true, 'user' => $user]);
        } else {
            // Invalid credentials or user not found, return JSON response indicating failure.
            return $this->json(['success' => false]);
        }
    }
    }

    #[Route('/main', name: 'main_index')]
    public function main(Request $request): Response
    {
        // Get the current user
        $session = $request->getSession();
        $isLogged = $session->get('isLogged', false); // Retrieve the value of 'isLogged' from the session
    
        // Check if the user is logged in
        if ($isLogged) {
            // User is logged in, render the main page
            return $this->render('index/main.html.twig', [
                'controller_name' => 'IndexController',
            ]);
            $session->set('isLogged', false);
        } else {
            // User is not logged in, redirect to the root path
            return $this->redirectToRoute('app_index');
        }
    }
    
    #[Route("/crud",name: 'crud_index')]
    public function crudIndex(Request $request): Response
    {
        // Get the current user
        $session = $request->getSession();
        $isLogged = $session->get('isLogged', false); // Retrieve the value of 'isLogged' from the session
    
        // Check if the user is logged in
        if ($isLogged) {
            // User is logged in, render the main page
            return $this->render('index/crud.html.twig', [
                'controller_name' => 'IndexController',
            ]);
            $session->set('isLogged', false);
        } else {
            // User is not logged in, redirect to the root path
            return $this->redirectToRoute('app_index');
        }
          
    }
}