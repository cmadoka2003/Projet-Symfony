<?php

namespace App\Controller;

use App\Repository\CollectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route("/", name:"accueil_app")]
    function accueil(CollectionRepository $collectionRepository, Request $req)
    {
        $page = $req->query->get("page") ?? 0;
        $recherche = $req->query->get("q") ?? null;

        if($recherche)
        {
            $collection = $collectionRepository->rechercheQuery($recherche, $page);
            $totalcollection = $collectionRepository->rechercheQueryCountAll($recherche);
            $totalPages = ceil($totalcollection / 10 - 1);
            return $this->render('pages/collection.html.twig', ["collection" => $collection, "total" => $totalPages, "recherche" => $recherche]);
        }

        $collection = $collectionRepository->showCollection($page);
        $totalcollection = $collectionRepository->countAll();
        $totalPages = ceil($totalcollection / 10 - 1);
        return $this->render('pages/collection.html.twig', ["collection" => $collection, "total" => $totalPages]);
    }
}