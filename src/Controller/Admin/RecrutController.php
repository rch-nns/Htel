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
    /**
     * @Route("/recrut", name="admin.recrut.index")
     */
    public function index(RecrutRepository $recrutRepository):Response
    {
        $recrut = $recrutRepository->findAll();

        return $this->render('admin/recrut/index.html.twig', ['recrut' => $recrut]);
    }

    /**
     * @route("/recrut/form", name="admin.recrut.form")
     */
    public function form(Request $request, EntityManagerInterface $entityManager):Response
    {
        // création du formulaire
        //::class : renvoie le namespace de la class
        $type = RecrutType::class;
        $entity = new Recrut();


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
            $notification = 'votre annonce a été ajouté';

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
}