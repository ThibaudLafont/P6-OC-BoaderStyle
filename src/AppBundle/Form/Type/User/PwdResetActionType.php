<?php
namespace AppBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Fields
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class PwdResetActionType
 * The class is used to define user password reset form fields and security
 * This form type is the one used once reset request is already pending
 *
 * @package AppBundle\Form\Type\User
 */
class PwdResetActionType extends AbstractType
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
            ->add(  // Add password field
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
            ->add(  // Add submit button
                'reset',
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
            'validation_groups' => false,
            // CSRF protection
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => '1a2d18f3b5afda74da234770bfc8b3744241bd4b'  // Unique key used to generate unique token
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
