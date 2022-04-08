<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Photo;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;

#[ApiResource]
#[Route(path: "/api/albums/{albumId}/photos", name: "get_album_photos_controller")]
class GetAlbumPhotosController extends AbstractController
{

    const DEFAULT_PAGE = 0;
    const DEFAULT_ITEMS = 10;

    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }


    public function __invoke(Request $request, $albumId)
    {

        $page = $request->query->get('page');
        $page = $page == null ? self::DEFAULT_PAGE : $page;

        $items = $request->query->get('items');
        $items = $items == null ? self::DEFAULT_ITEMS : $items;

        $offset = $page * $items;

        $photos = $this->entityManager
            ->getRepository(Photo::class)
            ->findBy(criteria: ['album' => $albumId], limit: $items, offset: $offset);


        return new JsonResponse($this->serializer->serialize($photos, JsonEncoder::FORMAT), Response::HTTP_OK, [], true);
    }
}