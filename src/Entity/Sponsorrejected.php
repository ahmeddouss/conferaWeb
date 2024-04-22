<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sponsorrejected
 *
 * @ORM\Table(name="sponsorrejected", indexes={@ORM\Index(name="sponsorrejected_ibfk_1", columns={"idSponsor"})})
 * @ORM\Entity
 */
class Sponsorrejected
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
     * @ORM\Column(name="cause", type="string", length=20, nullable=false)
     */
    private $cause;

    /**
     * @var \Sponsor
     *
     * @ORM\ManyToOne(targetEntity="Sponsor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSponsor", referencedColumnName="id")
     * })
     */
    private $idsponsor;


}
