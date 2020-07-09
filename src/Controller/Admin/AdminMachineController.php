<?php

namespace App\Controller\Admin;

use App\Entity\Machine;
use App\Form\MachineType;
use App\Repository\MachineRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMachineController extends AbstractController
{
    /**
     * @var MachineRepository
     */
    private $machineRepository;
    /**
     * @var EntityManagerInterface;
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
     * @Route("/admin/machines", name="admin.machines.index")
     * @return Response
     */
    public function index()
    {
        $machines = $this->machineRepository->findAll();
        return $this->render('admin/machine/index.html.twig', [
            'machines' => $machines
        ]);
    }

    /**
     * @Route("/admin/machines/{id}", name="admin.machines.edit", methods="GET|POST")
     * @param Machine $machine
     * @param Request $request
     */
    public function edit(Machine $machine, Request $request)
    {
        $machineForm = $this->createForm(MachineType::class, $machine);
        $machineForm->handleRequest($request);

        if ($machineForm->isSubmitted() && $machineForm->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Machine édité avec succès');
            return $this->redirectToRoute('admin.machines.edit', [
                'id' => $machine->getId()
            ]);
        }

        return $this->render('admin/machine/edit.html.twig', [
            'machine' => $machine,
            'form' => $machineForm->createView()
        ]);
    }

    /**
     * @Route("/admin/machines/{id}", name="admin.machines.delete", methods="DELETE")
     * @param Machine $machine
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Machine $machine, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $machine->getId(), $request->get('_token')))
        {
            $this->entityManager->remove($machine);
            $this->entityManager->flush();
            $this->addFlash('success', 'Machine supprimé avec succès');
        }
        return $this->redirectToRoute('admin.machines.index');
    }

    /**
     * @Route("/admin/machine/new", name="admin.machines.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $machine = new Machine();
        $machineForm = $this->createForm(MachineType::class, $machine);
        $machineForm->handleRequest($request);


        if ($machineForm->isSubmitted() && $machineForm->isValid())
        {
            $this->entityManager->persist($machine);
            $this->entityManager->flush();
            $this->addFlash('success', 'Machine crée avec succès');
            return $this->redirectToRoute('admin.machines.index');
        }

        return $this->render('admin/machine/new.html.twig', [
            'machine' => $machine,
            'form' => $machineForm->createView()
        ]);
    }
}