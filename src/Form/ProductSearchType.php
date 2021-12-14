<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Vendor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pret',ChoiceType::class,[
                'choices'  => [
                    '0-99' => '0-99',
                    '100-499' => '100-499',
                    '500-999' => '500-999',
                    '1000-4999' => '1000-4999',
                    '5000-10000' => '5000-10000',
                ],
                'multiple' => true,
                'required' => false,
                'expanded'=>true,
            ])
            ->add('vendors', EntityType::class, [
                'class'=>Vendor::class,
                'required' => false,
                'multiple' => true,
                'expanded'=>true
            ])
            ->add('Filter', SubmitType::class)
        ;
    }
}
