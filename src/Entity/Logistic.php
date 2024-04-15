<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Logistic
 *
 * @ORM\Table(name="logistic")
 * @ORM\Entity
 */
class Logistic
{
    /**
     * @var int
     *
     * @ORM\Column(name="logisticID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $logisticid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="providedLog", type="string", length=255, nullable=true)
     */
    private $providedlog;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;


}
