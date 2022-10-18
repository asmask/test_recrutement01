<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FactureRepository;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="app_main")
     */
    public function index(FactureRepository $factureRepository): Response
    {

        return $this->render('main/index.html.twig', [
            'factures' => $factureRepository->findAll(),
        ]);
     
    }
}
