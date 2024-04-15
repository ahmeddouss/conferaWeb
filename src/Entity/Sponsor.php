<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "nom", type: "string", length: 20, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]*$/',
        message: 'The value "{{ value }}" contains non characters.'
    )]
    #[Assert\Length(max: 20)]
    private $nom;

    #[ORM\Column(name: "email", type: "string", length: 30, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 30)]
    private $email;

    #[ORM\Column(name: "numtel", type: "string", length: 8, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Range(min: 10000000, max: 99999999)]

   

    private $numtel;

    #[ORM\Column(name: "status", type: "string", length: 20, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
  
    #[Assert\Choice(choices: ["accepted", "rejected"])]
    private $status;

    #[ORM\Column(name: "budget", type: "float", nullable: true)]
    #[Assert\Type(type: "float")]
    private $budget;

    #[ORM\Column(name: "cause", type: "string", length: 30, nullable: true)]
    #[Assert\Length(max: 30)]

    private $cause;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(string $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(?float $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getCause(): ?string
    {
        return $this->cause;
    }

    public function setCause(?string $cause): static
    {
        $this->cause = $cause;

        return $this;
    }
}
