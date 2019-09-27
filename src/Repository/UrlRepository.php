<?php

namespace App\Repository;

use App\Entity\Url;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Url|null find($id, $lockMode = null, $lockVersion = null)
 * @method Url|null findOneBy(array $criteria, array $orderBy = null)
 * @method Url[]    findAll()
 * @method Url[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Url::class);
    }

    public function getAll()
    {
        return $this->createQueryBuilder('qb')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAllBySessionId(string $sessionId)
    {
        return $this->createQueryBuilder('qb')
            ->where('qb.session_id = :sessionId')
            ->setParameter('sessionId', $sessionId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getOneByHash(string $hash)
    {
        return $this->createQueryBuilder('qb')
            ->where('qb.hash = :hash')
            ->setParameter('hash', $hash)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return Url[] Returns an array of Url objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Url
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
