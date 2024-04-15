<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estimatedexpenses
 *
 * @ORM\Table(name="estimatedexpenses")
 * @ORM\Entity
 */
class Estimatedexpenses
{
    /**
     * @var int
     *
     * @ORM\Column(name="estimatedExpensesId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $estimatedexpensesid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ExpensesWay", type="string", length=255, nullable=true)
     */
    private $expensesway;

    /**
     * @var float|null
     *
     * @ORM\Column(name="pessimisticExpenses", type="float", precision=10, scale=0, nullable=true)
     */
    private $pessimisticexpenses;

    /**
     * @var float|null
     *
     * @ORM\Column(name="realisticExpenses", type="float", precision=10, scale=0, nullable=true)
     */
    private $realisticexpenses;

    /**
     * @var float|null
     *
     * @ORM\Column(name="optimisticExpenses", type="float", precision=10, scale=0, nullable=true)
     */
    private $optimisticexpenses;


}
