<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\EstimatedexpensesRepository;

#[ORM\Entity(repositoryClass: EstimatedexpensesRepository::class)]
class Estimatedexpenses
{
    #[ORM\Column(name: "estimatedExpensesId", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;
    #[ORM\Column(name: "ExpensesWay", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "The expenses way cannot be empty")]
    private $expensesway;

    #[ORM\Column(name: "pessimisticExpenses", type: "float", precision: 10, scale: 0, nullable: true)]
    #[Assert\Type(type: "float", message: "The value must be a decimal number")]
    private $pessimisticexpenses;

    #[ORM\Column(name: "realisticExpenses", type: "float", precision: 10, scale: 0, nullable: true)]
    #[Assert\Type(type: "float", message: "The value must be a decimal number")]
    private $realisticexpenses;

    #[ORM\Column(name: "optimisticExpenses", type: "float", precision: 10, scale: 0, nullable: true)]
    #[Assert\Type(type: "float", message: "The value must be a decimal number")]
    private $optimisticexpenses;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpensesway(): ?string
    {
        return $this->expensesway;
    }

    public function setExpensesway(?string $expensesway): self
    {
        $this->expensesway = $expensesway;

        return $this;
    }

    public function getPessimisticexpenses(): ?float
    {
        return $this->pessimisticexpenses;
    }

    public function setPessimisticexpenses(?float $pessimisticexpenses): self
    {
        $this->pessimisticexpenses = $pessimisticexpenses;

        return $this;
    }

    public function getRealisticexpenses(): ?float
    {
        return $this->realisticexpenses;
    }

    public function setRealisticexpenses(?float $realisticexpenses): self
    {
        $this->realisticexpenses = $realisticexpenses;

        return $this;
    }

    public function getOptimisticexpenses(): ?float
    {
        return $this->optimisticexpenses;
    }

    public function setOptimisticexpenses(?float $optimisticexpenses): self
    {
        $this->optimisticexpenses = $optimisticexpenses;

        return $this;
    }
}
