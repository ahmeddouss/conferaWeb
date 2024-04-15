<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Logisticincome
 *
 * @ORM\Table(name="logisticincome", indexes={@ORM\Index(name="logisticID", columns={"logisticID"})})
 * @ORM\Entity
 */
class Logisticincome
{
    /**
     * @var int
     *
     * @ORM\Column(name="logIncomeId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $logincomeid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="logSponsorName", type="string", length=255, nullable=true)
     */
    private $logsponsorname;

    /**
     * @var int|null
     *
     * @ORM\Column(name="logIncomeQty", type="integer", nullable=true)
     */
    private $logincomeqty;

    /**
     * @var string|null
     *
     * @ORM\Column(name="logProof", type="blob", length=0, nullable=true)
     */
    private $logproof;

    /**
     * @var \Logistic
     *
     * @ORM\ManyToOne(targetEntity="Logistic")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logisticID", referencedColumnName="logisticID")
     * })
     */
    private $logisticid;


}
