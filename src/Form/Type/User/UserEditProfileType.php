<?php

namespace App\Form\Type\User;

use App\Entity\Countries;
use App\Entity\User;
use App\Handlers\UploadHandler;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class UserEditProfileType
 *
 * @package App\Form\Type\User
 */
class UserEditProfileType extends AbstractType
{
    /**
     * @var UploadHandler
     */
    protected $uploadHandler;

    /**
     * UserEditProfileType constructor.
     * @param UploadHandler $uploadHandler
     */
    public function __construct(UploadHandler $uploadHandler)
    {
        $this->uploadHandler = $uploadHandler;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    /**
     * @param object $object
     */
    public function preUpdate($object)
    {
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
    public function postRemove($object)
    {
        $fileName = $object->getPhotoName();
        $this->uploadHandler->removeFile($fileName, '/user');
    }
}