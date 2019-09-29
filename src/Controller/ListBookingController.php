<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\MaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */

class ListBookingController extends AbstractController
{
    /**
     * @Route("/list/booking", name="list_booking.index")
     */
    public function index(BookingRepository $repo, MaterielRepository $mat )
    {
        $bookings = $repo->findAll();
        return $this->render('list_booking/index.html.twig', [
            'bookings' => $bookings,
                    ]);
    }

    // route pour supprimer une annonce
    /**
     * @Route("/list/booking/delete/{id}", name="admin.booking.delete")
     */

    public function delete(int $id, EntityManagerInterface $entityManager, BookingRepository $bookingRepository):Response
    {
        //selectionner l'entité à supprimer
        $entity = $bookingRepository->find($id);

        // suppression : pas de persist, remove remplace persist
        $entityManager->remove($entity);
        $entityManager->flush();

        //message de confirmation de suppression
        $notification = "La réservation a été supprimé";

        //message flash
        $this->addFlash('notice', $notification);
        
        return $this->redirectToRoute('list_booking.index');
    }
}
