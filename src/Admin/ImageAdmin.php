<?php

namespace App\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class ImageAdmin
 *
 * @package App\Admin
 *
 * @IsGranted("ROLE_ADMIN")
 */
final class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', FileType::class, [
                'required' => false
            ])
        ;
    }

    /**
     * @param object $file
     */
    public function prePersist($file)
    {
        if ( $file->getFile()) {
            $file->refreshUpdated();
            $file->lifecycleFileUpload();
;
        }

    }


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('filename')
            ->add('updated');

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('filename')
            ->addIdentifier('updated');
    }
}