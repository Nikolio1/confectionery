<?php
    namespace App\Form\Type;

    use App\Entity\Category;
    use App\Entity\Product;
    use App\Entity\SubCategory;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class ProductType extends AbstractType
    {
        /**
         * @param FormBuilderInterface $builder
         * @param array $options
         */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add('name', TextType::class)
                ->add('annotation', TextType::class)
                ->add('description', TextType::class)
                ->add('weight', TextType::class)
                ->add('imageName', TextType::class, ['empty_data' => null,'required'=> false])
                ->add('isNewProduct', ChoiceType::class, [
                    'choices'  => [
                        'Yes' => true,
                        'No' => false,
                    ],
                ])
                ->add('category', EntityType::class,[
                    'class' => Category::class,
                    'placeholder' => 'Choose an option',
                    'choice_label' => 'name',
                ])
                ->add('subCategory', EntityType::class,[
                    'class' => SubCategory::class,
                    'placeholder' => 'Choose an option',
                    'required' => false,
                    'choice_label' => 'name',
                ])

            ;
        }
        /**
         * @param OptionsResolver $resolver
         */
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => Product::class,
            ]);
        }
    }