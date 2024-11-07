<?php

namespace App\Controller;

use App\Form\ProfilForm;
use App\Repository\CollectionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilController extends AbstractController
{
    #[Route("/profil", name:"profil_app")]
    function profil(Request $req, CollectionRepository $repo, UserRepository $userRepo)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }
        $page = $req->query->get("page") ?? 0;

        $user = $userRepo->findByEmail($this->getUser());
        $collection = $repo->pagination($page, $user->getId());
        return $this->render('pages/profile/index.html.twig', ["collection" => $collection]);
    }

    #[Route("/profil/update", name:"app_modifier_informations")]
    function updateProfil(Request $req, UserRepository $repo, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads')] string $avatarDirectory)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $update = $repo->findOneBy(["email" => $this->getUser()->getUserIdentifier()]);

        if(!$update)
        {
            return $this->redirectToRoute('profil_app');
        }

        $form = $this->createForm(ProfilForm::class, $update);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $avatarfile = $form->get('avatar')->getData();
            
            if($avatarfile)
            {
                // Cette ligne permet extraire le lien de l'image sans l'extention
                $lienOriginel = pathinfo($avatarfile->getClientOriginalName(), PATHINFO_FILENAME);

                // Cette ligne permet de sécurisée le lien (en remplaçant les caractères spéciaux ex: é -> e, espace -> -)
                $lienSecurisee = $slugger->slug($lienOriginel);

                // Cette ligne permet de rendre le lien unique pour chaque utilisateur
                $nouveauLien = $lienSecurisee.'-'.uniqid().'.'.$avatarfile->guessExtension();

                // Ce bloc de code permet de pouvoir bouger le fichier télécharger vers un répertoire de stokage
                try {
                    $avatarfile->move($avatarDirectory, $nouveauLien);
                } catch (FileException $e) {}

                // Cette ligne permet de sauvegarder le lien dans la classe de l'utilisateur
                $update->setAvatar($nouveauLien);
            }

            $repo->save($update, true);
            $this->addFlash('compte-modifier','compte modifié avec success');
            return $this->redirectToRoute('profil_app');
        }
        return $this->render('pages/profile/update.html.twig', ["form" => $form]);
    }
}