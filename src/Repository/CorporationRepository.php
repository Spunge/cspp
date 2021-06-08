<?php

namespace App\Repository;

use App\Entity\Corporation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Corporation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Corporation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Corporation[]    findAll()
 * @method Corporation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CorporationRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Corporation::class);
    }

    public function allWithSecurityCount() {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c.name, c.slug, COUNT(cs.id) as securities
            FROM App\Entity\Corporation c
            JOIN c.corporateBondSecurities cs
            GROUP BY c.id
            ORDER BY securities DESC'
        );

        return $query->getResult();
    }
}
