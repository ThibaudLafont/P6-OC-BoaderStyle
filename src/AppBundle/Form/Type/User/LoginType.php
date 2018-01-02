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
 * Class LoginType
 * The class is used to define user login form fields and security
 *
 * @package AppBundle\Form\Type\User
 */
class LoginType extends AbstractType
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
            ->add(  // Add username
                'userName',
                TextType::class,
                [
                    'label' => 'Nom d\'utilisateur'
                ]
            )
            ->add(  // Add password field
                'plainPassword',
                PasswordType::class
            )
            ->add(  // Add save button
                'submit',
                SubmitType::class,
                [
                    'label' => 'Se connecter'
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
            'data_class' => 'AppBundle\Entity\User\User',                     // Targeted entity
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
