<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Machine;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
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
     * AdminBookingController constructor.
     * @param BookingRepository $bookingRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(BookingRepository $bookingRepository, EntityManagerInterface $entityManager)
    {
        date_default_timezone_set('Europe/Paris');
        $this->bookingRepository = $bookingRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/calendar", name="booking.calendar")
     */
    public function index(): Response
    {
        $booking = $this->bookingRepository->findAll();
        return $this->render('machine/machine.html.twig', [
            'bookings' => $booking
        ]);
    }

    /**
     * @Route("/new", name="booking.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $booking = new Booking();
        $bookingForm = $this->createForm(BookingType::class, $booking);
        $bookingForm->handleRequest($request);

        if ($bookingForm->isSubmitted() && $bookingForm->isValid())
        {
            $this->entityManager->persist($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Reservation crée avec succès');
            return $this->redirectToRoute('booking.new');
        }

        return $this->render('machine/machineRent.html.twig', [
            'booking' => $booking,
            'form' => $bookingForm->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="bookingShow")
     * @param Booking $booking
     * @param Machine $machine
     * @return Response
     **/
    public function show(Booking $booking, Machine $machine): Response
    {

        return $this->render('machine/show.html.twig', [
            'booking' => $booking,
            'machine' => $machine
        ]);
    }
}