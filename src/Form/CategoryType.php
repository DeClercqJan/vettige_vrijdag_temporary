<?php

namespace App\Form;

use App\DataTransferObject\CategoryDataTransferObject;
use App\Message\Command\CreateCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Naam',
                ]
            )
            ->add(
                'icon',
                FileType::class,
                [
                    'label' => $builder->getData() instanceof CreateCategory ? ' Kies icoon (svg)' : 'Pas icoon aan (svg)'
                ]
            )
            ->add(
                'image',
                FileType::class,
                [
                    'label' => $builder->getData() instanceof CreateCategory ? ' Kies afbeelding (svg)' : 'Pas afbeelding aan (svg)'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoryDataTransferObject::class,
        ]);
    }
}
