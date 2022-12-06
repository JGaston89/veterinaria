<?php

namespace App\Controller\Admin;

use App\Entity\Categorias;
use App\Entity\Producto;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoriasCrudController extends AbstractCrudController
{
    public const PRODUCTOS_BASE_PATH = "/public/uploads/";
    public const PRODUCTOS_UPLOAD_DIR = "/public/uploads/";

    public static function getEntityFqcn(): string
    {
        return Categorias::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Nombre', 'Label'),
            TextField::new('Descripcion'),
            ImageField::new('Imagen')
                ->setBasePath(self::PRODUCTOS_BASE_PATH)
                ->setUploadDir(self::PRODUCTOS_UPLOAD_DIR),
        ];
    }

    public function deleteEntity(EntityManagerInterface $em, $entityInstance):void

    {
        if (!$entityInstance instanceof Categorias) return;

        foreach ($entityInstance->getProductos() as $producto){
            $em->remove($producto);
        }

        parent::deleteEntity($em, $entityInstance);
    }
    
  

}
