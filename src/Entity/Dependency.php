<?php

namespace App\Entity; 

use Ramsey\Uuid\Uuid;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ApiResource(
 *      itemOperations = {
 *          "get",
 *          "put"={
 *              "denormalization_context" = {
 *                  "group"={"put:Dependency"}
 *              }
 *          }, 
 *          "delete"
 *      },
 *      collectionOperations = {
 *          "get",
 *          "post"
 *      },
 *      paginationEnabled = false
 * )
 */
class Dependency
{
    /**
     * @ApiProperty(
     *      identifier=true
     * )
     */
    private $uuid;

    /**
     * @ApiProperty(
     *      description="Nom de la dépendance"
     * )
     *@Length(min=2)
     *@NotBlank()
     */
    private $name;

    /**
     * @ApiProperty(
     *      description="version de la dépendance"
     * )
     * @NotBlank()
     * @Groups({"put:Dependency"})
     */
    private $version; 

    public function __construct(string $name, string $version)
    {
        $this->uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();
        $this->name = $name; 
        $this->version = $version; 
    }

    public function getUuid(): string
    {
        return $this->uuid; 
    }

    public function getName(): string
    {
        return $this->name; 
    }

    public function getVersion(): string
    {
        return $this->version; 
    }

    public function setVersion(string $version)
    {
        $this->version = $version; 
    }
}