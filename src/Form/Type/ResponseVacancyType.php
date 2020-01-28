<?php

namespace App\Form\Type;

use App\Entity\ResponseVacancy;
use App\Entity\Vacancy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ResponseVacancyType
 *
 * @package App\Form\Type
 */
class ResponseVacancyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vacancy', EntityType::class,[
                'class' => Vacancy::class,
                'placeholder' => 'select job',
                'required' => true,
                'choice_label' => 'name',
            ])
            ->add('email', EmailType::class)
            ->add('name', TextType::class)
            ->add('messageText', TextareaType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResponseVacancy::class,
        ]);
    }
}