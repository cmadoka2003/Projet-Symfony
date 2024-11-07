<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Form\CollectionForm;
use App\Repository\CollectionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CollectionController extends AbstractController
{
    #[Route("/collection/ajouter", name:"app_ajouter_collection")]
    function collection(UserRepository $userRepo, Request $req, CollectionRepository $repo, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads')] string $avatarDirectory)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $user = $userRepo->findOneBy(["email" => $user = $this->getUser()->getUserIdentifier()]);

        $collection = new Collection();

        $form = $this->createForm(CollectionForm::class, $collection);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $coverfile = $form->get('cover')->getData();
            
            if($coverfile)
            {
                $lienOriginel = pathinfo($coverfile->getClientOriginalName(), PATHINFO_FILENAME);

                $lienSecurisee = $slugger->slug($lienOriginel);

                $nouveauLien = $lienSecurisee.'-'.uniqid().'.'.$coverfile->guessExtension();

                try {
                    $coverfile->move($avatarDirectory, $nouveauLien);
                } catch (FileException $e) {}

                $collection->setCover($nouveauLien);
            }

            // transforme la chaine de caractères en tableau
            $collection->setTags(str_getcsv($form->get('tags')->getData()));

            // met la date et l'heure au moment de la création de la collection
            $collection->setDate(date("Y-m-d H:i:s"));

            $user->addCollection($collection);

            $userRepo->save($user, true);
            $this->addFlash('collection-creation','collection crée avec success');
            return $this->redirectToRoute('profil_app');
        }

        return $this->render('pages/collection/ajouter.html.twig', ["form" => $form]);
    }

    #[Route("/collection/{id}/modifier", name:"app_modifier_collection")]
    function updatecollection($id, Request $req, CollectionRepository $repo, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads')] string $avatarDirectory)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $collection = $repo->find($id);

        if(!$collection)
        {
            return $this->redirectToRoute('profil_app');
        }

        $form = $this->createForm(CollectionForm::class, $collection);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $coverfile = $form->get('cover')->getData();
            
            if($coverfile)
            {
                $lienOriginel = pathinfo($coverfile->getClientOriginalName(), PATHINFO_FILENAME);

                $lienSecurisee = $slugger->slug($lienOriginel);

                $nouveauLien = $lienSecurisee.'-'.uniqid().'.'.$coverfile->guessExtension();

                try {
                    $coverfile->move($avatarDirectory, $nouveauLien);
                } catch (FileException $e) {}

                $collection->setCover($nouveauLien);
            }

            // transforme la chaine de caractères en tableau
            $collection->setTags(str_getcsv($form->get('tags')->getData()));

            // met la date et l'heure au moment de la création de la collection
            $collection->setDate(date("Y-m-d H:i:s"));

            $repo->save($collection, true);
            $this->addFlash('collection-modifier','collection modifiée avec success');
            return $this->redirectToRoute('app_detail_collection', ["id" => $id]);
        }

        return $this->render('pages/collection/modifier.html.twig', ["form" => $form]);
    }

    #[Route("/collection/{id}/supprimer", name:"app_supprimer_collection")]
    function deletecollection($id, CollectionRepository $repo)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $collection = $repo->find($id);

        if(!$collection)
        {
            return $this->redirectToRoute('profil_app');
        }

        $repo->delete($collection);
        $this->addFlash('collection-supprimer','collection supprimée avec success');
        return $this->redirectToRoute('profil_app');
    }

    #[Route("/collection/{id}", name:"app_detail_collection")]
    function showpost(CollectionRepository $repo, $id)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $collection = $repo->find($id);

        if(!$collection)
        {
            return $this->redirectToRoute('profil_app');
        }

        return $this->render('pages/collection/detail.html.twig', ["collection" => $collection]);
    }
}