<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"title"},
 *     message="Ce titre est déjà utilisé par un autre article !"
 * )
 * @UniqueEntity(
 *     fields={"slug"},
 *     message="Ce slug est déjà utilisé par un autre article !"
 * )
 */
class Post
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
     *     min=10,
     *     max=255,
     *     minMessage="le titre de l'article doit faire au moins 10 caractères !",
     *     maxMessage="Le titre de l'article ne peut pas excéder 255 caractères !"
     * )
     * @Assert\NotBlank(
     *     normalizer="trim",
     *     message="Vous devez renseigner ce champ"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=100,
     *     minMessage="le contenu de l'article doit faire au moins 100 caractères !",
     * )
     * @Assert\NotBlank(
     *     normalizer="trim",
     *     message="Vous devez renseigner ce champ"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(
     *     message="L'url {{ value }} fourni ne semble pas être une adresse valide"
     * )
     * @Assert\NotBlank(
     *     normalizer="trim",
     *     message="Vous devez renseigner ce champ"
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min=20,
     *     minMessage="L'introduction de l'article doit faire au moins 20 caractères !"
     * )
     * @Assert\NotBlank(
     *     normalizer="trim",
     *     message="Vous devez renseigner ce champ"
     * )
     */
    private $introduction;


    /**
     * Initializes the slug in the appropriate format
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeSlug()
    {
        if(empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
    }

    /**
     * Initializes the creation date of a post
     *
     * @ORM\PrePersist()
     */
    public function initializeCreatedAt()
    {
        if(empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }
}
