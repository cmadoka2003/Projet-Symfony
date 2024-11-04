<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnexionForm;
use App\Form\UserForm;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthentificationController extends AbstractController
{
    #[Route("/authentification", name:"authentification_app")]
    function authentification(Request $req, UserRepository $repo, UserPasswordHasherInterface $passwordHasher)
    {
        if($this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('profil_app');
        }

        $user = new User();

        $form = $this->createForm(UserForm::class, $user);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $verif = $repo->findOneBy(["email" => $user->getUserIdentifier()]);
            if($verif){
                return $this->render('pages/authentification.html.twig', ["form" => $form, "errorMessage" => "compte deja existant"]);
            }
            $passwordhash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($passwordhash);
            $repo->save($user, true);
            return $this->render('pages/authentification.html.twig', ["form" => $form, "validMessage" => "compte crée"]);
        }
        return $this->render('pages/authentification.html.twig', ["form" => $form]);
    }

    #[Route("/connexion", name:"connexion_app")]
    function connexion(Request $req, UserRepository $repo)
    {
        if($this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('profil_app');
        }
        $form = $this->createForm(ConnexionForm::class);
        $email = $req->request->get("email");

        $verif = $repo->findOneBy(["email" => $email]);
        if(!$verif){
            return $this->render('pages/connexion.html.twig', ["form" => $form->createView(), "errorMessage" => "une erreur est survenu"]);
        }
        return $this->render('pages/connexion.html.twig', ["form" => $form->createView()]);
    }

    #[Route("/deconnexion", name:"deconnexion_app")]
    function deconnexion(){}
}