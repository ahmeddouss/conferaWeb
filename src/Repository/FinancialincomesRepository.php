<?php

namespace App\Repository;

use App\Entity\Financialincomes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Financialincomes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Financialincomes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Financialincomes[]    findAll()
 * @method Financialincomes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinancialincomesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Financialincomes::class);
    }

    
}
