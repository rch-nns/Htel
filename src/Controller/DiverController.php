<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DiverController extends AbstractController
{
    /**
     * @Route("/diver", name="diver.index")
     */
    public function index()
    {
        return $this->render('diver/index.html.twig', [
            
        ]);
    }
}
