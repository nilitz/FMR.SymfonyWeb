<?php


namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Machine;
use App\Form\BookingType;
use App\Repository\MachineRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MachineController extends AbstractController
{
    /**
     * @var MachineRepository
     */
    private $machineRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var BookingRepository
     */
    private $bookingRepository;

    private $hour= 0;
    private $available = 1;
    private $booked = 0;

    /**
     * AdminMachineController constructor.
     * @param MachineRepository $machineRepository
     * @param EntityManagerInterface $entityManager
     * @param BookingRepository $bookingRepository
     */
    public function __construct(MachineRepository $machineRepository, EntityManagerInterface $entityManager, BookingRepository $bookingRepository)
    {

        $this->machineRepository = $machineRepository;
        $this->entityManager = $entityManager;
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * @Route("/machine", name="machine.index")
     * @return Response
     */
    public function index()
    {
        $machine = $this->machineRepository->findAll();
        return $this->render('machine/machine.html.twig', [
            'machines' => $machine
        ]);
    }

    /**
     * @Route("/machine/{id}", name="machines.show", methods="GET|POST")
     * @param Request $request
     * @param Machine $machine
     */
    public function show(Machine $machine, Request $request)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);


        $user = $this->get('security.token_storage')->getToken()->getUser();

        $totalMachineBooking = $this->bookingRepository->findAllByMachineId($machine->getId());


        if ($form->isSubmitted() && $form->isValid() && ($machine->getIsRentable())) {
            $booking
                ->setUser($user)
                ->setMachine($machine)
                ->setIsValidate(1)
                ->getMachine()->setIsRentable(1);
                $test = $this->getHour($booking);
                $hour = $this->getInterval($booking);
                $available = $this->getAvailable($booking);
                //$booked = $this->getOtherBooking($totalMachineBooking, $booking);
                if($test == 1 && $hour == 1 && $available == 1 /*&& $booked == 1*/){
                    $this->entityManager->persist($booking);
                    $this->entityManager->flush();
                    $this->addFlash('success', 'Reservation effectuée avec succès');
                    return $this->render('machine/show.html.twig', [
                        'id' => $machine->getId(),
                        'bookingTotal' => $this->getActualBooking($totalMachineBooking),
                        //'canOrder' => $machine->getIsRentable(),
                        'machine' => $machine,
                        'hour' => $hour,
                        'available' => $available,
                        //'booked' => $booked,
                        'form' => $form->createView()
                    ]);
                }
                else {
                    $this->addFlash('failure', 'Vous ne pouvez pas réserver dans le passé');
                    return $this->render('machine/show.html.twig', [
                        'id' => $machine->getId(),
                        'bookingTotal'=> $this->getActualBooking($totalMachineBooking),
                        //'canOrder' => $machine->getIsRentable(),
                        'machine' => $machine,
                        'hour' => $hour,
                        'available' => $available,
                        //'booked' => $booked,
                        'form' => $form->createView()

                    ]);
                }

        }

        return $this->render('machine/show.html.twig', [
            'id' => $machine->getId(),
            'bookingTotal'=> $this->getActualBooking($totalMachineBooking),
            'machine' => $machine,
            'form' => $form->createView(),
            'available' => $this->available,
            'hour' => $this->hour,
            //'booked' => $this->booked
        ]);

    }


        private function getActualBooking($array)
    {
        $count = 0;
        foreach ($array as $k)
        {
                $count = $count +1 ;
        }

        return $count;
    }

    /**
     * @param $book
     * @return array
     */
    private function getHour($book)
    {
        $actualDateTime = new \DateTime();
        if ($book->getStartAt() > $actualDateTime) {
            return 1;
        }
        else {
            return 0;
        }

    }

    /**
     * @param $book
     * @return array
     */
    private function getAvailable($book)
    {
        $begin = $book->getStartAt()->format('H');
        $begin = intval($begin);
        $end = $book->getEndAt()->format('H');
        $end = intval($end);


        if( $begin > 7 && $end < 19 && $end > $begin){
            return 1;
        }
        else {
            return 0;
        }

    }


    /**
     * @param $book
     * @return array
     */
    private function getInterval($book)
    {
        $begin = $book->getStartAt();
        $end = $book->getEndAt();

        $bDay = $book->getStartAt();
        $eDay = $book->getEndAt();

        $diff = $end->diff($begin);
        $diffDay = $eDay->diff($bDay)->format('%d');
        $diffMonth = $eDay->diff($bDay)->format('%M');
        $diffYear = $eDay->diff($bDay)->format('%Y');


        $hours = $diff->format('%h hours');

        if($hours < $book->getMachine()->getMaxHoursPerUse() && $diffDay == 0 && $diffMonth == 0 && $diffYear == 0){
            return 1;
        }
        else {
            return 0;
        }

    }

    /**
     * @param $book
     * @return array
     */
    private function getOtherBooking($array, $book)
    {
        $result = 0;
        $a = 0;

        foreach ($array as $k) {

            $begin = $k->getStartAt();
            $end = $k->getEndAt();
            $beginBooking = $book->getStartAt();
            $endBooking = $book->getEndAt();

            $endDayB = $endBooking->format('%d');
            $endMonthB = $endBooking->format('%M');
            $endYearB = $endBooking->format('%Y');
            $endHourB = $endBooking->format('H');

            $endDayB = intval($endDayB);
            $endMonthB = intval($endMonthB);
            $endYearB = intval($endYearB);
            $endHourB = intval($endHourB);


            $endDayA = $end->format('%d');
            $endMonthA = $end->format('%M');
            $endYearA = $end->format('%Y');
            $endHourA = $end->format('H');

            $endDayA = intval($endDayA);
            $endMonthA = intval($endMonthA);
            $endYearA = intval($endYearA);
            $endHourA = intval($endHourA);

            $beginDayB = $beginBooking->format('%d');
            $beginMonthB = $beginBooking->format('%M');
            $beginYearB = $beginBooking->format('%Y');
            $beginHourB = $beginBooking->format('H');

            $beginDayB = intval($beginDayB);
            $beginMonthB = intval($beginMonthB);
            $beginYearB = intval($beginYearB);
            $beginHourB = intval($beginHourB);

            $beginDayA = $begin->format('%d');
            $beginMonthA = $begin->format('%M');
            $beginYearA = $begin->format('%Y');
            $beginHourA = $begin->format('H');

            $beginDayA = intval($beginDayA);
            $beginMonthA = intval($beginMonthA);
            $beginYearA = intval($beginYearA);
            $beginHourA = intval($beginHourA);

            $diffDayEn = $endDayB - $beginDayA;
            $diffMonthEn = $endMonthB - $beginMonthA;
            $diffYearEn = $endYearB - $beginYearA;
            $diffHourEn = $beginHourA - $endHourB;

            $diffDayBe = $beginDayB - $endDayA;
            $diffMonthBe = $beginMonthB - $endMonthA;
            $diffYearBe = $beginYearB - $endYearA;
            $diffHourBe = $beginHourB - $endHourA;

            if( ($diffDayEn !== 0) || ($diffMonthEn !== 0) || ($diffYearEn !== 0) || ($diffDayEn == 0 && $diffHourBe > 0 && $diffMonthEn == 0 && $diffYearEn == 0 && $diffDayBe == 0 && $diffMonthBe == 0 && $diffYearBe == 0 && $diffHourEn < 0 ) || ($diffDayEn == 0 && $diffHourEn > 0 && $diffMonthEn == 0 && $diffYearEn == 0 && $diffDayBe == 0 && $diffMonthBe == 0 && $diffYearBe == 0 && $diffHourBe <0 )) {
               $result = $result+1;
               $a = $a+1;
            }
            else {
                $result = $result;
                $a = $a+1;
            }
        }
        if ($result == $a ){
            return 1;
        }
        else {
            return $result;
        }

    }

}