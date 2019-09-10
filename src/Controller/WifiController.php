<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WifiController extends AbstractController
{
    /**
     * @Route("/wifi", name="wifi.index")
     */
    public function index()
    {
        return $this->render('wifi/index.html.twig', [
            
        ]);
    }
}
