<?php
    namespace App\Form\Type;
    use App\Entity\News;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    class NewsType extends AbstractType
    {
        /**
         * @param FormBuilderInterface $builder
         * @param array $options
         */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add('dateCreation', DateType::class)
                ->add('heading', TextType::class)
                ->add('annotation', TextType::class)
                ->add('text', TextType::class)
                ->add('imageName', FileType::class, [
                    'mapped' => false,
                    'required'=> false
                ])
            ;
        }
        /**
         * @param OptionsResolver $resolver
         */
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => News::class,
            ]);
        }
    }