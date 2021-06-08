<?php
namespace App\Controller;

use App\Entity\CorporateBondSecurity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{
    public function index(SerializerInterface $serializer): Response
    {
        $securities = $this->getDoctrine()
            ->getRepository(CorporateBondSecurity::class)
            ->findAllWithDateRange();

        // Make sure we don't load related securities of related imports
        return $this->json($serializer->serialize($securities, 'json'));
    }
}
