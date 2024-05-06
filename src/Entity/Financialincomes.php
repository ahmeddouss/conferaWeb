<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FinancialincomesRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FinancialincomesRepository::class)]
class Financialincomes
{
    #[ORM\Column(name: "financialIncomesId", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "sponsorName", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "The sponsor name cannot be empty")]
    private $sponsorname;

    #[ORM\Column(name: "cashIn", type: "integer", nullable: true)]
    #[Assert\NotBlank(message: "The cash in amount cannot be empty")]
    #[Assert\Type(type: "integer", message: "The cash in amount must be an integer")]
    private $cashin;

    #[ORM\Column(name: "proof", type: "blob", nullable: true)]
    private $proof;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSponsorname(): ?string
    {
        return $this->sponsorname;
    }

    public function setSponsorname(?string $sponsorname): self
    {
        $this->sponsorname = $sponsorname;

        return $this;
    }

    public function getCashin(): ?int
    {
        return $this->cashin;
    }

    public function setCashin(?int $cashin): self
    {
        $this->cashin = $cashin;

        return $this;
    }

    public function getProof()
    {
        return $this->proof;
    }

    public function setProof($proof): self
    {
        $this->proof = $proof;

        return $this;
    }
}
