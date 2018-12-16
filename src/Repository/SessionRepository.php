<?php

namespace App\Repository;

use App\Entity\Session;
use App\Service\SessionFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PhpParser\Node\Expr\Array_;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    private $sessionFactory;
    public function __construct(RegistryInterface $registry, SessionFactory $sessionFactory)
    {
        parent::__construct($registry, Session::class);
        $this->sessionFactory = $sessionFactory;
    }

    public function findAllInMode(): array
    {
        return $this->createQueryBuilder('s')
            ->getQuery()
            ->getScalarResult();
    }

    /**
     * @param $year
     * @param SessionFactory $sessionFactory
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllByYear( $year ): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM session s
        WHERE DATE_FORMAT(s.reserved_at,"%Y") = "'.$year.'"
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $this->sessionFactory->formatSqlResult($stmt->fetchAll());
    }
}