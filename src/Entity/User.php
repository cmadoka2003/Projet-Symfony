<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: "true")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(type:"text", nullable:true)]
    private ?string $description;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $avatar = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $emploi = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $phone = null;
    
    #[ORM\Column(length: 255, nullable:true)]
    private ?string $siteURL = null;

    #[ORM\OneToMany(targetEntity: Collection::class, mappedBy: 'user', cascade:['persist', "remove"])]
    private $collection;

    #[ORM\OneToMany(targetEntity: Commentaires::class, mappedBy: 'user', cascade:['persist', "remove"])]
    private $commentaires;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: "userLikes")]
    private $postLikes;

    public function __construct()
    {
        $this->collection = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $this->roles = ['ROLE_USER'];
        return $this->roles;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

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

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getEmploi()
    {
        return $this->emploi;
    }

    public function setEmploi($emploi)
    {
        $this->emploi = $emploi;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSiteURL()
    {
        return $this->siteURL;
    }

    public function setSiteURL($siteURL)
    {
        $this->siteURL = $siteURL;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function addCollection(Collection $collection)
    {
        $collection->setUser($this);
        $this->collection->add($collection);
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

    public function getPostLikes()
    {
        return $this->postLikes;
    }

    public function setPostLikes($postLikes)
    {
        $this->postLikes = $postLikes;

        return $this;
    }
}