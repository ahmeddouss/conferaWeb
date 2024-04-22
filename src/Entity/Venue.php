<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venue
 *
 * @ORM\Table(name="venue")
 * @ORM\Entity
 */
class Venue
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
     * @ORM\Column(name="venueName", type="string", length=255, nullable=true)
     */
    private $venuename;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="output", type="text", length=65535, nullable=true)
     */
    private $output;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="Status", type="boolean", nullable=true)
     */
    private $status;


}
