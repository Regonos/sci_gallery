<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    denormalizationContext: ['groups' => ['write']],
    formats: ["json"],
    normalizationContext: ['groups' => ['read']]
)]
#[ORM\Table(name: "gallery")]
#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery {
    #[ORM\Id]
    #[Groups("read")]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

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

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }
}
