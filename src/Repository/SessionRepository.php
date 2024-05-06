<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * @throws NonUniqueResultException
     */

    public function findCurrentSession(ConferenceRepository $conferenceRepository): ?Session
    {
        $idConference=$conferenceRepository->findOneConferenceForToday()->getId();
        $currentTime = new \DateTime();
        $currentTime->setTimezone(new \DateTimeZone('UTC')); // Set the timezone if needed

        return $this->createQueryBuilder('s')
            ->andWhere(':currentTime >= s.starttime')
            ->andWhere(':currentTime <= s.endtime')
            ->andWhere('s.idconference = :idConference')
            ->setParameter('currentTime', $currentTime->format('H:i:s'))
            ->setParameter('idConference', $idConference)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findById($idSession): ?Session
    {

        return $this->createQueryBuilder('s')
            ->andWhere(':id >= s.id')
            ->setParameter('id', $idSession)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    //    /**
    //     * @return Session[] Returns an array of Session objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
