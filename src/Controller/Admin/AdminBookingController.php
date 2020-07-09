<?php


namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Form\BookingEditType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminBookingController extends AbstractController
{
    /**
     * @var BookingRepository
     */
    private $bookingRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * AdminProductController constructor.
     * @param BookingRepository $bookingRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(BookingRepository $bookingRepository, EntityManagerInterface $entityManager)
    {

        $this->bookingRepository = $bookingRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/bookings", name="admin.bookings.index")
     * @return Response
     */
    public function index()
    {
        $booking = $this->bookingRepository->findAll();
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $booking
        ]);
    }

    /**
     * @Route("/admin/bookings/{id}", name="admin.bookings.edit", methods="GET|POST")
     * @param Booking $booking
     * @param Request $request
     */
    public function edit(Booking $booking, Request $request)
    {
        $bookingForm = $this->createForm(BookingEditType::class, $booking);
        $bookingForm->handleRequest($request);

        if ($bookingForm->isSubmitted() && $bookingForm->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Réservation édité avec succès');
            return $this->redirectToRoute('admin.bookings.edit', [
                'id' => $booking->getId()
            ]);
        }

        return $this->render('admin/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $bookingForm->createView()
        ]);
    }

    /**
     * @Route("/admin/bookings/{id}", name="admin.bookings.delete", methods="DELETE")
     * @param Booking $booking
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Booking $booking, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $booking->getId(), $request->get('_token')))
        {
            $this->entityManager->remove($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Réservation supprimé avec succès');
        }
        return $this->redirectToRoute('admin.bookings.index');
    }

    /**
     * @Route("/admin/booking/new", name="admin.bookings.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $booking = new Booking();
        $bookingForm = $this->createForm(BookingEditType::class, $booking);
        $bookingForm->handleRequest($request);

        if ($bookingForm->isSubmitted() && $bookingForm->isValid())
        {
            $this->entityManager->persist($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Booking crée avec succès');
            return $this->redirectToRoute('admin.bookings.index');
        }

        return $this->render('admin/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $bookingForm->createView()
        ]);
    }

    /**
     * @Route("admin/booking/show/{id}", name="booking.show")
     **/
    public function show(Booking $booking): Response
    {
        return $this->render('machine/machines.html.twig', [
            'booking' => $booking,
        ]);
    }

}