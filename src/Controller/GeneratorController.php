<?php

namespace App\Controller;

use App\Repository\CodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GeneratorController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     * @param CodeRepository $codeRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CodeRepository $codeRepository)
    {
        return $this->render('generator/index.html.twig', ['list' => $codeRepository->findAll()]);
    }

    /**
     * @Route("/generuj", name="generateCodes")
     */
    public function generate()
    {
        //TODO action to generate unique code in loop
    }

    /**
     * @Route("/usun", name="removeCodes")
     */
    public function removeCodes()
    {
        //TODO action to remove codes via textarea

        return $this->render('generator/remove.html.twig');
    }
}
