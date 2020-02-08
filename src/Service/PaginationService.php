<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class PaginationService {

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
        // 1) Connaître le total des enregistrements de la table
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());

        // 2) Faire la division, l'arrondir et la renvoyer
        return ceil($total / $this->limit);
    }

    public function getData()
    {
        // 1) Calculer l'offset
        $offset = $this->limit * ($this->currentPage - 1);

        // 2) Demander au repository de trouver les éléments
        $repo = $this->manager->getRepository($this->entityClass);

        // 3) Renvoyer les éléments en question
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