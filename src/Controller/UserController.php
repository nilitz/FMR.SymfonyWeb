<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserEditType;
use App\Form\UserUserEditType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
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
     * @Route("/utilisateurs/{id}", name="users.show")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function show(User $user, Request $request)
    {
        $form = $this->createForm(UserUserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Utilisateur édité avec succès');
            return $this->redirectToRoute('users.show', [
                'id' => $user->getId()
            ]);
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}