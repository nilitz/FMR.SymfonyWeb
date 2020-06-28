<?php

namespace App\Controller;


    use App\Repository\MachineRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

class RentMachineController extends AbstractController
{

    /**
     * @Route("/rent", name="machine.rent")
     * @return Response
     */
    public function index()
    {
        return $this->render('machine/machineRent.html.twig');
    }

}