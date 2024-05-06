<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExpensesRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpensesRepository::class)]
class Expenses
{
    #[ORM\Column(name: "expensesId", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "onWhat", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "The 'onWhat' field cannot be empty")]
    private $onwhat;

    #[ORM\Column(name: "expAmmount", type: "integer", nullable: true)]
    #[Assert\NotBlank(message: "The 'expAmmount' field cannot be empty")]
    #[Assert\Type(type: "integer", message: "The value must be an integer")]
    private $expammount;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOnwhat(): ?string
    {
        return $this->onwhat;
    }

    public function setOnwhat(?string $onwhat): self
    {
        $this->onwhat = $onwhat;

        return $this;
    }

    public function getExpammount(): ?int
    {
        return $this->expammount;
    }

    public function setExpammount(?int $expammount): self
    {
        $this->expammount = $expammount;

        return $this;
    }
}
