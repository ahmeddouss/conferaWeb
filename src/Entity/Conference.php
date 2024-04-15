<?php

namespace App\Entity;

use App\Repository\ConferenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConferenceRepository::class)]
class Conference
{
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "nom", type: "string", length: 20, nullable: false)]
    private $nom;

    #[ORM\Column(name: "date", type: "date", nullable: false)]
    private $date;

    #[ORM\Column(name: "sujet", type: "string", length: 30, nullable: false)]
    private $sujet;

    #[ORM\Column(name: "budget", type: "float", precision: 10, scale: 0, nullable: false)]
    private $budget;

    #[ORM\Column(name: "typeConf", type: "string", length: 10, nullable: false, options: ["default" => "PUBLIC"])]
    private $typeconf = 'PUBLIC';

    #[ORM\Column(name: "image", type: "string", length: 255, nullable: false)]
    private $image;

    #[ORM\Column(name: "emplacement", type: "integer", nullable: false)]
    private $emplacement;

    #[ORM\Column(name: "organisateur", type: "integer", nullable: false)]
    private $organisateur;

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

    public function getTypeconf(): ?string
    {
        return $this->typeconf;
    }

    public function setTypeconf(string $typeconf): static
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

    public function getEmplacement(): ?int
    {
        return $this->emplacement;
    }

    public function setEmplacement(int $emplacement): static
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getOrganisateur(): ?int
    {
        return $this->organisateur;
    }

    public function setOrganisateur(int $organisateur): static
    {
        $this->organisateur = $organisateur;

        return $this;
    }
}
