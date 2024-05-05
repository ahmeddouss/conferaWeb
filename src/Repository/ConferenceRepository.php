<?php

namespace App\Repository;

use App\Entity\Conference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\sessionEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends sessionEntityRepository<Conference>
 *
 * @method Conference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conference[]    findAll()
 * @method Conference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    public function search(?string $query): array
    {
        if (!$query) {
            return $this->findAll(); // Return all conferences if no query is provided
        }
    
        return $this->createQueryBuilder('c')
            ->andWhere('c.nom LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }
    public function searchAndSort(string $searchQuery = null, string $sortBy = 'nom', string $sortOrder = 'asc')
    {
        $qb = $this->createQueryBuilder('c');
        
        if ($searchQuery) {
            $qb->andWhere('c.nom LIKE :searchQuery')
                ->setParameter('searchQuery', '%' . $searchQuery . '%');
        }

        // Sorting
        $qb->orderBy('c.' . $sortBy, $sortOrder);

        return $qb->getQuery()->getResult();
    }
    public function searchAndSortQuery($searchQuery, $sortBy, $sortOrder)
    {
        $queryBuilder = $this->createQueryBuilder('c');

        // Add search condition if search query is provided
        if ($searchQuery) {
            $queryBuilder->andWhere('c.nom LIKE :searchQuery')
                         ->setParameter('searchQuery', '%' . $searchQuery . '%');
        }

        // Add sorting condition
        $queryBuilder->orderBy('c.' . $sortBy, $sortOrder);

        return $queryBuilder->getQuery();
    }

    //    /**
    //     * @return Conference[] Returns an array of Conference objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Conference
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
