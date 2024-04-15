<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "username", type: "string", length: 15, nullable: false)]
    private $username;

    #[ORM\Column(name: "mail", type: "string", length: 30, nullable: false)]
    private $mail;

    #[ORM\Column(name: "password", type: "string", length: 20, nullable: false)]
    private $password;

    #[ORM\Column(name: "numtel", type: "integer", nullable: false)]
    private $numtel;

    #[ORM\Column(name: "nom", type: "string", length: 20, nullable: false)]
    private $nom;

    #[ORM\Column(name: "prenom", type: "string", length: 20, nullable: false)]
    private $prenom;

    #[ORM\Column(name: "profile_picture", type: "blob", nullable: true)]
    private $profilePicture;

    #[ORM\Column(name: "role", type: "string", length: 30, nullable: false)]
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function setProfilePicture($profilePicture): static
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
}
