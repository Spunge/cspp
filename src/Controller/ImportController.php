<?php
namespace App\Controller;

use App\Entity\Import;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ImportController extends AbstractController
{
    public function index(SerializerInterface $serializer): Response
    {
        $imports = $this->getDoctrine()
            ->getRepository(Import::class)
            ->allWithSecurityCount();

        // Make sure we don't load related securities of related imports
        return $this->json($serializer->serialize($imports, 'json'));
    }

    public function detail(): Response {
        
    }
}
