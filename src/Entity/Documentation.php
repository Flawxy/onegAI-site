<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentationRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"command"},
 *     message="Il existe déjà une commande portant ce nom !"
 * )
 *  * @UniqueEntity(
 *     fields={"syntax"},
 *     message="Il existe déjà une commande avec cette syntaxe !"
 * )
 *  * @UniqueEntity(
 *     fields={"shortcut"},
 *     message="Il existe déjà une commande avec ce raccourci !"
 * )
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
     * @Assert\Length(
     *     min=5,
     *     max=255,
     *     minMessage="Le nom de la commande doit faire au moins 5 caractères !",
     *     maxMessage="Le nom de la commande ne doit pas excéder 255 caractères !"
     * )
     */
    private $command;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="La syntaxe de la commande doit faire au moins 3 caractères !",
     *     maxMessage="La syntaxe de la commande ne doit pas excéder 255 caractères !"
     * )
     */
    private $syntax;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=2,
     *     max=255,
     *     minMessage="Le raccourci de la commande doit faire au moins 2 caractères !",
     *     maxMessage="Le raccourci de la commande ne doit pas excéder 255 caractères !"
     * )
     */
    private $shortcut;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=50,
     *     minMessage="La description de la commande doit faire au moins 50 caractères !"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=6,
     *     minMessage="L'exemple de la commande doit faire au moins 6 caractères !"
     * )
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

    /**
     * Permet d'initialiser la syntaxe.
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeSyntax()
    {
        if(strpos($this->syntax, 'o*') === false) {
            $command = 'o*';
            $syntax = $this->syntax;

            $this->syntax = $command . $syntax;
        }
    }

    /**
     * Permet d'initialiser le raccourci.
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeShortcut()
    {
        if(strpos($this->shortcut, 'o*') === false)
        {
            $command = 'o*';
            $shortcut = $this->shortcut;

            $this->shortcut = $command . $shortcut;
        }

    }

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
