<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/admin/utilisateurs", name="admin.users.index")
     */
    public function index()
    {
        $users = $this->userRepository->findAll();
        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/utilisateurs/{id}", name="admin.users.show")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function show(User $user, Request $request)
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Utilisateur édité avec succès');
            return $this->redirectToRoute('admin.users.show', [
                'id' => $user->getId()
            ]);
        }
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/users/{id}", name="admin.users.delete")
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(User $user, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token')))
        {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'Utilisateur supprimé avec succès');
        }
        return $this->redirectToRoute('admin.users.index');
    }
}