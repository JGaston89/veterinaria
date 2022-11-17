<?php

namespace App\Controller;

use App\Form\ProductoType;
use App\Entity\Producto;
use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoriasRepository;


#[Route('/producto')]

class ProductoController extends AbstractController
{
    private $em;
    private $ProductoRepository;
    public function __construct(ProductoRepository $ProductoRepository, EntityManagerInterface $em)
    {
        $this->ProductoRepository = $ProductoRepository;
        $this->em = $em;
    }

    #[Route('/', name: 'app_producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository): Response
    {
        return $this->render('producto/index.html.twig', [
            'productos' => $productoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_producto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductoRepository $productoRepository): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $producto = $form->getData();
            $Imagen = $form->get('Imagen')->getData();
           if ($Imagen){
                $newFileName = uniqid() . '.' . $Imagen->guessExtension();
                try {
                    $Imagen->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/',
                        $newFileName
                    );
                } catch (FileException $e){
                    return new Response($e->getMessage());
                }
                
                $producto->setImagen('/uploads/' . $newFileName);
           }
            $productoRepository->save($producto, true);
            return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_producto_show', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        return $this->render('producto/show.html.twig', [
            'producto' => $producto,
        ]);
    }

    #[Route('/producto/edit/{id}', name: 'app_producto_edit')]
    public function edit($id, Request $request): Response
    {
        $producto = $this->ProductoRepository->find($id);
        $form = $this->createForm(ProductoType::class, $producto);

        $form->handleRequest($request);
        $Imagen = $form->get('Imagen')->getData();

        if($form->isSubmitted() && $form->isValid()){
            if($Imagen){                 
                if($producto->getImagen() !== null){
                     if(file_exists(
                        $this->getParameter('kernel.project_dir') . $producto->getImagen()                        
                        )){
                            $this->GetParameter('kernel.project_dir') . $producto->getImagen();
                        }
                            $newFileName = uniqid() . '.' . $Imagen->guessExtension();
                           
                            try {
                                $Imagen->move(
                                    $this->getParameter('kernel.project_dir') . '/public/uploads',
                                    $newFileName
                                );
                            } catch (FileException $e){
                                return new Response($e->getMessage());
                            }

                            $producto->setImagen('/uploads/' . $newFileName);
                            $this->em->flush();

                            return $this->redirectToRoute('app_producto_index');
                            
                        }
            }
        }
        return  $this->render('producto/edit.html.twig',[
            'producto' => $producto,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto, ProductoRepository $productoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->request->get('_token'))) {
            $productoRepository->remove($producto, true);
        }

        return $this->redirectToRoute('app_producto_index', [], Response::HTTP_SEE_OTHER);
    }
}







