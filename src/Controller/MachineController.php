<?php


namespace App\Controller;


use App\Repository\MachineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * AdminMachineController constructor.
     * @param MachineRepository $machineRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(MachineRepository $machineRepository, EntityManagerInterface $entityManager)
    {

        $this->machineRepository = $machineRepository;
        $this->entityManager = $entityManager;
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

}