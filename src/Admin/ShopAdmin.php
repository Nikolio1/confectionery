<?php

namespace App\Admin;

use App\Entity\District;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ShopAdmin
 *
 * @package App\Admin
 *
 * @IsGranted("ROLE_ADMIN")
 */
final class ShopAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class)
            ->add('address', TextType::class)
            ->add('mapLink', TextType::class)
            ->add('isBranded', ChoiceType::class,[
                'choices'  => [
                    'Yes'  => true,
                     'No'  => false,
                ],
            ])
            ->add('district', ModelType::class,[
                'class'    => District::class,
                'property' => 'name',
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('address')
            ->add('mapLink')
            ->add('isBranded')
            ->add('district.name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('address')
            ->addIdentifier('mapLink')
            ->addIdentifier('isBranded')
            ->addIdentifier('district.name');
    }
}