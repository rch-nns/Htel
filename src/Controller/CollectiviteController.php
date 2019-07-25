<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CollectiviteController extends AbstractController
{
    /**
     * @Route("/collectivite", name="collectivite.index")
     */
    public function index()
    {
        return $this->render('collectivite/index.html.twig', [
            
        ]);
    }
}
