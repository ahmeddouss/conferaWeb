<?php

namespace App\Entity;

use App\Repository\UidcardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UidcardRepository::class)]
class Uidcard
{
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "uid", type: "string", length: 10, nullable: false)]
    private $uid;

    #[ORM\Column(name: "currentTime", type: "datetime", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private $currenttime;

    #[ORM\Column(name: "status", type: "integer", nullable: false)]
    private $status = '0';

    #[ORM\ManyToOne(targetEntity: "User")]
    #[ORM\JoinColumn(name: "idParticipant", referencedColumnName: "id")]
    private $idparticipant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getCurrenttime(): ?\DateTimeInterface
    {
        return $this->currenttime;
    }

    public function setCurrenttime(\DateTimeInterface $currenttime): static
    {
        $this->currenttime = $currenttime;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getIdparticipant(): ?User
    {
        return $this->idparticipant;
    }

    public function setIdparticipant(?User $idparticipant): static
    {
        $this->idparticipant = $idparticipant;

        return $this;
    }
}
