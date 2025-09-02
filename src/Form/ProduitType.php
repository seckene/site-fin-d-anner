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
        'label' => 'Nom du produit',
        'attr' => [
            'class' => 'form-control mb-3 mt-4',
            'placeholder' => 'Entrez le nom du produit',
        ],
    ])
    ->add('description', null, [
        'label' => 'Description',
        'attr' => [
            'class' => 'form-control mb-3',
            'placeholder' => 'Décrivez le produit',
            'rows' => 4,
        ],
    ])
    ->add('descrptionlong', null, [
        'label' => 'descrptionlong',
        'attr' => [
            'class' => 'form-control mb-3',
            'placeholder' => ' descrptionlong',
            'rows' => 4,
        ],
    ])->add('couleur', null, [
        'label' => 'couleur',
        'attr' => [
            'class' => 'form-control mb-3',
            'placeholder' => 'Décrivez la couleur',
            'rows' => 4,
        ],
    ])



    ->add('stock', null, [
        'label' => 'stock',
        'attr' => [
            'class' => 'form-control mb-3',
            'placeholder' => 'le stockC',
            'rows' => 4,
        ],
    ])
    ->add('prix', null, [
        'label' => 'Prix (€)',
        'attr' => [
            'class' => 'form-control mb-3',
        ],
    ])
    ->add('categorie', EntityType::class, [
        'class' => Categorie::class,
        'choice_label' => 'nom',
        'label' => 'Catégorie',
        'placeholder' => 'Choisir une catégorie',
        'attr' => [
            'class' => 'form-select mb-3',
        ],
    ])
    ->add('imageFile', FileType::class, [
        'mapped' => false,
        'required' => false,
        'label' => 'Image du produit',
        'attr' => [
            'class' => 'form-control mb-3',
            'accept' => 'image/jpeg,image/png,image/webp',
        ],
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
    ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
