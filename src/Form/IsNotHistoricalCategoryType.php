<?php

namespace App\Form;

use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IsNotHistoricalCategoryType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Category::class,
            'query_builder' => static function (EntityRepository $entityRepository): queryBuilder {
                return $entityRepository->createQueryBuilder('c')
                    ->andWhere('c.isHistorical = 0')
                    ->orderBy('c.name', 'ASC');
            }
        ]);
    }

    public function getParent()
    {
        return EntityType::class;
    }
}
