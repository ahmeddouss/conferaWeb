<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EstimatedincomesRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EstimatedincomesRepository::class)]
class Estimatedincomes
{
    #[ORM\Column(name: "estimatedIncomesId", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "incomeSource", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "La source de revenu ne peut pas être vide")]
    private $incomesource;

    #[ORM\Column(name: "pessimisticIncome", type: "float", precision: 10, scale: 0, nullable: true)]
    #[Assert\Type(type: "float", message: "La valeur doit être un nombre décimal")]
    private $pessimisticincome;

    #[ORM\Column(name: "realisticIncome", type: "float", precision: 10, scale: 0, nullable: true)]
    #[Assert\Type(type: "float", message: "La valeur doit être un nombre décimal")]
    private $realisticincome;

    #[ORM\Column(name: "optimisticIncome", type: "float", precision: 10, scale: 0, nullable: true)]
    #[Assert\Type(type: "float", message: "La valeur doit être un nombre décimal")]
    private $optimisticincome;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIncomesource(): ?string
    {
        return $this->incomesource;
    }

    public function setIncomesource(?string $incomesource): self
    {
        $this->incomesource = $incomesource;

        return $this;
    }

    public function getPessimisticincome(): ?float
    {
        return $this->pessimisticincome;
    }

    public function setPessimisticincome(?float $pessimisticincome): self
    {
        $this->pessimisticincome = $pessimisticincome;

        return $this;
    }

    public function getRealisticincome(): ?float
    {
        return $this->realisticincome;
    }

    public function setRealisticincome(?float $realisticincome): self
    {
        $this->realisticincome = $realisticincome;

        return $this;
    }

    public function getOptimisticincome(): ?float
    {
        return $this->optimisticincome;
    }

    public function setOptimisticincome(?float $optimisticincome): self
    {
        $this->optimisticincome = $optimisticincome;

        return $this;
    }
}
