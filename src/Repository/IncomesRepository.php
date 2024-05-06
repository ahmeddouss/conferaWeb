<?php

namespace App\Repository;

use App\Entity\Incomes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Incomes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incomes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incomes[]    findAll()
 * @method Incomes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncomesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Incomes::class);
    }

    // Add your custom methods here
}
