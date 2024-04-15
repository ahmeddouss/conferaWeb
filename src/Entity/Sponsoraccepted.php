<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sponsoraccepted
 *
 * @ORM\Table(name="sponsoraccepted", indexes={@ORM\Index(name="sponsoraccepted_ibfk_1", columns={"idSponsor"})})
 * @ORM\Entity
 */
class Sponsoraccepted
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
     * @var float
     *
     * @ORM\Column(name="budget", type="float", precision=10, scale=0, nullable=false)
     */
    private $budget;

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
