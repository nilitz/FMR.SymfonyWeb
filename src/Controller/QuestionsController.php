<?php

namespace App\Controller;

use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsController extends AbstractController
{
    /**
     * @var QuestionsRepository
     */
    private $questionsRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * @param QuestionsRepository $questionsRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(QuestionsRepository $questionsRepository, EntityManagerInterface $entityManager)
    {
        date_default_timezone_set('Europe/Paris');
        $this->questionsRepository = $questionsRepository;
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/faq", name="faq.index")
     */
    public function index()
    {
        $question = $this->questionsRepository->findAll();
        return $this->render('faq/index.html.twig', [
            'questions'=> $question
        ]);
    }
}
