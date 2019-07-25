<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client.index")
     */
    public function index()
    {
        return $this->render('client/index.html.twig', [
            
        ]);
    }
}
