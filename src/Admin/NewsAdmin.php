<?php

namespace App\Admin;

use App\Handlers\UploadHandler;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class NewsAdmin
 *
 * @package App\Admin
 */
final class NewsAdmin extends AbstractAdmin
{
    /**
     * @var UploadHandler
     */
    protected $uploadHandler;

    /**
     * NewsAdmin constructor.
     *
     * @param $code
     * @param $class
     * @param $baseControllerName
     * @param UploadHandler $uploadHandler
     */
    public function __construct($code, $class, $baseControllerName, UploadHandler $uploadHandler)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->uploadHandler = $uploadHandler;
    }

    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('dateCreation', null, [
                'format' => 'd-m-Y H:i',
            ])
            ->add('heading', TextType::class)
            ->add('annotation', TextType::class)
            ->add('text', TextareaType::class)
            ->add('imageName', TextType::class);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('dateCreation', DateType::class)
            ->add('heading', TextType::class)
            ->add('annotation', TextType::class)
            ->add('text', TextareaType::class)
            ->add('file', FileType::class, [
                'required' => false
            ])
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('dateCreation')
            ->add('heading');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('dateCreation')
            ->add('heading')
            ->add('annotation')
            ->add('text', null, [
                'editable' => true
            ])
            ->add('imageName')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => []
                ]
            ])
        ;
    }

    /**
     * @param object $object
     */
    public function prePersist($object)
    {
        if ( $object->getFile() instanceof UploadedFile) {
            $imageFileName = $this->uploadHandler->upload($object->getFile() , '/news');
            $object->setImageName($imageFileName);
        }
    }

    /**
     * @param object $object
     */
    public function preUpdate($object)
    {
        if ($object->getFile() instanceof UploadedFile) {
            $fileName = $object->getImageName();
            $this->uploadHandler->removeFile($fileName, '/news');
            $imageFileName = $this->uploadHandler->upload($object->getFile() , '/news');
            $object->setImageName($imageFileName);
        }
    }

    /**
     * @param object $object
     */
    public function postRemove($object)
    {
        $fileName = $object->getImageName();
        $this->uploadHandler->removeFile($fileName, '/news');
    }
}