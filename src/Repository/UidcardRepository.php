<?php

namespace App\Repository;

use App\Entity\Uidcard;
use Doctrine\Bundle\DoctrineBundle\Repository\sessionEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends sessionEntityRepository<Uidcard>
 *
 * @method Uidcard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Uidcard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Uidcard[]    findAll()
 * @method Uidcard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UidcardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Uidcard::class);
    }

    //    /**
    //     * @return Uidcard[] Returns an array of Uidcard objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Uidcard
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
