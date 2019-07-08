<?php

namespace App\Controller;

use App\Repository\RecrutRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecrutController extends AbstractController
{
    /**
     * @Route("/recrut", name="recrut.index")
     */
    public function index(RecrutRepository $recrutRepository):Response
    {
        $results = $recrutRepository->findAll();
        //dd($results);
        return $this->render('recrut/index.html.twig', [
            'results' => $results
            
        ]);
    }
}