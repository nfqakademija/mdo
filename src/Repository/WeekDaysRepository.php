<?php

namespace App\Repository;

use App\Entity\WeekDays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WeekDays|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeekDays|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeekDays[]    findAll()
 * @method WeekDays[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeekDaysRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WeekDays::class);
    }

    // /**
    //  * @return WeekDays[] Returns an array of WeekDays objects
    //  */
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    public function findDayId($value): ?WeekDays
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.day_name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
