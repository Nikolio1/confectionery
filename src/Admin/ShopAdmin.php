<?php

namespace App\Admin;

use App\Entity\District;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ShopAdmin
 *
 * @package App\Admin
 *
 */
final class ShopAdmin extends AbstractAdmin
{
    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('address')
            ->add('mapLink')
            ->add('isBranded')
            ->add('district.name');
    }

    /**
     * @param FormMapper $formMapper
     */
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

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('address')
            ->add('mapLink')
            ->add('isBranded')
            ->add('district.name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('address')
            ->add('mapLink')
            ->add('isBranded')
            ->add('district.name')
            ->add('_action', null, [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
                    'delete' => []
                ]
            ]);
    }
}