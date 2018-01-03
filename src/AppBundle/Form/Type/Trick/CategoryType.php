<?php
namespace AppBundle\Form\Type\Trick;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// Fields
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class CategoryType
 * The class is used to define Category form fields and security
 *
 * @package AppBundle\Form\Type\Trick
 */
class CategoryType extends AbstractType
{
    /**
     * Define the fields of this form type
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(  // Add the category name
                'name',
                TextType::class,
                [
                    'label' => false,
                    'attr' =>
                    [
                        'placeholder' => 'Nom de la catégorie'
                    ]
                ]
            )
            ->add(  // Add the submit button
                'submit',
                SubmitType::class,
                [
                    'label' => 'Ajouter'
                ]
            );
    }

    /**
     * Configure options to this form type
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            // Define the target entity
            'data_class' => 'AppBundle\Entity\Trick\Category',
            // CSRF protection
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'ca5deb0984fb5ec40b43e7b2e45af4e7942d3434' // Unique key used to define unique token
        ));
    }

    /**
     * Define the type name
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'CategoryType';
    }
}
