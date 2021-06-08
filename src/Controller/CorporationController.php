<?php
namespace App\Controller;

use App\Entity\Corporation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class CorporationController extends AbstractController
{
    /**
     * @Route("/corporation/", name="corporation_index")
     */
    public function index(SerializerInterface $serializer): Response
    {
        $corporations = $this->getDoctrine()
            ->getRepository(Corporation::class)
            ->allWithSecurityCount();

        return $this->json($serializer->serialize($corporations, 'json'));
    }

    /**
     * @Route("/corporation/{slug}", name="corporation_detail")
     */
    public function detail(string $slug, SerializerInterface $serializer): Response {
        $corporation = $this->getDoctrine()
            ->getRepository(Corporation::class)
            ->findOneBy([
                "slug" => $slug
            ]);

        // Make sure we don't load related imports of related imports
        return $this->json($serializer->serialize($corporation, 'json', ['groups' => ['corporation']]));
    }
}
