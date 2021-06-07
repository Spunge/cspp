<?php

namespace App\Repository;

use App\Entity\CorporateBondSecurity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CorporateBondSecurity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CorporateBondSecurity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CorporateBondSecurity[]    findAll()
 * @method CorporateBondSecurity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CorporateBondSecurityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CorporateBondSecurity::class);
    }

    // /**
    //  * @return CorporateBondSecurity[] Returns an array of CorporateBondSecurity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CorporateBondSecurity
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
