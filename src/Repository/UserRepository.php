<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $manager)
    {
        parent::__construct($manager, User::class);
    }

    public function save(User $nouveauUser, ?bool $isSave = false)
    {
        $this->getEntityManager()->persist($nouveauUser);

        if($isSave)
        {
            $this->getEntityManager()->flush();
        }

        return $nouveauUser;
    }
}