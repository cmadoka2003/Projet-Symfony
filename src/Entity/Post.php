<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
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
    private ?string $image = null;

    #[ORM\ManyToOne(targetEntity: Collection::class, inversedBy: "posts")]
    private $collection;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: "postLikes")]
    private $userLikes;

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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
    
    public function getCollection()
    {
        return $this->collection;
    }

    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    public function getUserLikes()
    {
        return $this->userLikes;
    }

    public function setUserLikes($userLikes)
    {
        $this->userLikes = $userLikes;

        return $this;
    }
}
