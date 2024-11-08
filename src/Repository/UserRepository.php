<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

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

    function findByEmail(UserInterface $user)
    {
        return $this->findOneBy(["email" => $user->getUserIdentifier()]);
    }
}