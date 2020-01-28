<?php

namespace App\Admin;

use App\Handlers\UploadHandler;
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
    protected $uploadHandler;


    public function __construct($code, $class, $baseControllerName, UploadHandler $uploadHandler)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->uploadHandler = $uploadHandler;
    }


    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', FileType::class, [
                'required' => false
            ])
        ;
    }

    /**
     * @param object $object
     */
    public function prePersist($object)
    {
        if ( $object->getFile() instanceof UploadHandler) {
            $imageFileName = $this->uploadHandler->upload($object->getFile() , '/news');
            $object->setImageName($imageFileName);
        }
    }

    /**
     * @param object $file
     */
    public function preUpdate($file)
    {
        if ( $file->getFile()) {
            $file->refreshUpdated();
            $file->lifecycleFileUpload();
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