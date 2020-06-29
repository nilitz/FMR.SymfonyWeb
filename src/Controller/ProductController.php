<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\Product;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
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
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * AdminProductController constructor.
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $entityManager
     * @param OrderRepository $orderRepository
     */
    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager, OrderRepository $orderRepository)
    {
        date_default_timezone_set('Europe/Paris');
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/products", name="products.index")
     * @return Response
     */
    public function index()
    {
        $products = $this->productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/products/{id}", name="products.show")
     * @param Product $product
     * @param Request $request
     * @return Response
     */
    public function show(Product $product, Request $request) :Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isSubmitted() && $form->isValid())
        {
            $order
                ->setUser($user)
                ->setCompleteAt(new \DateTime())
                ->setOrderedAt(new \DateTime())
                ->setIsDelivered(false)
                ->setProduct($product);
            $this->entityManager->persist($order);
            $this->entityManager->flush();
            $this->addFlash('success', 'Commande effectuée avec succès');
            return $this->redirectToRoute('products.index');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}