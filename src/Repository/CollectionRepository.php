<?php

namespace App\Repository;

use App\Entity\Collection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $manager)
    {
        parent::__construct($manager, Collection::class);
    }

    public function save(Collection $nouvellecollection, ?bool $isSave = false)
    {
        $this->getEntityManager()->persist($nouvellecollection);

        if($isSave)
        {
            $this->getEntityManager()->flush();
        }

        return $nouvellecollection;
    }

    public function delete(Collection $collection)
    {
        $this->getEntityManager()->remove($collection);
        $this->getEntityManager()->flush();
    }
}