<?php

namespace App\Controller\Admin;

use App\Entity\Recrut;
use App\Form\RecrutType;
use App\Repository\RecrutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin")
 */

class RecrutController extends AbstractController
{
    //route pour lister tout les elements de la table(findAll)
    /**
     * @Route("/recrut", name="admin.recrut.index")
     */
    public function index(RecrutRepository $recrutRepository):Response
    {
        $recrut = $recrutRepository->findAll();

        return $this->render('admin/recrut/index.html.twig', ['recrut' => $recrut]);
    }

    //la première route : ajouter une annonce / la deuxième route : mettre à jour une annonce

    /**
     * @Route("/recrut/form", name="admin.recrut.form")
     * @Route("recrut/update/{id}", name="admin.recrut.update")
     */
    public function form(Request $request, EntityManagerInterface $entityManager, RecrutRepository $recrutRepository, int $id = null):Response
    {
        // création du formulaire
        //::class : renvoie le namespace de la class
        $type = RecrutType::class;


        //condition ternaire pour vérifier l'id. s'il est null on 'ajoute', si non on fait un 'update' 
        $entity = $id ? $recrutRepository->find($id) : new Recrut();


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
            return $this->redirectToRoute('admin.recrut.index');

        }
        
        return $this->render('admin/recrut/form.html.twig', 
        [
            'form' => $form->createView()
        ]);
    }

    // route pour supprimer une annonce
    /**
     * @Route("/recrut/delete/{id}", name="admin.recrut.delete")
     */
    public function delete(int $id, EntityManagerInterface $entityManager, RecrutRepository $recrutRepository):Response
    {
        //selectionner l'entité à supprimer
        $entity = $recrutRepository->find($id);

        // suppression : pas de persist, remove remplace persist
        $entityManager->remove($entity);
        $entityManager->flush();

        //message de confirmation de suppression
        $notification = "L'annonce a été supprimé";

        //message flash
        $this->addFlash('notice', $notification);
        
        //
        return $this->redirectToRoute('admin.recrut.index');
    }
}