<?php

namespace App\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class NewsAdmin
 *
 * @package App\Admin
 *
 * @IsGranted("ROLE_ADMIN")
 */
final class NewsAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('dateCreation', DateType::class)
            ->add('heading', TextType::class)
            ->add('annotation', TextType::class)
            ->add('text', TextareaType::class)
            ->add('imageName', FileType::class,[
                'mapped'  => false,
                'required' => false,
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('dateCreation')
            ->add('heading');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('dateCreation')
            ->addIdentifier('heading')
            ->addIdentifier('annotation')
            ->addIdentifier('text')
            ->addIdentifier('imageName');
    }


}