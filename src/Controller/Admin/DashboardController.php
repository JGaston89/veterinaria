<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;    
use App\Entity\Producto;
use App\Entity\Categorias;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;



class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ){

    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       $url = $this->adminUrlGenerator
        ->setController(UserCrudController::class)
        ->generateUrl();

    return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Veterinaria')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Usuarios', 'fa fa-home');

        yield MenuItem::section('Categorias');

        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            //   MenuItem::linkToCrud('Create product', 'fas fa-plus', ProductoCrudController::class)->setAction(Crud::PAGE_NEW),
              MenuItem::linkToCrud('Show category', 'fas fa-eye', Categorias::class),
              MenuItem::linkToCrud('Create category', 'fas fa-plus', Categorias::class)->setAction(Crud::PAGE_NEW)

        ]);

        yield MenuItem::section('Productos');

        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            //   MenuItem::linkToCrud('Create product', 'fas fa-plus', ProductoCrudController::class)->setAction(Crud::PAGE_NEW),
              MenuItem::linkToCrud('Show product', 'fas fa-eye', Producto::class),
              MenuItem::linkToCrud('Create product', 'fas fa-plus', Producto::class)->setAction(Crud::PAGE_NEW)
              

        ]);


    
    
    }
}
