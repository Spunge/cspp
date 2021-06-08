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
}
