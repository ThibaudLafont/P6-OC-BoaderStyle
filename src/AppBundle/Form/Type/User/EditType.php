<?php
namespace AppBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Fields
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class EditType
 * The class is used to define user's profile edit form fields and security
 *
 * @package AppBundle\Form\Type\User
 */
class EditType extends AbstractType
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
            ->add(  // Add the user's profil image though a custom type
                'img',
                ImageType::class,
                [
                    'required' => false
                ]
            )
            ->add(  // Add the fist name
                'firstName',
                TextType::class,
                [
                    'label' => 'Prénom'
                ]
            )
            ->add(  // Add the last name
                'lastName',
                TextType::class,
                [
                    'label' => 'Nom'
                ]
            )
            ->add(  // Add the mail address
                'mail',
                RepeatedType::class,
                [
                    // General options
                    'type' => EmailType::class,
                    // First field options
                    'first_options' => [
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Adresse mail'
                        ]
                    ],
                    // Repeat field options
                    'second_options' => [
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Répétez votre adresse mail'
                        ]
                    ]
                ]
            )
        ->add(  // Add the password field
                'plainPassword',
                RepeatedType::class,
                [
                    // General options
                    'type' => PasswordType::class,
                    'required' => false,
                    'first_name' => 'pass',      // Define a name for the first field
                    'second_name' => 'confirm',  // Define a name for the repeat field
                    'invalid_message' => 'Les mots de passe ne correspondent pas',
                    // First field options
                    'first_options' => [
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Mot de passe'
                        ]
                    ],
                    // Repeat field options
                    'second_options' => [
                        'label' => false,
                        'required' => false,
                        'attr' => [
                            'placeholder' => 'Répétez le mot de passe'
                        ]
                    ]
                ]
            )
            ->add(  // Add the submit button
                'submit',
                SubmitType::class,
                [
                    'label' => 'Enregistrer'
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
            'data_class' => 'AppBundle\Entity\User\User',                   // Targeted entity
            // CSRF protection
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => '251ac8efaefec102ec789f4a3b9366d2d160c813' // Unique key used to generate unique token
        ));
    }

    /**
     * Define the type name
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'UserType';
    }

}
