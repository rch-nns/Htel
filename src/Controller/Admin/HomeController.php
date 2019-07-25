<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin")
 */

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="admin.home.index")
     */
    public function index():Response
    {
        return $this->render('admin/home/index.html.twig');
    }
}