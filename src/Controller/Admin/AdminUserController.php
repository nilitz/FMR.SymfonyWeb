<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/utilisateurs", name="admin.users.index")
     */
    public function index()
    {
        $users = $this->userRepository->findAll();
        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/utilisateurs/{id}", name="admin.users.show")
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user
        ]);
    }
}