<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LogisticincomeRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LogisticincomeRepository::class)]
class Logisticincome
{
    #[ORM\Column(name: "logIncomeId", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "logSponsorName", type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank(message: "The sponsor name cannot be empty")]
    private $logsponsorname;

    #[ORM\Column(name: "logIncomeQty", type: "integer", nullable: true)]
    #[Assert\NotBlank(message: "The income quantity cannot be empty")]
    #[Assert\Type(type: "integer", message: "The value must be an integer")]
    private $logincomeqty;

    #[ORM\Column(name: "logProof", type: "blob", nullable: true)]
    private $logproof;

    #[ORM\ManyToOne(targetEntity: Logistic::class)]
    #[ORM\JoinColumn(name: "logisticID", referencedColumnName: "logisticID")]
    private $logisticid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogsponsorname(): ?string
    {
        return $this->logsponsorname;
    }

    public function setLogsponsorname(?string $logsponsorname): self
    {
        $this->logsponsorname = $logsponsorname;

        return $this;
    }

    public function getLogincomeqty(): ?int
    {
        return $this->logincomeqty;
    }

    public function setLogincomeqty(?int $logincomeqty): self
    {
        $this->logincomeqty = $logincomeqty;

        return $this;
    }

    public function getLogproof()
    {
        return $this->logproof;
    }

    public function setLogproof($logproof): self
    {
        $this->logproof = $logproof;

        return $this;
    }

    public function getLogistic(): ?int
    {
        return $this->logisticid;
    }

    public function setLogistic(int $logisticid): static
    {
        $this->logisticid = $logisticid;

        return $this;
    }
}
