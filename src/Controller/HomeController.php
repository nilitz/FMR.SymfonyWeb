<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * HomeController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home.index")
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response
     */
    public function index(Request $request, ContactNotification $notification):Response
    {

        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);



        if($contactForm->isSubmitted() && $contactForm->isValid())
        {
            $notification->notify($contact);

            $this->addFlash('success', 'Votre Email a bien été envoyé');
            return $this->redirectToRoute('home.index');
        }

        return $this->render('pages/home.html.twig', [
            'form' => $contactForm->createView()
        ]);
    }
}