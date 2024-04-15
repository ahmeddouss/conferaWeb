<?php

namespace App\Repository;

use App\Entity\Estimatedincomes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Estimatedincomes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estimatedincomes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estimatedincomes[]    findAll()
 * @method Estimatedincomes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstimatedincomesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estimatedincomes::class);
    }

    // Add your custom methods here
}
