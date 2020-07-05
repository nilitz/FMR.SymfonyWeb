<?php

namespace App\Controller\Admin;

use App\Entity\Questions;
use App\Form\ProductType;
use App\Form\QuestionsType;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminQuestionsController extends AbstractController
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
        $this->questionsRepository = $questionsRepository;
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/admin/faqs", name="admin.faq.index")
     */
    public function index()
    {
        $questions = $this->questionsRepository->findAll();
        return $this->render('admin/faq/index.html.twig', [
            'questions' => $questions
        ]);
    }

    /**
     * @Route("/admin/faqs/{id}", name="admin.faq.edit", methods="GET|POST")
     * @param Questions $question
     * @param Request $request
     */
    public function edit(Questions $question, Request $request){
        $questionForm = $this->createForm(QuestionsType::class, $question);
        $questionForm->handleRequest($request);

        if ($questionForm->isSubmitted() && $questionForm->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Question éditée avec succès');
            return $this->redirectToRoute('admin.faq.edit', [
                'id' => $question->getId()
            ]);
        }
        return $this->render('admin/faq/edit.html.twig', [
            'question' => $question,
            'form' => $questionForm->createView()
        ]);
    }

    /**
     * @Route("/admin/faqs/{id}", name="admin.faq.delete", methods="DELETE")
     * @param Questions $question
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Questions $question, Request $request){
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->get('_token'))) {
            $this->entityManager->remove($question);
            $this->entityManager->flush();
            $this->addFlash('success', 'Question supprimée avec succès');
        }
        return $this->redirectToRoute('admin.faq.index');
    }

    /**
     * @Route("/admin/faq/new", name="admin.faq.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request){
        $question = new Questions();
        $questionForm = $this->createForm(QuestionsType::class, $question);
        $questionForm->handleRequest($request);

        if($questionForm->isSubmitted() && $questionForm->isValid())
        {
            $this->entityManager->persist($question);
            $this->entityManager->flush();
            $this->addFlash('success', 'Question créée avec succès');
            return $this->redirectToRoute('admin.faq.index');
        }
        return $this->render('admin/faq/new.html.twig', [
            'questions' => $question,
            'form'=>$questionForm->createView()
        ]);
    }

}
