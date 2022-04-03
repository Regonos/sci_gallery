<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    denormalizationContext: ['groups' => ['write']],
    formats: ["json"],
    normalizationContext: ['groups' => ['read']]
)]
#[ORM\Table(name: "album")]
#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album {
    #[ORM\Id]
    #[Groups("read")]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["read", "write"])]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Gallery::class, inversedBy: 'albums')]
    private $gallery;

    #[Groups(["read", "write"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    /**
     * @Groups("read")
     * @ORM\Column(name="created_at", type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    public function getId(): ?int {
        return $this->id;
    }

    public function getGallery(): ?Gallery {
        return $this->gallery;
    }

    public function setGallery(?Gallery $gallery): self {
        $this->gallery = $gallery;

        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }
}
