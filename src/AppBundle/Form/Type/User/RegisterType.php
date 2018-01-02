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
 * Class RegisterType
 * The class is used to define user register form fields and security
 *
 * @package AppBundle\Form\Type\User
 */
class RegisterType extends AbstractType
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
            ->add(  // Add firstName
                'firstName',
                TextType::class,
                [
                    'label' => 'Prénom'
                ]
            )
            ->add(  // Add lastName
                'lastName',
                TextType::class,
                [
                    'label' => 'Nom de famille'
                ]
            )
            ->add(  // Add mail address
                'mail',
                RepeatedType::class,
                [
                    // General options
                    'type' => EmailType::class,
                    // Fist field options
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
            ->add(  // userName field
                'userName',
                TextType::class,
                [
                    'label' => 'Nom d\'utilisateur'
                ]
            )
            ->add(  // plainPassword field
                'plainPassword',
                RepeatedType::class,
                [
                    // General options
                    'type' => PasswordType::class,
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
                        'attr' => [
                            'placeholder' => 'Répétez le mot de passe'
                        ]
                    ]
                ]
            )
            ->add(  // Add image type form
                'img',
                ImageType::class
            )
            ->add(  // Add submit button
                'save',
                SubmitType::class
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
            'data_class' => 'AppBundle\Entity\User\User',                    // Targeted entity
            // CRSF protection
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => '251ac8efaefec102ec789f4a3b9366d2d160c813'  // Uniq key used to generate an unique token
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
