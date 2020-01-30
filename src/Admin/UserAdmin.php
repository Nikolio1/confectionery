<?php

namespace App\Admin;

use App\Entity\Countries;
use App\Handlers\UploadHandler;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserAdmin
 *
 * @package App\Admin
 *
 */
final class UserAdmin extends AbstractAdmin
{
    /**
     * @var UploadHandler
     */
    protected $uploadHandler;

    protected $passwordEncoder;

    public function __construct($code, $class, $baseControllerName, UserPasswordEncoderInterface $passwordEncoder, UploadHandler $uploadHandler)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->passwordEncoder = $passwordEncoder;
        $this->uploadHandler = $uploadHandler;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('email')
            ->add('roles')
            ->add('firstName')
            ->add('lastName')
            ->add('photoName')
            ->add('country.name');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('file', FileType::class, [
                'required' => false
            ])
            ->add('country', EntityType::class,[
                'class'        => Countries::class,
                'placeholder'  => 'Choose an option',
                'choice_label' => 'name',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => false,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('roles')
            ->add('firstName')
            ->add('lastName')
            ->add('photoName')
            ->add('country.name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('email')
            ->add('roles')
            ->add('firstName')
            ->add('lastName')
            ->add('photoName')
            ->add('country.name')
            ->add('_action', null, [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
                    'delete' => []
                ]
            ]);
    }

    /**
     * @param object $object
     */
    public function preUpdate($object)
    {
        if ($this->getForm()->get('plainPassword')->getData()){
            $object->setPassword($this->passwordEncoder->encodePassword(
                $object,
                $this->getForm()->get('plainPassword')->getData()
            ));
        }

        if ($object->getFile() instanceof UploadedFile) {
            $fileName = $object->getPhotoName();
            $this->uploadHandler->removeFile($fileName, '/user');
            $imageFileName = $this->uploadHandler->upload($object->getFile() , '/user');
            $object->setPhotoName($imageFileName);
        }
    }

    /**
     * @param object $object
     */
    public function prePersist($object)
    {
        if ($this->getForm()->get('plainPassword')->getData()){
            $object->setPassword($this->passwordEncoder->encodePassword(
                $object,
                $this->getForm()->get('plainPassword')->getData()
            ));
        }
        if ( $object->getFile() instanceof UploadedFile) {
            $imageFileName = $this->uploadHandler->upload($object->getFile() , '/user');
            $object->setPhotoName($imageFileName);
        }
    }

    /**
     * @param object $object
     */
    public function postRemove($object)
    {
        $fileName = $object->getPhotoName();
        $this->uploadHandler->removeFile($fileName, '/news');
    }
}