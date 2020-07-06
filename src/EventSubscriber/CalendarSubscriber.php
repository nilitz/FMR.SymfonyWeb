<?php

namespace App\EventSubscriber;

use CalendarBundle\Entity\Event;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Event\CalendarEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BookingRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $bookingRepository;
    private $router;
    private $em;

    public function __construct(
        BookingRepository $bookingRepository,
        UrlGeneratorInterface $router,
        EntityManagerInterface $em
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->router = $router;
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $bookings = $this->bookingRepository
            ->createQueryBuilder('booking')
            ->where('booking.beginAt BETWEEN :start and :end OR booking.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($bookings as $booking) {
            $bookingEvent = new Event(
                $booking->getMachine()->getName(),
                $booking->getTitle(),
                $booking->getBeginAt(),
                $booking->getEndAt()
            );
            if (!is_null($booking->getMachine()->getColor())) {
                $pickedColor = $booking->getMachine()->getColor();
            }
            else {
                $pickedColor = $this->colorPicker();
                $booking->getMachine()->setColor($pickedColor);
                $this->em->flush();
            }

            $bookingEvent->setOptions([
                'backgroundColor' => $pickedColor,
                'borderColor' => $pickedColor,
            ]);
            $bookingEvent->addOption(
                'url',
                $this->router->generate('ReservationsShow', [
                    'id' => $booking->getId(),
                ])
            );

            $calendar->addEvent($bookingEvent);
        }
    }

    public function colorPicker() {
        $r = dechex(rand(100,150));
        $g = dechex(rand(100,150));
        $b = dechex(rand(100,150));
        $pickedColor = "#".$r.$g.$b;

        return $pickedColor;
    }
}