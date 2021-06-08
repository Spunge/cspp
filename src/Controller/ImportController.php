<?php
namespace App\Controller;

use DateTime;
use App\Entity\Import;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    /**
     * @Route("/import/", name="import_index")
     */
    public function index(SerializerInterface $serializer): Response
    {
        $imports = $this->getDoctrine()
            ->getRepository(Import::class)
            ->allWithSecurityCount();

        return $this->json($serializer->serialize($imports, 'json'));
    }

    /**
     * There's also converters for things like this
     * https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
     *
     * @Route("/import/{date}", name="import_detail")
     */
    public function detail(string $date, SerializerInterface $serializer): Response {
        $import = $this->getDoctrine()
            ->getRepository(Import::class)
            ->findOneBy([
                "date" => new DateTime($date),
            ]);

        // Make sure we don't load related imports of related imports
        return $this->json($serializer->serialize($import, 'json', ['groups' => ['import']]));
    }
}
