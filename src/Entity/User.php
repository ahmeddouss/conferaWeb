<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "Please enter an email address.")]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    private ?string $email = null;

    #[ORM\Column(name: "username", type: "string", length: 15, nullable: false)]
    private $username;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: "Please enter a password.")]
    #[Assert\Length(min: 6, minMessage: "Your password must be at least {{ limit }} characters long.")]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Za-z])(?=.*\d).+$/",
        message: "Your password must contain at least one letter and one digit."
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter a name.")]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: "Name should be at least {{ limit }} characters.",
        maxMessage: "Name should be at most {{ limit }} characters."
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter a last name.")]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: "Last name should be at least {{ limit }} characters.",
        maxMessage: "Last name should be at most {{ limit }} characters."
    )]
    private ?string $prenom = null;

    #[ORM\Column(name: "numtel", type: "integer", nullable: false)]
    #[Assert\NotBlank(message: "Please enter a phone number.")]
    #[Assert\Type(
        type: 'string',
        message: 'Phone number must be a valid integer.',
    )]
    #[Assert\Regex(
        pattern: "/^[0-9]*$/",
        message: "Phone number must contain only digits."
    )]
    #[Assert\Length(
        min: 8,
        max: 15,
        minMessage: "Phone number should be at least {{ limit }} digits.",
        maxMessage: "Phone number should be at most {{ limit }} digits."
    )]
    private $numtel;


    #[ORM\Column(name: "role", type: "string", length: 30, nullable: false)]
    private $role;

    /**
     * @return mixed
     */
    public function getNumtel()
    {
        return $this->numtel;
    }

    /**
     * @param mixed $numtel
     */
    public function setNumtel($numtel): void
    {
        $this->numtel = $numtel;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see Passw  ordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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




}
