<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use App\Controller\PostCountController;
use App\Controller\PostPublishController;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *      normalizationContext = {
 *          "groups" = {"read:collection"}
 *      }, 
 *      denormalizationContext = {
 *          "groups" = {"put:post"}
 *      },
 *      itemOperations = {
 *          "put", 
 *          "delete",
 *          "get" = {
 *              "normalization_context" = {
 *                  "groups" = {"read:collection", "read:item", "read:post"}
 *              }
 *          },
 *          "publish" = {
 *              "method" = "post",
 *              "path" = "posts/{id}/publish",
 *              "controller" = PostPublishController::class,
 *              "openapi_context" = {
 *                  "summary" = "permet de publier un article",
 *                  "requestBody" = {
 *                      "content" = {
 *                          "application/json" = {
 *                              "schema" = {}
 *                          }
 *                       }
 *                  }
 *              }
 *          }
 *      }, 
 *      collectionOperations = {
 *          "get", 
 *          "post",
 *          "count" = {
 *              "method" = "get",
 *              "path"= "posts/count",
 *              "controller"= PostCountController::class,
 *              "pagination_enabled" = false,
 *              "read"=false, 
 *              "openapi_context"= {
 *                  "summary"= "permet de récupérer le nombre de post",
 *                  "parameters"={
 *                      {
    *                      "in"="query",
    *                      "name"="online",
    *                      "schema"={
    *                          "type"="integer",
    *                          "maximum"= 1,
    *                          "minimum"=0
    *                      }
 *                      }
 *                  }
 *              }
 *           }
 *      }, 
 *      paginationItemsPerPage = 2
 * )
 * @ApiFilter(
 *      SearchFilter::class, properties={"id":"exact", "title":"partial"}
 * )
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection", "read:item", "put:post"})
     * @Length(min=4)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:collection", "put:post"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"put:post"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:item"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts", cascade={"persist"})
     * @Groups({"read:collection", "put:post"})
     * @Valid()
     */
    private $category;

    /**
     * @ORM\Column(type="boolean", options={"default": "0"})
     * @Groups({"read:collection"})
     */
    private $online = false;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }
}
