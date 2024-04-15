<?php

namespace App\Entity;
use App\Repository\SessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;
    #[Assert\NotBlank(message: "Session Name is Blank")]
    #[ORM\Column(name: "sessionName", type: "string", length: 30, nullable: false)]
    private $sessionname;


    #[Assert\NotBlank(message: "Start time not selected")]
    #[ORM\Column(name: "startTime", type: "time", nullable: false)]
    private $starttime;
    #[Assert\NotNull(message: "Start time not selected")]


#[Assert\Expression(
    "this.getStarttime() === null || this.getEndtime() === null || this.getStarttime() < this.getEndtime()",
    message: "Start time must be before end time!"
)]

#[ORM\Column(name: "endTime", type: "time", nullable: false)]
    private $endtime;

    #[ORM\Column(name: "presenceNbr", type: "integer", nullable: false)]
    private $presencenbr = '0';

    #[ORM\Column(name: "presenceQuality", type: "integer", nullable: false)]
    private $presencequality = '0';

    #[ORM\Column(name: "presenceSpent", type: "integer", nullable: false)]
    private $presencespent = '0';

    #[ORM\ManyToOne(targetEntity: "Conference")]
    #[ORM\JoinColumn(name: "idConference", referencedColumnName: "id")]
    private $idconference;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionname(): ?string
    {
        return $this->sessionname;
    }

    public function setSessionname(string $sessionname): static
    {
        $this->sessionname = $sessionname;

        return $this;
    }

    public function getStarttime(): ?\DateTimeInterface
    {
        return $this->starttime;
    }

    public function setStarttime(\DateTimeInterface $starttime): static
    {
        $this->starttime = $starttime;

        return $this;
    }

    public function getEndtime(): ?\DateTimeInterface
    {
        return $this->endtime;
    }

    public function setEndtime(\DateTimeInterface $endtime): static
    {
        $this->endtime = $endtime;

        return $this;
    }

    public function getPresencenbr(): ?int
    {
        return $this->presencenbr;
    }

    public function setPresencenbr(int $presencenbr): static
    {
        $this->presencenbr = $presencenbr;

        return $this;
    }

    public function getPresencequality(): ?int
    {
        return $this->presencequality;
    }

    public function setPresencequality(int $presencequality): static
    {
        $this->presencequality = $presencequality;

        return $this;
    }

    public function getPresencespent(): ?int
    {
        return $this->presencespent;
    }

    public function setPresencespent(int $presencespent): static
    {
        $this->presencespent = $presencespent;

        return $this;
    }

    public function getIdconference(): ?Conference
    {
        return $this->idconference;
    }

    public function setIdconference(?Conference $idconference): static
    {
        $this->idconference = $idconference;

        return $this;
    }
}
