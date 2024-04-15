<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expenses
 *
 * @ORM\Table(name="expenses")
 * @ORM\Entity
 */
class Expenses
{
    /**
     * @var int
     *
     * @ORM\Column(name="expensesId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $expensesid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="onWhat", type="string", length=255, nullable=true)
     */
    private $onwhat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="expAmmount", type="integer", nullable=true)
     */
    private $expammount;


}
