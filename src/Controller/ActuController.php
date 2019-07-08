<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActuController extends AbstractController
{
    /**
     * @Route("/actu", name="actu.index")
     */
    public function index(ActuRepository $actuRepository):Response
    {
        $results = $actuRepository->findAll();
        //dd($results);

        return $this->render('actu/index.html.twig', [
            'results' => $results
            
        ]);
    }
}