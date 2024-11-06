<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostForm;
use App\Repository\CollectionRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostController extends AbstractController
{
    #[Route("/collection/{id}/post/ajouter", name:"app_ajouter_post")]
    function post(CollectionRepository $collectionRepo, $id, Request $req, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads')] string $avatarDirectory)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $collection = $collectionRepo->find($id);

        $post = new Post();

        $form = $this->createForm(PostForm::class, $post);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $imagefile = $form->get('image')->getData();
            
            if($imagefile)
            {
                $lienOriginel = pathinfo($imagefile->getClientOriginalName(), PATHINFO_FILENAME);

                $lienSecurisee = $slugger->slug($lienOriginel);

                $nouveauLien = $lienSecurisee.'-'.uniqid().'.'.$imagefile->guessExtension();

                try {
                    $imagefile->move($avatarDirectory, $nouveauLien);
                } catch (FileException $e) {}

                $post->setImage($nouveauLien);
            }

            $post->setDate(date("Y-m-d H:i:s"));
            $collection->addPosts($post);
            $collectionRepo->save($collection, true);
            $this->addFlash('post-creation','post crée avec success');
            return $this->redirectToRoute('app_detail_collection', ["id" => $post->getCollection()->getId()]);
        }
        
        return $this->render('pages/collection/post/ajouter.html.twig', ["form" => $form]);
    }

    #[Route("/post/{id}/modifier", name:"app_modifier_post")]
    function modifpost(PostRepository $repo, $id, Request $req, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads')] string $avatarDirectory)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $post = $repo->find($id);

        $form = $this->createForm(PostForm::class, $post);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $imagefile = $form->get('image')->getData();
            
            if($imagefile)
            {
                $lienOriginel = pathinfo($imagefile->getClientOriginalName(), PATHINFO_FILENAME);

                $lienSecurisee = $slugger->slug($lienOriginel);

                $nouveauLien = $lienSecurisee.'-'.uniqid().'.'.$imagefile->guessExtension();

                try {
                    $imagefile->move($avatarDirectory, $nouveauLien);
                } catch (FileException $e) {}

                $post->setImage($nouveauLien);
            }
            
            $post->setDate(date("Y-m-d H:i:s"));
            $repo->save($post, true);
            $this->addFlash('post-modifier','Post modifié avec success');
            return $this->redirectToRoute('app_detail_collection', ["id" => $post->getCollection()->getId()]);
        }
        
        return $this->render('pages/collection/post/modifier.html.twig', ["form" => $form]);
    }

    #[Route("/post/{id}/supprimer", name:"app_supprimer_post")]
    function supppost(PostRepository $repo, $id)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $post = $repo->find($id);

        if(!$post)
        {
            return $this->redirectToRoute('profil_app');
        }

        $repo->delete($post);
        $this->addFlash('post-supprimer','Post supprimé avec success');
        return $this->redirectToRoute('app_detail_collection', ["id" => $post->getCollection()->getId()]);
    }
}