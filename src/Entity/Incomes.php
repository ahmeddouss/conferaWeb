<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Incomes
 *
 * @ORM\Table(name="incomes")
 * @ORM\Entity
 */
class Incomes
{
    /**
     * @var int
     *
     * @ORM\Column(name="incomesId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $incomesid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fromWhat", type="string", length=255, nullable=true)
     */
    private $fromwhat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="incAmmount", type="integer", nullable=true)
     */
    private $incammount;


}
