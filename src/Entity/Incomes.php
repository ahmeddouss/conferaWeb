<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\IncomesRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IncomesRepository::class)]
class Incomes
{
    #[ORM\Column(name: "incomesId", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;


    #[ORM\Column(name: "fromWhat", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "The 'fromWhat' field cannot be empty")]
    private $fromwhat;

    #[ORM\Column(name: "incAmmount", type: "integer", nullable: true)]
    #[Assert\NotBlank(message: "The 'incAmmount' field cannot be empty")]
    #[Assert\Type(type: "integer", message: "The value must be an integer")]
    private $incammount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromwhat(): ?string
    {
        return $this->fromwhat;
    }

    public function setFromwhat(?string $fromwhat): self
    {
        $this->fromwhat = $fromwhat;

        return $this;
    }

    public function getIncammount(): ?int
    {
        return $this->incammount;
    }

    public function setIncammount(?int $incammount): self
    {
        $this->incammount = $incammount;

        return $this;
    }
}
