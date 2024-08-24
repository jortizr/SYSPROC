<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;


class UserCrudController extends AbstractCrudController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Usuario')
            ->setEntityLabelInPlural('Usuarios')
            ->setSearchFields(['username'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName, ): iterable
    {
        return [
            IdField::new ('id')->onlyOnIndex(),
            TextField::new ('fullname', 'Nombre completo'),
            TextField::new ('username', 'Usuario'),
            TextField::new ('password', 'Contraseña'),

            ChoiceField::new ('roles')->setChoices([
                'Administrador' => 'ROLE_ADMIN',
                'Usuario' => 'ROLE_USER',
            ])->allowMultipleChoices(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPassword()
                )
            );
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User && $entityInstance->getPassword()) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPassword()
                )
            );
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}
