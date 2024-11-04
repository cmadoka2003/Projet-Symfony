<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route("/profil", name:"profil_app")]
    function profil()
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }
        return $this->render('pages/profile/index.html.twig');
    }
}