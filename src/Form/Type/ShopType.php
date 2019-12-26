<?php

namespace App\Form\Type;

use App\Entity\District;
use App\Entity\Shop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('address', TextType::class)
            ->add('mapLink', TextType::class)
            ->add('isBranded', ChoiceType::class, [
                    'choices'  => [
                        'Yes' => true,
                        'No' => false,
                    ],
                ])
            ->add('district', EntityType::class,[
                'class' => District::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shop::class,
        ]);
    }
}
