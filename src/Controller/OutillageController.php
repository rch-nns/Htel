<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\AjoutOutilType;
use App\Repository\MaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin")
 */

class OutillageController extends AbstractController
{
    /**
     * Permet d'afficher touts les outillages
     * 
     * @Route("/outillage", name="outillage.index")
     */
    public function index(MaterielRepository $materielRepository)
    {
        $materiels = $materielRepository->findAll();

        return $this->render('outillage/index.html.twig', [
            'materiels' => $materiels
        ]);
    }

    /**
     * Permet de créer un outil dans la base de donnée
     * 
     * @Route("/outillage/new", name="outillage.create.index")
     * @Route("outillage/update/{id}", name="outillage.update.index")
     * 
     * @return Response
     */
    public function form(Request $request, MaterielRepository $materielRepository , ObjectManager $manager, int $id = null):Response
    {
        //$materiel = new Materiel();
        $type = AjoutOutilType::class;

        //condition ternaire pour vérifier l'id. s'il est null on 'ajoute', si non on fait un 'update' 
        $entity = $id ? $materielRepository->find($id) : new Materiel();

        $form = $this->createForm(AjoutOutilType::class, $entity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($entity);
            $manager->flush();

            //message de confirmation
            $notification = $id ? "L'annonce {$entity->getNom()} a été mise à jour" : "Votre annonce {$entity->getNom()} a été ajouté";

            /**
            * message flash : information stockées dans la session et détruite après la lecture.
            * addFlash(clé, valeur) : créer une entré dans la session
            */
            $this->addFlash('notice', $notification);
            

            return $this->redirectToRoute('outillage.index');

        }

        return $this->render('outillage/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher un seul outil
     * 
     * @Route("/outillage/{nom}", name="outillage.show.index")
     */
    public function show($nom, Materiel $materiel)
    {
       // $materiel = $repo->findOneByNom($nom);

        return $this->render('outillage/show.html.twig', [
            'materiel' => $materiel
        ]);
    }

    // route pour supprimer une annonce
    /**
     * @Route("/materiel/delete/{id}", name="outillage.delete.index")
     */
    public function delete(int $id, EntityManagerInterface $entityManager, MaterielRepository $materielRepository):Response
    {
        //selectionner l'entité à supprimer
        $entity = $materielRepository->find($id);

        // suppression : pas de persist, remove remplace persist
        $entityManager->remove($entity);
        $entityManager->flush();

        //message de confirmation de suppression
        $notification = "L'annonce a été supprimé";

        //message flash
        $this->addFlash('notice', $notification);
        
        //
        return $this->redirectToRoute('outillage.index');
    }
}
