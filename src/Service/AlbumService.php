<?php

namespace App\Service;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;

class AlbumService
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $albumId
     * @param float|bool|int|string $items
     * @param float|int $offset
     * @return array|object[]
     */
    public function getPhotosInAlbum($albumId, float|bool|int|string $items, float|int $offset): array
    {
        return  $this->entityManager
            ->getRepository(Photo::class)
            ->findBy(criteria: ['album' => $albumId], limit: $items, offset: $offset);
    }
}
