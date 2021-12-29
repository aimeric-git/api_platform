<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Dependency;
use App\Repository\DependencyRepository;

class DependencyDataPersister implements DataPersisterInterface
{
    private $repository;
    public function __construct(DependencyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function supports($data): bool
    {
        return $data instanceof Dependency;
    }

    public function persist($data)
    {
        return $this->repository->persist($data);
    }

    public function remove($data)
    {
       return  $this->repository->remove($data);
    }
}