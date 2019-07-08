<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact.index")
     */
    public function index(ContactRepository $contactRepository):Response
    {
        $results = $contactRepository->findAll();
        //dd($results);

        return $this->render('contact/index.html.twig', [
            'results' => $results
            
        ]);
    }
}
