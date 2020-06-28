<?php


namespace App\Controller\Admin;


use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}