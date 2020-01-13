<?php

namespace App\Admin;

use App\Entity\Category;
use App\Handlers\UploadHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Class ProductAdmin
 *
 * @package App\Admin
 *
 * @IsGranted("ROLE_ADMIN")
 */
final class ProductAdmin extends AbstractAdmin
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
            ->add('name')
            ->add('annotation')
            ->add('description')
            ->add('weight')
            ->add('imageName')
            ->add('isNewProduct')
            ->add('category.name');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class)
            ->add('annotation', TextType::class)
            ->add('description', TextareaType::class)
            ->add('weight', NumberType::class)
            ->add('file', FileType::class, [
                'required' => false
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

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('weight')
            ->add('name')
            ->add('isNewProduct')
            ->add('category.name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('annotation')
            ->add('description')
            ->add('weight')
            ->add('imageName')
            ->add('isNewProduct')
            ->add('category.name')
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
            $imageFileName = $this->uploadHandler->upload($object->getFile() , '/product');
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
            $imageFileName = $this->uploadHandler->upload($object->getFile() , '/product');
            $object->setImageName($imageFileName);
        }
    }

    /**
     * @param object $object
     */
    public function postRemove($object)
    {
            $fileName = $object->getImageName();
            $this->uploadHandler->removeFile($fileName, '/product');
    }
}