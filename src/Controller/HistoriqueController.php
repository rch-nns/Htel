<?php

namespace App\Controller;

use App\Repository\HistoriqueRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HistoriqueController extends AbstractController
{
    /**
     * @Route("/historique", name="historique.index")
     */
    public function index(HistoriqueRepository $historiqueRepository):Response
    {
        $results = $historiqueRepository->findAll();
        //dd($results);
        return $this->render('historique/index.html.twig', [
            'results' => $results
            
        ]);
    }
}