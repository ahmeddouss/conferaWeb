<?php

namespace App\Repository;

use App\Entity\Logistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Logistic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logistic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logistic[]    findAll()
 * @method Logistic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogisticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logistic::class);
    }

    // Add your custom methods here
}
