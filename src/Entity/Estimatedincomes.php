<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estimatedincomes
 *
 * @ORM\Table(name="estimatedincomes")
 * @ORM\Entity
 */
class Estimatedincomes
{
    /**
     * @var int
     *
     * @ORM\Column(name="estimatedIncomesId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $estimatedincomesid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="incomeSource", type="string", length=255, nullable=true)
     */
    private $incomesource;

    /**
     * @var float|null
     *
     * @ORM\Column(name="pessimisticIncome", type="float", precision=10, scale=0, nullable=true)
     */
    private $pessimisticincome;

    /**
     * @var float|null
     *
     * @ORM\Column(name="realisticIncome", type="float", precision=10, scale=0, nullable=true)
     */
    private $realisticincome;

    /**
     * @var float|null
     *
     * @ORM\Column(name="optimisticIncome", type="float", precision=10, scale=0, nullable=true)
     */
    private $optimisticincome;


}
