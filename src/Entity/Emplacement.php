<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Emplacement
 *
 * @ORM\Table(name="emplacement")
 * @ORM\Entity(repositoryClass=App\Repository\EmplacementRepository::class)
 */
class Emplacement
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
     * @var string|null
     *
     * @ORM\Column(name="gouvernourat", type="string", length=20, nullable=true)
     */
    private $gouvernourat;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Ville cannot be empty")
     * @Assert\Length(max=20, maxMessage="Ville cannot be longer than {{ limit }} characters")
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="capacite", type="integer", nullable=false)
     * @Assert\NotBlank(message="Capacite cannot be empty")
     * @Assert\Positive(message="Capacite should be a positive number")
     */
    private $capacite;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=20, nullable=false)
     * @Assert\NotBlank(message="Label cannot be empty")
     * @Assert\Length(max=20, maxMessage="Label cannot be longer than {{ limit }} characters")
     */
    private $label;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGouvernourat(): ?string
    {
        return $this->gouvernourat;
    }

    public function setGouvernourat(?string $gouvernourat): static
    {
        $this->gouvernourat = $gouvernourat;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
