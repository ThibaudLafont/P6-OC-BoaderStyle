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

class EditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'img',
                ImageType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'firstName',
                TextType::class,
                [
                    'label' => 'Prénom'
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'label' => 'Nom de famille'
                ]
            )
            ->add(
                'mail',
                RepeatedType::class,
                [
                    'type' => EmailType::class,
                    'first_options' => [
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Adresse mail'
                        ]
                    ],
                    'second_options' => [
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Répétez votre adresse mail'
                        ]
                    ]
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'required' => false,
                    'first_options' => [
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Mot de passe'
                        ]
                    ],
                    'second_options' => [
                        'label' => false,
                        'required' => false,
                        'attr' => [
                            'placeholder' => 'Répétez le mot de passe'
                        ]
                    ]
                ]
            )
            ->add('save', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'csrf_token_id'   => '251ac8efaefec102ec789f4a3b9366d2d160c813'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'UserType';
    }

}
