<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participer
 *
 * @ORM\Table(name="participer")
 * @ORM\Entity
 */
class Participer
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
     * @var int
     *
     * @ORM\Column(name="idparticipant", type="integer", nullable=false)
     */
    private $idparticipant;

    /**
     * @var int
     *
     * @ORM\Column(name="idsession", type="integer", nullable=false)
     */
    private $idsession;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=false)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=200, nullable=false)
     */
    private $commentaire;


}
