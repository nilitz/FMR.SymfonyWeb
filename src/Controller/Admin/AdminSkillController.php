<?php


namespace App\Controller\Admin;


use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSkillController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var SkillRepository
     */
    private $skillRepository;

    /**
     * @param SkillRepository $skillRepository
     * @param EntityManagerInterface $entityManager
     */

    public function __construct(SkillRepository $skillRepository, EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
        $this->skillRepository = $skillRepository;
    }
    /**
     * @Route("/admin/skill", name="admin.skills.index")
     */
    public function index()
    {
        $skills = $this->skillRepository->findAll();
        return $this->render('admin/skill/index.html.twig', [
            'skills' => $skills
        ]);
    }

    /**
     * @Route("/admin/skills/{id}", name="admin.skills.edit", methods="GET|POST")
     * @param skill $skill
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(skill $skill, Request $request){
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Compétence éditée avec succès');
            return $this->redirectToRoute('admin.skills.edit', [
                'id' => $skill->getId()
            ]);
        }
        return $this->render('admin/skill/edit.html.twig', [
            'skill' => $skill,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/skills/{id}", name="admin.skills.delete", methods="DELETE")
     * @param skill $skill
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(skill $skill, Request $request){
        if ($this->isCsrfTokenValid('delete' . $skill->getId(), $request->get('_token'))) {
            $this->entityManager->remove($skill);
            $this->entityManager->flush();
            $this->addFlash('success', 'Compétence supprimée avec succès');
        }
        return $this->redirectToRoute('admin.skills.index');
    }

    /**
     * @Route("/admin/skill/new", name="admin.skills.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request){

        $skill = new skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($skill);
            $this->entityManager->flush();
            $this->addFlash('success', 'Compétence créée avec succès');
            return $this->redirectToRoute('admin.skills.index');
        }
        return $this->render('admin/skill/new.html.twig', [
            'skill' => $skill,
            'form'=>$form->createView()
        ]);
    }
}