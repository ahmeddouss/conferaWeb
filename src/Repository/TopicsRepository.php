<?php

namespace App\Repository;

use App\Entity\Topics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\sessionEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends sessionEntityRepository<Topics>
 *
 * @method Topics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topics[]    findAll()
 * @method Topics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topics::class);
    }

    public function findBySessionId(int $sessionId): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :sessionId')
            ->setParameter('sessionId', $sessionId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Topics[] Returns an array of Topics objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.idsession = :val')
            ->setParameter('val', $value)

            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySession($session): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.idsession = :val.id')
            ->setParameter('val', $session)

            ->getQuery()
            ->getResult()
            ;
    }

    //    public function findOneBySomeField($value): ?Topics
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
