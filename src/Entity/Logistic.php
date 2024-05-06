<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LogisticRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LogisticRepository::class)]
class Logistic
{
    #[ORM\Column(name: "logisticID", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "providedLog", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "The provided log field cannot be empty")]
    private $providedlog;

    #[ORM\Column(name: "quantity", type: "integer", nullable: true)]
    #[Assert\NotBlank(message: "The quantity field cannot be empty")]
    #[Assert\Type(type: "integer", message: "The value must be an integer")]
    private $quantity;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProvidedlog(): ?string
    {
        return $this->providedlog;
    }

    public function setProvidedlog(?string $providedlog): self
    {
        $this->providedlog = $providedlog;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
