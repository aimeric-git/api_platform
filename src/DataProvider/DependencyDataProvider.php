<?php

namespace App\DataProvider;

use Ramsey\Uuid\Uuid;
use App\Entity\Dependency;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Repository\DependencyRepository;

class DependencyDataProvider implements CollectionDataProviderInterface, 
    RestrictedDataProviderInterface, ItemDataProviderInterface
{

    private $repository;
    public function __construct(DependencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCollection(string $resourceClass, ?string $operationName = null)
    {
      return $this->repository->findAll();
       
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        return $resourceClass == Dependency::class;
    }

    public function getItem(string $resourceClass, $id, ?string $operationName = null, array $context = [])
    {
        return $this->repository->find($id); 
    }
}