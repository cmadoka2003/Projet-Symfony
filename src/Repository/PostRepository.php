<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $manager)
    {
        parent::__construct($manager, Post::class);
    }

    public function save(Post $nouvellepost, ?bool $isSave = false)
    {
        $this->getEntityManager()->persist($nouvellepost);

        if($isSave)
        {
            $this->getEntityManager()->flush();
        }

        return $nouvellepost;
    }

    public function delete(Post $post)
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();
    }
}