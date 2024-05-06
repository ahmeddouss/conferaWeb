<?php

namespace App\Repository;

use App\Entity\Estimatedexpenses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Estimatedexpenses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estimatedexpenses|null findOneBy(array $criteria, array $orderBy = null)
 * @method aEstimatedexpenses[]    findAll()
 * @method Estimatedexpenses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstimatedexpensesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estimatedexpenses::class);
    }

    
}
