<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Conference
 *
 * @ORM\Table(name="conference", indexes={@ORM\Index(name="emplacement", columns={"emplacement"})})
 * @ORM\Entity(repositoryClass=App\Repository\ConferenceRepository::class)
 * 
 */
class Conference
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Conference name cannot be empty")
     * @Assert\Length(max=20, maxMessage="Conference name cannot be longer than {{ limit }} characters")
     * @Assert\Regex(
     *     pattern="/^\D.*$/",
     *     message="Conference name cannot begin with a number"
     * )
     */
    private $nom;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     * @Assert\NotBlank(message="Conference date cannot be empty")
     * @Assert\GreaterThanOrEqual("today", message="Conference date should not be in the past")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=500, nullable=false)
     * @Assert\NotBlank(message="Conference subject cannot be empty")
     */
    private $sujet;

    /**
     * @var float
     *
     * @ORM\Column(name="budget", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Conference budget cannot be empty")
     * @Assert\GreaterThanOrEqual(value=300, message="Conference budget must be at least {{ compared_value }}")
     * @Assert\PositiveOrZero(message="Conference budget cannot be negative")
     */
    private $budget;

    /**
     * @var bool
     *
     * @ORM\Column(name="typeConf", type="boolean", nullable=false)
     */
    private $typeconf;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
 * @var \App\Entity\Emplacement
 *
 * @ORM\ManyToOne(targetEntity="Emplacement")
 * @ORM\JoinColumns({
 *   @ORM\JoinColumn(name="emplacement", referencedColumnName="id")
 * })
 */
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
