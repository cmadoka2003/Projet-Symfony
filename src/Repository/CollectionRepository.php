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

        if ($isSave) {
            $this->getEntityManager()->flush();
        }

        return $nouvellecollection;
    }

    public function delete(Collection $collection)
    {
        $this->getEntityManager()->remove($collection);
        $this->getEntityManager()->flush();
    }

    public function pagination(int $pages = 0, int $id)
    {
        $pagination = $this->createQueryBuilder("c")
            ->where('c.user = :id')
            ->setParameter('id', $id)
            ->setMaxResults(10)
            ->setFirstResult(10 * $pages);

        $query = $pagination->getQuery();

        return $query->getResult();
    }

    public function paginationCountAll(int $id)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.user = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function showCollection(int $pages = 0)
    {
        $listCollection = $this->createQueryBuilder("c")
            ->where('c.isPublic = 1')
            ->setMaxResults(10)
            ->setFirstResult(10 * $pages)
            ->orderBy('c.date', 'DESC');

        $query = $listCollection->getQuery();

        return $query->getResult();
    }

    public function countAll()
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function rechercheQuery(string $recherche, int $pages = 0) 
    {
        $pagination = $this->createQueryBuilder("c")
            ->where('c.isPublic = 1')
            ->andWhere('c.titre = :recherche or c.description = :recherche or c.categorie = :recherche')
            ->setParameter('recherche', $recherche)
            ->setMaxResults(10)
            ->setFirstResult(10 * $pages)
            ->orderBy('c.date', 'DESC');

        $query = $pagination->getQuery();

        return $query->getResult();
    }

    public function rechercheQueryCountAll(string $recherche)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.titre = :recherche or c.description = :recherche or c.categorie = :recherche')
            ->setParameter('recherche', $recherche)
            ->orderBy('c.date', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function rechercheQueryProfile(string $recherche, int $pages = 0, int $id) 
    {
        $pagination = $this->createQueryBuilder("c")
            ->where('c.titre = :recherche or c.description = :recherche or c.categorie = :recherche')
            ->andWhere('c.user = :id')
            ->setParameter('id', $id)
            ->setParameter('recherche', $recherche)
            ->setMaxResults(10)
            ->setFirstResult(10 * $pages)
            ->orderBy('c.date', 'DESC');

        $query = $pagination->getQuery();

        return $query->getResult();
    }

    public function rechercheQueryProfileCountAll(string $recherche, int $id)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.titre = :recherche or c.description = :recherche or c.categorie = :recherche')
            ->andWhere('c.user = :id')
            ->setParameter('id', $id)
            ->setParameter('recherche', $recherche)
            ->orderBy('c.date', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function paginationWiewer(int $pages = 0, int $id)
    {
        $pagination = $this->createQueryBuilder("c")
            ->where('c.user = :id and c.isPublic = 1')
            ->setParameter('id', $id)
            ->setMaxResults(10)
            ->setFirstResult(10 * $pages);

        $query = $pagination->getQuery();

        return $query->getResult();
    }

    public function paginationWiewerCountAll(int $id)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.user = :id and c.isPublic = 1')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function rechercheQueryViewer(string $recherche, int $pages = 0, int $id) 
    {
        $pagination = $this->createQueryBuilder("c")
            ->where('c.titre = :recherche or c.description = :recherche or c.categorie = :recherche')
            ->andWhere('c.user = :id and c.isPublic = 1')
            ->setParameter('id', $id)
            ->setParameter('recherche', $recherche)
            ->setMaxResults(10)
            ->setFirstResult(10 * $pages)
            ->orderBy('c.date', 'DESC');

        $query = $pagination->getQuery();

        return $query->getResult();
    }

    public function rechercheQueryViewerCountAll(string $recherche, int $id)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.titre = :recherche or c.description = :recherche or c.categorie = :recherche')
            ->andWhere('c.user = :id and c.isPublic = 1')
            ->setParameter('id', $id)
            ->setParameter('recherche', $recherche)
            ->orderBy('c.date', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();
    }
}   
