<?php

namespace App\Repository;

use App\Entity\Logisticincome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Logisticincome|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logisticincome|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logisticincome[]    findAll()
 * @method Logisticincome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogisticincomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logisticincome::class);
    }


}
