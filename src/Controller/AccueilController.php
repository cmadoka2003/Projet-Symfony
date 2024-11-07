<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route("/", name:"accueil_app")]
    function accueil(UserRepository $repo)
    {
        $user = $repo->findAll();
        return $this->render('pages/index.html.twig', ["users" => $user]);
    }

    #[Route("/show/profil/{id}", name:"profil_show_app")]
    function showprofil(UserRepository $repo, $id)
    {
        $user = $repo->find($id);
        $collection = $user->getCollection();
        return $this->render('pages/profile/profil.html.twig', ["user" => $user, "collection" => $collection]);
    }
}