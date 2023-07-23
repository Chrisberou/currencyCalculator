<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;


class User 
{
    private $id;
    private $email;
    private $password;
    private $isLogged;
    private $isAdmin; 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getIsLogged(): ?bool
    {
        return $this->isLogged;
    }

    public function setIsLogged(bool $isLogged): self
    {
        $this->isLogged = $isLogged;
        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }
    public function getRoles(): array
    {
        return ['ROLE_USER']; 
    }

    public function getSalt(): ?string
    {
       
        return null;
    }

    public function getUsername(): string
    {
        return $this->email; 
    }

    public function eraseCredentials()
    {
        
    }

   
}
