<?php

namespace App\Entity;

use App\Entity\Emplacement;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConferenceRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ConferenceRepository::class)]
#[ORM\Table(name: "conference")]
class Conference
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "integer", nullable: false)]
    private $id;

    #[ORM\Column(type: "string", length: 20, nullable: false)]
    #[Assert\NotBlank(message: "Conference name cannot be empty")]
    #[Assert\Length(max: 20, maxMessage: "Conference name cannot be longer than {{ limit }} characters")]
    #[Assert\Regex(
        pattern: "/^\D.*$/",
        message: "Conference name cannot begin with a number"
    )]
    private $nom;

    #[ORM\Column(type: "date", nullable: false)]
    #[Assert\NotBlank(message: "Conference date cannot be empty")]
    #[Assert\GreaterThanOrEqual(value: "today", message: "Conference date should not be in the past")]
    private $date;

    #[ORM\Column(type: "string", length: 500, nullable: false)]
    #[Assert\NotBlank(message: "Conference subject cannot be empty")]
    private $sujet;

    #[ORM\Column(type: "float", precision: 10, scale: 0, nullable: false)]
    #[Assert\NotBlank(message: "Conference budget cannot be empty")]
    #[Assert\GreaterThanOrEqual(value: 300, message: "Conference budget must be at least {{ compared_value }}")]
    #[Assert\PositiveOrZero(message: "Conference budget cannot be negative")]
    private $budget;

    #[ORM\Column(type: "boolean", nullable: false)]
    private $typeconf;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $image;
    // #[ORM\ManyToOne(targetEntity: "Session")]
    // #[ORM\JoinColumn(name: "idSession", referencedColumnName: "id")]
    

    #[ORM\ManyToOne(targetEntity: Emplacement::class)]
    #[ORM\JoinColumn(name: "emplacement", referencedColumnName: "id")]

    private $emplacement;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;
        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): static
    {
        $this->budget = $budget;
        return $this;
    }

    public function isTypeconf(): ?bool
    {
        return $this->typeconf;
    }

    public function setTypeconf(bool $typeconf): static
    {
        $this->typeconf = $typeconf;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getEmplacement(): ?Emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(?Emplacement $emplacement): static
    {
        $this->emplacement = $emplacement;
        return $this;
    }
}
