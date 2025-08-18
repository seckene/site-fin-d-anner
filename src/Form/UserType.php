<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'label' => 'Nom d’utilisateur',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('tel', TextType::class, [   // 👈 AJOUT DU CHAMP TEL
                'label' => 'Téléphone',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3'],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true,
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' => ['class' => 'form-check-label'],
                'choice_attr' => fn () => ['class' => 'form-check-input'],
            ]);
    }
}
