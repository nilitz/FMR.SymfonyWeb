<?php


namespace App\Controller\Admin;


use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * AdminProductController constructor.
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {

        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/products", name="admin.products.index")
     * @return Response
     */
    public function index()
    {
        $products = $this->productRepository->findAll();
        return $this->render('admin/product/index.html.twig', [
           'products' => $products
        ]);
    }

    /**
     * @Route("/admin/products/{id}", name="admin.products.edit", methods="GET|POST")
     * @param Product $product
     * @param Request $request
     */
    public function edit(Product $product, Request $request)
    {
        $productForm = $this->createForm(ProductType::class, $product);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Produit édité avec succès');
            return $this->redirectToRoute('admin.products.edit', [
                'id' => $product->getId()
            ]);
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $productForm->createView()
        ]);
    }

    /**
     * @Route("/admin/products/{id}", name="admin.products.delete", methods="DELETE")
     * @param Product $product
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Product $product, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->get('_token')))
        {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
            $this->addFlash('success', 'Produit supprimé avec succès');
        }
        return $this->redirectToRoute('admin.products.index');
    }

    /**
     * @Route("/admin/product/new", name="admin.products.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $product = new Product();
        $productForm = $this->createForm(ProductType::class, $product);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid())
        {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->addFlash('success', 'Produit crée avec succès');
            return $this->redirectToRoute('admin.products.index');
        }

        return $this->render('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $productForm->createView()
        ]);
    }

}