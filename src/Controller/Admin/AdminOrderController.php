<?php


namespace App\Controller\Admin;


use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminOrderController extends  AbstractController
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
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
     * @param OrderRepository $orderRepository
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {


        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/orders", name="admin.orders.index")
     * @return Response
     */
    public function index()
    {
        $orders = $this->orderRepository->findAll();
        return $this->render('admin/order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/admin/orders/{id}", name="admin.orders.show")
     * @param Order $order
     * @return Response
     */
    public function show(Order $order)
    {
        return $this->render('admin/order/show.html.twig', [
            'order' => $order
        ]);
    }

    /**
     * @Route("/admin/orders/{id}/next", name="admin.orders.next")
     * @param Order $order
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function next(Order $order, EntityManagerInterface $entityManager)
    {

        if ($order->getIsAccepted() == false){
            $order->setIsAccepted(true);
        }
        elseif ($order->getIsAccepted() == true and $order->getIsComplete() == false){
            $order->setIsComplete(true);
        }
        elseif ($order->getIsComplete() == true and $order->getIsDelivered() == false){
            $order->setIsDelivered(true);
        }

        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'étape suivante',
            200]);
    }

}