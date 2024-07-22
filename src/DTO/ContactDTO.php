<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    #[Assert\Length(min: 2, max: 40, minMessage: 'Le champ {{ label }} doit contenenir plus de caractére', maxMessage: 'Le champ {{ label }} doit contenenir moins de caractére')]
    private ?string $name = null;

    #[Assert\Length(min: 1, max: 40, minMessage: 'Le champ {{ label }} doit contenenir plus de caractére', maxMessage: 'Le champ {{ label }} doit contenenir moins de caractére')]
    private ?string $email = null;

    #[Assert\NotBlank(message: "Le champ {{ label }} est necessaire")]
    private ?string $message = null;
    
    #[Assert\NotBlank(message: "Le champ {{ label }} est necessaire")]
    private ?string $service =null;



    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
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

    /**
     * Get the value of service
     */ 
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set the value of service
     *
     * @return  self
     */ 
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }
}
