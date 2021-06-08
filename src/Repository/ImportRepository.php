<?php

namespace App\Repository;

use App\Entity\Import;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Import|null find($id, $lockMode = null, $lockVersion = null)
 * @method Import|null findOneBy(array $criteria, array $orderBy = null)
 * @method Import[]    findAll()
 * @method Import[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Import::class);
    }

    public function allWithSecurityCount() {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT i.date, COUNT(c.id) as securities
            FROM App\Entity\Import i
            JOIN i.corporateBondSecurities c
            GROUP BY i.id'
        );

        return $query->getResult();
    }
}
