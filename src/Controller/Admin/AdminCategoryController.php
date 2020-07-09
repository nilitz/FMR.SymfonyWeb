<?php


namespace App\Controller\Admin;


use App\Entity\Category;
use App\Entity\Questions;
use App\Form\CategoryType;
use App\Form\QuestionsType;
use App\Repository\CategoryRepository;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     * @param EntityManagerInterface $entityManager
     */

    public function __construct(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @Route("/admin/category", name="admin.categories.index")
     */
    public function index()
    {
        $categories = $this->categoryRepository->findAll();
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/categories/{id}", name="admin.categories.edit", methods="GET|POST")
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(Category $category, Request $request){
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Catégorie éditée avec succès');
            return $this->redirectToRoute('admin.categories.edit', [
                'id' => $category->getId()
            ]);
        }
        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/categories/{id}", name="admin.categories.delete", methods="DELETE")
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Category $category, Request $request){
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->get('_token'))) {
            $this->entityManager->remove($category);
            $this->entityManager->flush();
            $this->addFlash('success', 'Catégorie supprimée avec succès');
        }
        return $this->redirectToRoute('admin.categories.index');
    }

    /**
     * @Route("/admin/category/new", name="admin.categories.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request){
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            $this->addFlash('success', 'Catégorie créée avec succès');
            return $this->redirectToRoute('admin.categories.index');
        }
        return $this->render('admin/category/new.html.twig', [
            'category' => $category,
            'form'=>$form->createView()
        ]);
    }
}