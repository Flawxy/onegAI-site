<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentationRepository")
 */
class Documentation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $command;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $syntax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shortcut;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $example;

    /**
     * @ORM\Column(type="boolean")
     */
    private $wip;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="documentation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function setCommand(string $command): self
    {
        $this->command = $command;

        return $this;
    }

    public function getSyntax(): ?string
    {
        return $this->syntax;
    }

    public function setSyntax(string $syntax): self
    {
        $this->syntax = $syntax;

        return $this;
    }

    public function getShortcut(): ?string
    {
        return $this->shortcut;
    }

    public function setShortcut(string $shortcut): self
    {
        $this->shortcut = $shortcut;

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

    public function getExample(): ?string
    {
        return $this->example;
    }

    public function setExample(string $example): self
    {
        $this->example = $example;

        return $this;
    }

    public function getWip(): ?bool
    {
        return $this->wip;
    }

    public function setWip(bool $wip): self
    {
        $this->wip = $wip;

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
}
