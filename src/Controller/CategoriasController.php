<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Form\CategoriasType;
use App\Repository\CategoriasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductoRepository;


#[Route('/categorias')]
class CategoriasController extends AbstractController
{
    #[Route('/', name: 'app_categorias_index', methods: ['GET'])]
    public function index(CategoriasRepository $categoriasRepository): Response
    {
        return $this->render('categorias/index.html.twig', [
            'categorias' => $categoriasRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_categorias_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoriasRepository $categoriasRepository): Response
    {
        $categorias = new Categorias();
        $form = $this->createForm(CategoriasType::class, $categorias);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorias = $form->getData();
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
                
                $categorias->setImagen('/uploads/' . $newFileName);
           }
            $categoriasRepository->save($categorias, true);
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('categorias/new.html.twig', [
            'categoria' => $categorias,
            'form' => $form,
        ]);
    }

    
    #[Route('/{id}', name: 'app_categorias_show', methods: ['GET'])]
    public function show(Categorias $categoria, ProductoRepository $productoRepository, $id): Response
    {
       $data=$productoRepository->getProductosByCategorias($id);
        
        return $this->render('categorias/show.html.twig', [
            'productos'=>$data,
            'categoria' => $categoria,
        ]);
    }


    #[Route('/categorias/edit/{id}', name: 'app_categorias_edit')]
    public function edit($id, Request $request): Response
    {
        $categorias = $this->CategoriasRepository->find($id);
        $form = $this->createForm(CategoriasType::class, $categorias);

        $form->handleRequest($request);
        $Imagen = $form->get('Imagen')->getData();

        if($form->isSubmitted() && $form->isValid()){
            if($Imagen){                 
                if($categorias->getImagen() !== null){
                     if(file_exists(
                        $this->getParameter('kernel.project_dir') . $categorias->getImagen()                        
                        )){
                            $this->GetParameter('kernel.project_dir') . $categorias->getImagen();
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

                            $categorias->setImagen('/uploads/' . $newFileName);
                            $this->em->flush();

                            return $this->redirectToRoute('app_categorias_index');
                            
                        }
            }
        }
        return  $this->render('categorias/edit.html.twig',[
            'categorias' => $categorias,
            'form' => $form->createView()
        ]);
    }


    #[Route('/{id}', name: 'app_categorias_delete', methods: ['POST'])]
    public function delete(Request $request, Categorias $categoria, CategoriasRepository $categoriasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoria->getId(), $request->request->get('_token'))) {
            $categoriasRepository->remove($categoria, true);
        
        }

        return $this->redirectToRoute('app_categorias_index', [], Response::HTTP_SEE_OTHER);
    }
}


