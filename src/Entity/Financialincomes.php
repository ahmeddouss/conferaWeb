<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Financialincomes
 *
 * @ORM\Table(name="financialincomes")
 * @ORM\Entity
 */
class Financialincomes
{
    /**
     * @var int
     *
     * @ORM\Column(name="financialIncomesId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $financialincomesid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sponsorName", type="string", length=255, nullable=true)
     */
    private $sponsorname;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cashIn", type="integer", nullable=true)
     */
    private $cashin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="proof", type="blob", length=0, nullable=true)
     */
    private $proof;


}
