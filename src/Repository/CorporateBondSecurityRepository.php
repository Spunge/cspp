<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Entity\CorporateBondSecurity;

/**
 * @method CorporateBondSecurity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CorporateBondSecurity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CorporateBondSecurity[]    findAll()
 * @method CorporateBondSecurity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CorporateBondSecurityRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CorporateBondSecurity::class);
    }

    public function findAllWithDateRange(): Array {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c, MIN(i.date) AS from, MAX(i.date) AS to
            FROM App\Entity\CorporateBondSecurity c
            INNER JOIN c.imports i
            GROUP BY c.id'
        );

        return $query->getResult();

        /*
        return 
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
         */
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
