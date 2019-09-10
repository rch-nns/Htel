<?php

namespace App\Controller\Admin;

use App\Entity\Reseau;
use App\Form\ReseauType;
use App\Repository\ReseauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin")
 */

class ReseauController extends AbstractController
{
    //route pour lister tout les elements de la table(findAll)
    /**
     * @Route("/reseau", name="admin.reseau.index")
     */
    public function index(ReseauRepository $reseauRepository):Response
    {
        $reseau = $reseauRepository->findAll();

        return $this->render('admin/reseau/index.html.twig', ['reseau' => $reseau]);
    }

    //la première route : ajouter une annonce / la deuxième route : mettre à jour une annonce

    /**
     * @Route("/reseau/form", name="admin.reseau.form")
     * @Route("reseau/update/{id}", name="admin.reseau.update")
     */
    public function form(Request $request, EntityManagerInterface $entityManager, ReseauRepository $reseauRepository, int $id = null):Response
    {
        // création du formulaire
        //::class : renvoie le namespace de la class
        $type = ReseauType::class;


        //condition ternaire pour vérifier l'id. s'il est null on 'ajoute', si non on fait un 'update' 
        $entity = $id ? $reseauRepository->find($id) : new Reseau();


        $form = $this->createForm($type, $entity);

        // réscupération de la saisie $_POST
        $form -> handleRequest($request);

        // test si le formulaire est valide
        if($form-> isSubmitted() && $form->isValid())
        {
            //dd($entity);
            //persister la requète SQL
            $entityManager->persist($entity);

            //execution des requetes
            $entityManager->flush();

            //message de confirmation
            $notification = $id ? "l'annonce a été mise à jour" : "votre annonce a été ajouté";

            /**
             * message flash : information stockées dans la session et détruite après la lecture.
             * addFlash(clé, valeur) : créer une entré dans la session
             */
            $this->addFlash('notice', $notification);

            //créer une redirection vers une autre page aprés la validation du formulaire
            return $this->redirectToRoute('admin.reseau.index');

        }
        
        return $this->render('admin/reseau/form.html.twig', 
        [
            'form' => $form->createView()
        ]);
    }

    // route pour supprimer une annonce
    /**
     * @Route("/reseau/delete/{id}", name="admin.reseau.delete")
     */
    public function delete(int $id, EntityManagerInterface $entityManager, ReseauRepository $reseauRepository):Response
    {
        //selectionner l'entité à supprimer
        $entity = $reseauRepository->find($id);

        // suppression : pas de persist, remove remplace persist
        $entityManager->remove($entity);
        $entityManager->flush();

        //message de confirmation de suppression
        $notification = "L'annonce a été supprimé";

        //message flash
        $this->addFlash('notice', $notification);
        
        //
        return $this->redirectToRoute('admin.reseau.index');
    }
}