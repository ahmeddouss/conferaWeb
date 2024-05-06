<?php

namespace App\Repository;

use App\Entity\Emplacement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emplacement>
 *
 * @method Emplacement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emplacement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emplacement[]    findAll()
 * @method Emplacement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmplacementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emplacement::class);
    }
    public function searchAndSort(string $searchQuery = null, string $sortBy = 'gouvernourat', string $sortOrder = 'asc')
    {
        $qb = $this->createQueryBuilder('e');

        // Add search condition if search query is provided
        if ($searchQuery) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('e.gouvernourat', ':searchQuery'),
                $qb->expr()->like('e.ville', ':searchQuery'),
                $qb->expr()->like('e.label', ':searchQuery')
            ))
                ->setParameter('searchQuery', '%' . $searchQuery . '%');
        }

        // Sorting by specified field
        $qb->orderBy('e.' . $sortBy, $sortOrder);

        return $qb->getQuery()->getResult();
    }

    public function searchAndSortQuery($searchQuery, $sortBy, $sortOrder)
    {
        $queryBuilder = $this->createQueryBuilder('e');

        // Add search condition if search query is provided
        if ($searchQuery) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('e.gouvernourat', ':searchQuery'),
                $queryBuilder->expr()->like('e.ville', ':searchQuery'),
                $queryBuilder->expr()->like('e.label', ':searchQuery')
            ))
                ->setParameter('searchQuery', '%' . $searchQuery . '%');
        }

        // Add sorting condition
        $queryBuilder->orderBy('e.' . $sortBy, $sortOrder);

        return $queryBuilder->getQuery();
    }
    public function findEmplacementById(int $id): ?Emplacement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Emplacement[] Returns an array of Emplacement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Emplacement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}