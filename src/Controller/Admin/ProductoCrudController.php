<?php

namespace App\Controller\Admin;

use App\Entity\Producto;
use App\Entity\Categorias;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Doctrine\ORM\EntityManagerInterface;

class ProductoCrudController extends AbstractCrudController
{
    public const PRODUCTOS_BASE_PATH = "/public/uploads/";
    public const PRODUCTOS_UPLOAD_DIR = "/public/uploads/";

    public static function getEntityFqcn(): string
    {
        return Producto::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Nombre', 'Label'),
            TextField::new('Descripcion'),
            ImageField::new('Imagen')
                ->setBasePath(self::PRODUCTOS_BASE_PATH)
                ->setUploadDir(self::PRODUCTOS_UPLOAD_DIR)
                ->setSortable(false),

            MoneyField::new('Precio')->setCurrency('USD'),
            AssociationField::new('categorias'),
        ];
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance):void
    {
        if (!$entityInstance instanceof Categoria) return;
        $entityInstance->setCreatedAt(new \DateTimeImmutable);

        parent::persistEntity($em, $entityInstance);
    }
    
}
