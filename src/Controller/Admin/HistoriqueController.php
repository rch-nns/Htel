<?php

namespace App\Controller\Admin;

use App\Entity\Historique;
use App\Form\HistoriqueType;
use App\Repository\HistoriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin")
 */

class HistoriqueController extends AbstractController
{
    //route pour lister tout les elements de la table(findAll)
    /**
     * @Route("/historique", name="admin.historique.index")
     */
    public function index(HistoriqueRepository $historiqueRepository):Response
    {
        $historique = $historiqueRepository->findAll();

        return $this->render('admin/historique/index.html.twig', ['historique' => $historique]);
    }

    //la première route : ajouter une annonce / la deuxième route : mettre à jour une annonce

    /**
     * @Route("/historique/form", name="admin.historique.form")
     * @Route("historique/update/{id}", name="admin.historique.update")
     */
    public function form(Request $request, EntityManagerInterface $entityManager, HistoriqueRepository $historiqueRepository, int $id = null):Response
    {
        // création du formulaire
        //::class : renvoie le namespace de la class
        $type = HistoriqueType::class;


        //condition ternaire pour vérifier l'id. s'il est null on 'ajoute', si non on fait un 'update' 
        $entity = $id ? $historiqueRepository->find($id) : new Historique();


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
            return $this->redirectToRoute('admin.historique.index');

        }
        
        return $this->render('admin/historique/form.html.twig', 
        [
            'form' => $form->createView()
        ]);
    }

    // route pour supprimer une annonce
    /**
     * @Route("/historique/delete/{id}", name="admin.historique.delete")
     */
    public function delete(int $id, EntityManagerInterface $entityManager, HistoriqueRepository $historiqueRepository):Response
    {
        //selectionner l'entité à supprimer
        $entity = $historiqueRepository->find($id);

        // suppression : pas de persist, remove remplace persist
        $entityManager->remove($entity);
        $entityManager->flush();

        //message de confirmation de suppression
        $notification = "L'annonce a été supprimé";

        //message flash
        $this->addFlash('notice', $notification);
        
        //
        return $this->redirectToRoute('admin.historique.index');
    }
}