<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Import;

class ImportManager
{
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function create($date): Import
    {
        $import = new Import();
        $import->setDate($date);

        $this->entityManager->persist($import);
        $this->entityManager->flush();

        return $import;
    }
}
