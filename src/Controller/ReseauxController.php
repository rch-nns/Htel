<?php

namespace App\Controller;

use App\Repository\ReseauRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReseauxController extends AbstractController
{
    /**
     * @Route("/reseaux", name="reseaux.index")
     */
    public function index(ReseauRepository $reseauRepository):Response
    {
        $results = $reseauRepository->findAll();
        //dd($results);

        return $this->render('reseaux/index.html.twig', [
            'results' => $results
        ]);
    }
}
