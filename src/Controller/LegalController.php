<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    /**
     * @Route("/cgu", name="cgu.show")
     */
    public function showCGU()
    {
        return $this->render('legal\cgu\show.html.twig');
    }

    /**
     *@Route("/mentionslegales", name="legal.show")
     */
    public function showLEGAL()
    {
        return $this->render('legal\legal\show.html.twig');
    }
}