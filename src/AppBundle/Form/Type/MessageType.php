<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Fields
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class MessageType
 * The class is used to define message post form fields and security
 *
 * @package AppBundle\Form\Type
 */
class MessageType extends AbstractType
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
            ->add(  // Add content
                'content',
                TextType::class,
                [
                    'label' => 'Message',
                    'attr' => [
                        'placeholder' => 'Tapez votre message'
                    ]
                ]
            )
            ->add(  // Add submit type
                'Envoyer',
                SubmitType::class,
                [
                    'label' => " "  // Define an empty label in order to customize submit button in front work
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
            'data_class' => 'AppBundle\Entity\Message\Message',              // Targeted entity
            // CSRF protection
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => '3bbe003910bbcac6a22ea2d4a3b591bd3fdef519'  // Unique key used to generate unique token
        ));
    }

    /**
     * Define the type name
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'MessageType';
    }

}
