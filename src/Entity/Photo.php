<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\AddImageController;
use App\Model\ImageInput;
use App\Model\ImageOutput;
use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Table(name: "photo")]
#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ApiResource(
    formats: ["json"],
    input: ImageInput::class
)]
class Photo {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 1024, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 1024)]
    private $path;

    /**
     * @Groups("read")
     * @ORM\Column(name="created_at", type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Album::class, inversedBy: 'photos')]
    private $album;

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getPath(): ?string {
        return $this->path;
    }

    public function setPath(string $path): self {
        $this->path = $path;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAlbum(): ?Album {
        return $this->album;
    }

    public function setAlbum(?Album $album): self {
        $this->album = $album;

        return $this;
    }
}
