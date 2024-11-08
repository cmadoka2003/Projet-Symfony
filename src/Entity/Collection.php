<?php

namespace App\Entity;

use App\Repository\CollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollectionRepository::class)]
class Collection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "string")]
    private ?string $titre = null;

    #[ORM\Column(type: "string")]
    private ?string $description = null;

    #[ORM\Column(type: "boolean")]
    private ?bool $isPublic = false;

    #[ORM\Column(type: "string")]
    private ?string $date = null;

    #[ORM\Column(type: "string", nullable: true)]
    private ?string $cover = null;

    #[ORM\Column]
    private ?array $tags = [];

    #[ORM\Column(type: "string")]
    private ?string $categorie = null;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'collection', cascade:['persist', "remove"])]
    private $posts;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "collection")]
    private $user;

    #[ORM\OneToMany(targetEntity: Commentaires::class, mappedBy: 'collection', cascade:['persist', "remove"])]
    private $commentaires;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getIsPublic()
    {
        return $this->isPublic;
    }

    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getCover()
    {
        return $this->cover;
    }

    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    public function getTags()
    {
        return implode(", ", $this->tags);
    }

    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function addPosts(Post $posts)
    {
        $posts->setCollection($this);
        $this->posts->add($posts);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getCommentaires()
    {
        return $this->commentaires;
    }

    public function addCommentaires(Commentaires $commentaires)
    {
        $commentaires->setUser($this);
        $this->commentaires->add($commentaires);
    }
}
