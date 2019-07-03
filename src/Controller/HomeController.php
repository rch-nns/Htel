<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {

    /**
     * @route("/", name="homepage")
     */
    public function home(){
        $prenoms = ["rachid" => 33, "nadia" => 30, "yacine" => 5, "manel" => 3.5];
        
        return $this->render(
            'home.html.twig',
            [
                'title' => "bonjour a tous les stagiaires !!!",
                'age' => 31,
                'tableau' => $prenoms

            ]
        );
    }
}



?>