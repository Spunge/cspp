<?php
namespace App\Controller;

use App\Entity\CorporateBondSecurity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security/{isin}", name="security_detail")
     */
    public function detail(string $isin, SerializerInterface $serializer): Response {
        $security = $this->getDoctrine()
            ->getRepository(CorporateBondSecurity::class)
            ->findOneBy([
                "isin" => $isin,
            ]);

        // Make sure we don't load related securities of related imports
        return $this->json($serializer->serialize($security, 'json', ['groups' => ['security']]));
    }
}
