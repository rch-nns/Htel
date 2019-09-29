<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\AjoutOutilType;
use App\Repository\MaterielRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book.index")
     * @IsGranted("ROLE_USER")
     */
    public function index(MaterielRepository $repo)
    {
        $materiels = $repo->findAll();

        return $this->render('book/index.html.twig', [
            'materiels' => $materiels
        ]);
    }

    /**
     * Permet d'afficher un seul outil
     * 
     * @Route("/book/{nom}", name="book.show.index")
     */
    public function show($nom, Materiel $materiel)
    {
       // $materiel = $repo->findOneByNom($nom);

        return $this->render('book/show.html.twig', [
            'materiel' => $materiel
        ]);
    }
}
