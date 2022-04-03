<?php

namespace App\Transformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Album;
use App\Entity\Photo;
use App\Model\ImageInput;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;

class ImageInputTransformer implements DataTransformerInterface {

    private EntityManagerInterface $entityManager;
    private FileService $fileService;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, FileService $fileService, ValidatorInterface $validator) {
        $this->entityManager = $entityManager;
        $this->fileService = $fileService;
        $this->validator = $validator;
    }

    /**
     * @param $object ImageInput
     * @param string $to
     * @param array $context
     * @return Photo
     * @throws \Exception
     */
    public function transform($object, string $to, array $context = []) {

        $this->validator->validate($object, $context);

        $photo = new Photo();

        $album = $this->entityManager
            ->getRepository(Album::class)
            ->find($object->getAlbumId());

        if ($album == null) {
            throw new \Exception("Cannot found album with id: " . $object->getAlbumId());
        }

        $photo->setAlbum($album);
        $photo->setCreatedAt(new \DateTimeImmutable());
        $photo->setDescription($object->getDescription());
        $photo->setName($object->getName());

        $photo->setPath($this->fileService->convertToFile($object->getImageContent()));

        return $photo;

    }

    public function supportsTransformation($data, string $to, array $context = []): bool {
        if ($data instanceof Photo) {
            return false;
        }

        return Photo::class === $to && null !== ($context['input']['class'] ?? null);
    }
}
