<?php

namespace App\Repository;

use App\Entity\Commentaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $manager)
    {
        parent::__construct($manager, Commentaires::class);
    }

    public function save(Commentaires $nouveaucommentaire, ?bool $isSave = false)
    {
        $this->getEntityManager()->persist($nouveaucommentaire);

        if($isSave)
        {
            $this->getEntityManager()->flush();
        }

        return $nouveaucommentaire;
    }

    public function delete(Commentaires $post)
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();
    }
}