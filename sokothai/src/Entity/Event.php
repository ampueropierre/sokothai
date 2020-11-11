<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @ApiResource(
 *     attributes={
            "order"={"createdAt":"ASC"},
 *     },
 *     normalizationContext={"groups"={"read:event"}},
 *     collectionOperations={
 *      "get",
 *      "post"={
 *          "security"="is_granted('IS_AUTHENTICATED_FULLY')",
            "controller"=App\Controller\Api\EventCreatorController::class
 *       }
 *      },
 *     itemOperations={
 *       "get",
 *       "put"={
            "security"="is_granted('IS_AUTHENTICATED_FULLY')",
 *       },
 *      "delete"={
            "security"="is_granted('IS_AUTHENTICATED_FULLY')",
 *       },
 *     }
 * )
 * @ApiFilter(BooleanFilter::class,
 *     properties={"isActived"})
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:event"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"read:event"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:event"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:event"})
     */
    private $url_facebook;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read:event"})
     */
    private $isActived = true;

    public function __construct() {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUrlFacebook(): ?string
    {
        return $this->url_facebook;
    }

    public function setUrlFacebook(?string $url_facebook): self
    {
        $this->url_facebook = $url_facebook;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsActived(): ?bool
    {
        return $this->isActived;
    }

    public function setIsActived(bool $isActived): self
    {
        $this->isActived = $isActived;

        return $this;
    }
}
