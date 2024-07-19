<?php

namespace App\DTO;


use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    #[Assert\Length(min:2, max:20,minMessage:'Le champ {{ label }} doit contenir plus de caractère', maxMessage:'Le champs contient trop de caractère')]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'Le champs {{ label }} est nécessaire')]
    private ?string $email = null;

    #[Assert\NotBlank(message: 'Le champs {{ label }} est nécessaire')]
    private ?string $message = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?\DateTimeImmutable
    {
        return $this->message;
    }

    public function setMessage(\DateTimeImmutable $message): static
    {
        $this->message = $message;

        return $this;
    }
}
