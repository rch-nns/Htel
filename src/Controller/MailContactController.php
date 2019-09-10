<?php

namespace App\Controller;

use App\Entity\Mailcontact;
use App\Form\MailcontactType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MailContactController extends AbstractController
{
    /**
     * @Route("/mailcontact", name="mailcontact.index")
     */
    public function mailcontact(Request $request, ContactNotification $notification): Response
    {
        $contact = new MailContact();
        $form = $this->createForm(MailcontactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->addfash('success', 'votre email a bien été envoyé');
            return $this->redirectToRoute('contact.index');
        }

        return $this->render('mailcontact/mailcontact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
