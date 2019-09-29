<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Materiel;
use App\Form\BookingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BookingController extends AbstractController
{
    /**
     * @Route("/book/{nom}/booking", name="booking")
     */
    public function book(Materiel $materiel, Request $request, ObjectManager $manager)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $booking->setBooker($user)
                    ->addMateriel($materiel);

            $manager->persist($booking);
            $manager->flush();

        //message de confirmation de suppression
        $notification = "Votre réservation a bien été enregistré, n'oubliez pas de vous déconnecter";

        //message flash
        $this->addFlash('notice', $notification);

            return $this->redirectToRoute('book.index', ['id' => $booking->getId()]);
        }

        return $this->render('booking/index.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView()
        ]);
    }

    /**
     * Afficher une résérvation
     * 
     * @route("/booking/{id}", name="booking-success")
     * 
     * @param Booking $booking
     * @return Response
     */
    public function success(Booking $booking, User $user) {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
            'user' => $user
        ]);
    }
}
