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

    private $indentation = 0;

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

        $userProductOrder = $this->orderRepository->findAllByUserAndProductId($user->getId(), $product->getId());
        $totalProductOrder = $this->orderRepository->findAllByProductId($product->getId());

        $userProductOrder = $this->getWaitingOrder($userProductOrder, $product);
        $totalProductOrder = $this->getWaitingOrder($totalProductOrder, $product);

        if(($product->getMaxProduction() - $this->getActualOrder($totalProductOrder)) > $product->getMaxUser()){
            $canOrder = $product->getMaxUser() - $this->getActualOrder($userProductOrder);
        }else{
            $canOrder = $product->getMaxProduction() - $this->getActualOrder($totalProductOrder) - $this->getActualOrder($userProductOrder);
        }


        if ($form->isSubmitted() && $form->isValid() && ($order->getQuantity() <= $canOrder ))
        {
            $order
                ->setUser($user)
                ->setOrderedAt(new \DateTime())
                ->setIsDelivered(false)
                ->setIsAccepted(false)
                ->setIsComplete(false)
                ->setProduct($product);
            $this->entityManager->persist($order);
            $this->entityManager->flush();
            $this->addFlash('success', 'Commande effectuée avec succès');
            return $this->redirectToRoute('products.show', [
                'id' => $product->getId(),
                'order' => $this->getActualOrder($userProductOrder),
                'orderTotal' => $this->getActualOrder($totalProductOrder),
                'canOrder' => $canOrder,
                'product' => $product,
                'form' => $form->createView()
            ]);
        }




        return $this->render('product/show.html.twig', [
            'order' => $this->getActualOrder($userProductOrder),
            'orderTotal' => $this->getActualOrder($totalProductOrder),
            'canOrder' => $canOrder,
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    private function getActualOrder($array)
    {
        $count = 0;
        foreach ($array as $k)
        {
            $count += $k->getQuantity();
        }
        return $count;
    }

    /**
     * @param array $array
     * @param $product
     * @return array
     */
    private function getWaitingOrder($array, $product)
    {
        foreach ($array as $stat)
        {
            $actualDateTime = new \DateTime();
            switch ($product->getPeriod())
            {
                case "Jour":
                    if($actualDateTime->sub(new \DateInterval('P1D')) > $stat->getOrderedAt())
                    {
                        unset($array[$this->indentation]);
                    }
                    break;
                case "Semaine":
                    if($actualDateTime->sub(new \DateInterval('P7D')) > $stat->getOrderedAt())
                    {
                        unset($array[$this->indentation]);
                    }
                    break;
                case "Mois":
                    if($actualDateTime->sub(new \DateInterval('P1M')) > $stat->getOrderedAt())
                    {
                        unset($array[$this->indentation]);
                    }
                    break;
            }
            $this->indentation++;
        }
        $this->indentation = 0;
        return $array;
    }

}