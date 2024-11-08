<?php

namespace App\Controller;


use App\Entity\Commentaires;
use App\Repository\CollectionRepository;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    #[Route("/collection/commentaire/{id}", name:"app_ajout_commentaire")]
    function commentaire(UserRepository $userRepo, CollectionRepository $Collectionrepo, $id, Request $req, CommentaireRepository $commentaireRepo)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $collection = $Collectionrepo->find($id);
        $user = $userRepo->findOneBy(["email" => $this->getUser()->getUserIdentifier()]);

        if(!$collection)
        {
            return $this->redirectToRoute('profil_app');
        }

        $contenu = $req->request->get('contenu');

        $commentaire = new Commentaires();

        $commentaire->setContenu($contenu);
        $commentaire->setDate(date("Y-m-d H:i:s"));
        $commentaire->setCollection($collection);

        $user->addCommentaires($commentaire);

        $userRepo->save($user, true);

        return $this->redirectToRoute('app_detail_collection', ['id' => $id]);
    }

    #[Route("/commentaire/{id}/supprimer", name:"app_supprimer_commentaire")]
    function supprimercommentaire($id, CommentaireRepository $commentaireRepo)
    {
        if(!$this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('connexion_app');
        }

        $commentaire = $commentaireRepo->find($id);

        if(!$commentaire)
        {
            return $this->redirectToRoute('profil_app');
        }

        $commentaireRepo->delete($commentaire);
        $this->addFlash('post-supprimer','Commentaire supprimé avec success');
        return $this->redirectToRoute('app_detail_collection', ["id" => $commentaire->getCollection()->getId()]);
    }
}