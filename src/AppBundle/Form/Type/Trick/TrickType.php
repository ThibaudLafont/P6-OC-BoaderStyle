<?php
namespace AppBundle\Form\Type\Trick;

use AppBundle\Entity\Trick\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Fields
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class TrickType
 * The class is used to define trick form fields and security
 *
 * @package AppBundle\Form\Type\Trick
 */
class TrickType extends AbstractType
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
            ->add(  // Add trick's name field
                'name',
                TextType::class,
                [
                    'label' => 'Nom'
                ]
            )
            ->add(  // Add general descrition field
                'description',
                TextareaType::class,
                [
                    'attr' =>
                        [
                            'rows' => "10"
                        ]
                ]
            )
            ->add(  // Add a choice field with existent categories
                'category',
                EntityType::class,
                [
                    'label' => 'Catégorie',
                    'class' => 'AppBundle:Trick\Category',  // Specify the target entity
                    'choice_label' => 'name'
                ]
            )
            ->add(  // Add a symfony collection for trick's img add/edit
                'imgs',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => ImageType::class,  // Use the defined custom type for images
                    'allow_add' => true,               // Allow the form user to add new images
                    'allow_delete' => true,            // Allow the form user to delete existent images
                    'prototype' => true,
                    'by_reference' => false,
                    'attr' => [
                        'class' => 'img'
                    ]
                ]
            )
            ->add(  // Add a symfony collection for vidoes add/edit
                'videos',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => VideoType::class,  // Use the defined custom type for videos
                    'allow_add' => true,               // Allow the user to add new videos
                    'allow_delete' => true,            // Allow the user to delete existent videos
                    'prototype' => true,
                    'by_reference' => false,
                    'attr' => [
                        'class' => 'video',
                    ]
                ]
            )
            ->add(  // Add the submit button
                'submit',
                SubmitType::class,
                [
                    'label' => 'Publier'
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
            'data_class' => 'AppBundle\Entity\Trick\Trick',
            'validation_groups' => ['Default', 'trick'],
            // CRSF protection
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => '2799158ad58cb741f1e0b663fd3cd423', // Unique string used to generate unique token
        ));
    }

    /**
     * Define the type name
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'TrickType';
    }


}
