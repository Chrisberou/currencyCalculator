<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


class Currency
{
   
    private $id;
    private $code; 
    private $name;

    // Getter and setter methods for the properties

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
