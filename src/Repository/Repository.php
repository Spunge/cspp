<?php

namespace App\Repository;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class Repository extends ServiceEntityRepository
{
    /**
     * Find a entity by values, or create a new one.
     */
    public function findOneOrCreate(array $values) {

        $entity = $this->findOneBy($values);

        if( ! $entity) {
            $entity = new $this->_entityName;

            // Use property accessor to set properties on newly created entity
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            foreach($values as $property => $value) {
                $propertyAccessor->setValue($entity, $property, $value);
            }

            $this->_em->persist($entity);
            $this->_em->flush();
        }

        return $entity;
    }
}
