<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TelephonieController extends AbstractController
{
    /**
     * @Route("/telephonie", name="telephonie.index")
     */
    public function index()
    {
        return $this->render('telephonie/index.html.twig', [
            
        ]);
    }
}
