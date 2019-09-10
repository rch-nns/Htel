<?php

namespace App\Controller\Admin;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin")
 */

class EquipeController extends AbstractController
{
    //route pour lister tout les elements de la table(findAll)
    /**
     * @Route("/equipe", name="admin.equipe.index")
     */
    public function index(EquipeRepository $equipeRepository):Response
    {
        $equipe = $equipeRepository->findAll();

        return $this->render('admin/equipe/index.html.twig', ['equipe' => $equipe]);
    }

    //la première route : ajouter une annonce / la deuxième route : mettre à jour une annonce

    /**
     * @Route("/equipe/form", name="admin.equipe.form")
     * @Route("equipe/update/{id}", name="admin.equipe.update")
     */
    public function form(Request $request, EntityManagerInterface $entityManager, EquipeRepository $equipeRepository, int $id = null):Response
    {
        // création du formulaire
        //::class : renvoie le namespace de la class
        $type = EquipeType::class;


        //condition ternaire pour vérifier l'id. s'il est null on 'ajoute', si non on fait un 'update' 
        $entity = $id ? $equipeRepository->find($id) : new Equipe();


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
            $notification = $id ? ' votre annonce a été mise à jour' : 'votre annonce a été ajouté';

            /**
             * message flash : information stockées dans la session et détruite après la lecture.
             * addFlash(clé, valeur) : créer une entré dans la session
             */
            $this->addFlash('notice', $notification);

            //créer une redirection vers une autre page aprés la validation du formulaire
            return $this->redirectToRoute('admin.equipe.index');

        }
        
        return $this->render('admin/equipe/form.html.twig', 
        [
            'form' => $form->createView()
        ]);
    }

    // route pour supprimer une annonce
    /**
     * @Route("/equipe/delete/{id}", name="admin.equipe.delete")
     */
    public function delete(int $id, EntityManagerInterface $entityManager, EquipeRepository $equipeRepository):Response
    {
        //selectionner l'entité à supprimer
        $entity = $equipeRepository->find($id);

        // suppression : pas de persist, remove remplace persist
        $entityManager->remove($entity);
        $entityManager->flush();

        //message de confirmation de suppression
        $notification = "L'annonce a été supprimé";

        //message flash
        $this->addFlash('notice', $notification);
        
        //
        return $this->redirectToRoute('admin.equipe.index');
    }
}