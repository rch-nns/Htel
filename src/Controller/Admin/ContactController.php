<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin")
 */

class ContactController extends AbstractController
{
    //route pour lister tout les elements de la table(findAll)
    /**
     * @Route("/contact", name="admin.contact.index")
     */
    public function index(ContactRepository $contactRepository):Response
    {
        $contact = $contactRepository->findAll();

        return $this->render('admin/contact/index.html.twig', ['contact' => $contact]);
    }

    //la première route : ajouter une annonce / la deuxième route : mettre à jour une annonce

    /**
     * @Route("/contact/form", name="admin.contact.form")
     * @Route("contact/update/{id}", name="admin.contact.update")
     */
    public function form(Request $request, EntityManagerInterface $entityManager, ContactRepository $contactRepository, int $id = null):Response
    {
        // création du formulaire
        //::class : renvoie le namespace de la class
        $type = ContactType::class;


        //condition ternaire pour vérifier l'id. s'il est null on 'ajoute', si non on fait un 'update' 
        $entity = $id ? $contactRepository->find($id) : new Contact();


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
            return $this->redirectToRoute('admin.contact.index');

        }
        
        return $this->render('admin/contact/form.html.twig', 
        [
            'form' => $form->createView()
        ]);
    }

    // route pour supprimer une annonce
    /**
     * @Route("/contact/delete/{id}", name="admin.contact.delete")
     */
    public function delete(int $id, EntityManagerInterface $entityManager, ContactRepository $contactRepository):Response
    {
        //selectionner l'entité à supprimer
        $entity = $contactRepository->find($id);

        // suppression : pas de persist, remove remplace persist
        $entityManager->remove($entity);
        $entityManager->flush();

        //message de confirmation de suppression
        $notification = "L'annonce a été supprimé";

        //message flash
        $this->addFlash('notice', $notification);
        
        //
        return $this->redirectToRoute('admin.contact.index');
    }
}