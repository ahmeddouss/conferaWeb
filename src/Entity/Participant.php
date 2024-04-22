<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity
 */
class Participant
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=20, nullable=false)
     */
    private $cin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateN", type="date", nullable=true)
     */
    private $daten;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numTel", type="string", length=20, nullable=true)
     */
    private $numtel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;


}
