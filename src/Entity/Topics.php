<?php

namespace App\Entity;

use App\Repository\TopicsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TopicsRepository::class)]
class Topics
{
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;
    #[Assert\Length(min:5,minMessage:" Ne contient pas 5 caractères." ,max: 20,maxMessage:"Dépasse 20 caractères." )]
    #[Assert\NotBlank(message: "Topics Name is Blank")]
    #[ORM\Column(name: "topicName", type: "string", length: 30, nullable: false)]
    private $topicname;
    #[Assert\Length(min:5,minMessage:" Ne contient pas 5 caractères." ,max: 20,maxMessage:"Dépasse 20 caractères." )]
    #[Assert\NotBlank(message: "Speaker Name is Blank")]
    #[ORM\Column(name: "speakerName", type: "string", length: 30, nullable: false)]
    private $speakername;
    #[Assert\Length(min:10,minMessage:" Minimum 10 caractères."  )]
    #[Assert\NotBlank(message: "Topic Description is Blank")]
    #[ORM\Column(name: "topicDescription", type: "string", length: 300, nullable: false)]
    private $topicdescription;

    #[ORM\ManyToOne(targetEntity: "Session")]
    #[ORM\JoinColumn(name: "idSession", referencedColumnName: "id")]
    private $idsession;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopicname(): ?string
    {
        return $this->topicname;
    }

    public function setTopicname(string $topicname): static
    {
        $this->topicname = $topicname;

        return $this;
    }

    public function getSpeakername(): ?string
    {
        return $this->speakername;
    }

    public function setSpeakername(string $speakername): static
    {
        $this->speakername = $speakername;

        return $this;
    }

    public function getTopicdescription(): ?string
    {
        return $this->topicdescription;
    }

    public function setTopicdescription(string $topicdescription): static
    {
        $this->topicdescription = $topicdescription;

        return $this;
    }

    public function getIdsession(): ?Session
    {
        return $this->idsession;
    }

    public function setIdsession(?Session $idsession): static
    {
        $this->idsession = $idsession;

        return $this;
    }
}
