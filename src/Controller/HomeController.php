<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriasRepository;


class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(CategoriasRepository $categoriasRepository): Response
    {
        
        $data = $categoriasRepository->findAll();
        return $this->render('home/index.html.twig', [
            'categorias' => $data
        ]);
    }

    #[Route('/home/cuerpoMedico', name: 'medicos')]
    public function cuerpoMedico(): Response
    {
        return $this->render('home/cuerpoMedico.html.twig');
    }

    #[Route('/home/balanceado', name: 'comida')]
    public function balanceado(): Response
    {
        return $this->render('home/balanceado.html.twig');
    }
}
