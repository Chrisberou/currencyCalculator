<?php
// src/Repository/UserRepository.php


namespace App\Repository;

use App\Entity\User;
use PDO;

class UserRepository
{
    
    private $connection;

    public function __construct(PDO $pdo_connection)
    {
        $this->connection = $pdo_connection;
    }
    public function findByEmail(string $email): ?User
    {
        // Perform the query to fetch user data from the database based on email
        // Replace this with your actual query implementation
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        // Retrieve the user data and create a User object
        $userData = $stmt->fetch();

        if ($userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);
            return $user;
        }

        return null;
    }
    public function authenticateUser(string $email, string $password): ?User
    {
        // Fetch user data by email from the database
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData || !password_verify($password, $userData['password'])) {
            // Invalid email or password
            return null;
        }

        // Valid user, create and return User object
        $user = new User();
        $user->setEmail($userData['email']);
        $user->setPassword($userData['password']);

        return $user;
    }
}