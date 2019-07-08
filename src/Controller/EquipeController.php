<?php

namespace App\Controller;

use App\Repository\EquipeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EquipeController extends AbstractController
{
    /**
     * @Route("/equipe", name="equipe.index")
     */
    public function index(EquipeRepository $equipeRepository):Response
    {
        $results = $equipeRepository->findAll();
        //dd($results);
        return $this->render('equipe/index.html.twig', [
            'results' => $results
            
        ]);
    }
}
