<?php

namespace App\Repository;

use App\Entity\Uidcard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\sessionEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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

    // Add this method to your UidcardRepository class

    public function findFreeCards(int $length = 8): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('LENGTH(u.uid) = :length')
            ->andWhere('u.status = :status')
            ->setParameter('length', $length)
            ->setParameter('status', 0)
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByUidWithMaxStatus(string $uid): ?Uidcard
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.uid = :uid')
            ->setParameter('uid', $uid)
            ->orderBy('u.status', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function getUniqueParticipantsBySession(int $idSession): array
    {
        return $this->createQueryBuilder('u')
            ->select('DISTINCT p.id')
            ->join('u.idparticipant', 'p')
            ->andWhere('u.idsession = :idSession')
            ->setParameter('idSession', $idSession)
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getOutUid(int $idParticipant): ?Uidcard
    {
        return $this->createQueryBuilder('u')
            ->andWhere('MOD(u.status, 2) = 1')
            ->andWhere('u.idparticipant = :idParticipant')
            ->setParameter('idParticipant', $idParticipant)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }


    public function getBySession(int $idSession): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.idsession = :idSession')
            ->setParameter('idSession', $idSession)
            ->getQuery()
            ->getResult();
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
