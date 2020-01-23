<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Documentation", mappedBy="category")
     */
    private $documentation;

    public function __construct()
    {
        $this->documentation = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Documentation[]
     */
    public function getDocumentation(): Collection
    {
        return $this->documentation;
    }

    public function addDocumentation(Documentation $documentation): self
    {
        if (!$this->documentation->contains($documentation)) {
            $this->documentation[] = $documentation;
            $documentation->setCategory($this);
        }

        return $this;
    }

    public function removeDocumentation(Documentation $documentation): self
    {
        if ($this->documentation->contains($documentation)) {
            $this->documentation->removeElement($documentation);
            // set the owning side to null (unless already changed)
            if ($documentation->getCategory() === $this) {
                $documentation->setCategory(null);
            }
        }

        return $this;
    }
}
