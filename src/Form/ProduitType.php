<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder
    ->add('nom', null, [
        'label' => 'Nom du produit ',
        'attr' => ['class' => 'form-control mb-3 mt-5'],
    ])
    ->add('description', null, [
        'label' => 'Description',
        'attr' => ['class' => 'form-control mb-3'],
    ])
    ->add('prix', null, [
        'label' => 'Prix (€)',
        'attr' => ['class' => 'form-control mb-3'],
    ])
    ->add('categorie', EntityType::class, [
        'class' => Categorie::class,
        'choice_label' => 'nom',
        'label' => 'Catégorie',
        'placeholder' => 'Choisir une catégorie',
        'attr' => ['class' => 'form-select mb-3'],
    ])
    ->add('imageFile', FileType::class, [
        'mapped' => false,
        'required' => false,
        'label' => 'Image du produit',
        'attr' => ['class' => 'form-control mb-3'],
        'constraints' => [
            new File([
                'maxSize' => '2M',
                'mimeTypes' => [
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                ],
                'mimeTypesMessage' => 'Merci de choisir une image valide (JPEG, PNG, WebP).',
            ]),
        ],
    ])
;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
