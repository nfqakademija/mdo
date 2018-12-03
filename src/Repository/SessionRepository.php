<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * @param $day
     * @return mixed
     * return times slot by date
     */
    public function findByDayField($day)
    {
        return $this->createQueryBuilder('s')
            ->select('s.startsAt')->distinct()
            ->andWhere('s.day = :val')
            ->setParameter('val', $day)
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @param $day
     * @return mixed
     */
    public function findFreeTimeSlotByDate($day)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.status = :val')
            ->andWhere('s.reservedAt = :day')
            ->setParameter('val', 'free')
            ->setParameter('day', $day)
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * @return mixed
     */
    public function init_calendar()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.status = :val')
            ->setParameter('val', 'free')
            ->getQuery()
            ->getResult()
            ;
    }

    public function checkSlotFree($date, $startTime, $endTime)
    {
        return $this->createQueryBuilder('s')
            ->select('s.id')
            ->andWhere('s.status = :val')
            ->andWhere('s.reservedAt = :day')
            ->andWhere('s.startsAt = :start')
            ->andWhere('s.endsAt = :end')
            ->setParameter('val', 'free')
            ->setParameter('day', $date)
            ->setParameter('start', $startTime)
            ->setParameter('end', $endTime)
            ->getQuery()
            ->getResult()
            ;
    }
}
