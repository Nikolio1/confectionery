<?php

namespace App\Admin;

use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



/**
 * Class ProductAdmin
 *
 * @package App\Admin
 *
 * @IsGranted("ROLE_ADMIN")
 */
final class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class)
            ->add('annotation', TextType::class)
            ->add('description', TextareaType::class)
            ->add('weight', NumberType::class)
            ->add('imageName', TextType::class, [
                'empty_data' => null,
                'required'=> false
            ])
            ->add('isNewProduct', ChoiceType::class, [
                'choices'  => [
                    'No'   => false,
                    'Yes'  => true,

                ],
            ])
            ->add('category', EntityType::class,[
                'class'        => Category::class,
                'placeholder'  => 'Choose an option',
                'choice_label' => 'name',
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('weight')
            ->add('name')
            ->add('isNewProduct')
            ->add('category.name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('annotation')
            ->addIdentifier('description')
            ->addIdentifier('weight')
            ->addIdentifier('imageName')
            ->addIdentifier('isNewProduct')
            ->addIdentifier('category.name');
    }
}