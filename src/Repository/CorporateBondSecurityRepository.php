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

        // This will fetch "mixed" results, "c" being an entity, from&to being scalar
        $query = $entityManager->createQuery(
            'SELECT c.isin, MIN(i.date) AS from, MAX(i.date) AS to
            FROM App\Entity\CorporateBondSecurity c
            INNER JOIN c.imports i
            GROUP BY c.id'
        );

        // Passing Query::HYDRATE_SCALAR will merge these "mixed" results, 
        // but prefix fields from "c" with "c_", and will omit lazy loaded relations
        return $query->getResult();
    }
}
