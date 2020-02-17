<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class PaginationService
{

    private $entityClass;
    private $limit = 6;
    private $currentPage = 1;
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getPages()
    {
        // Retrieves the amount of entries in the DB
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());

        // Divides, rounds and returns
        return ceil($total / $this->limit);
    }

    public function getData()
    {
        // Calculates the offset
        $offset = $this->limit * ($this->currentPage - 1);

        // Finds the correct repository
        $repo = $this->manager->getRepository($this->entityClass);

        // Returns the sorted data
        return $repo->findBy([], ['createdAt' => 'DESC'], $this->limit, $offset);
    }

    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass()
    {
        return $this->entityClass;
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setCurrentPage(int $currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

}