<?php
namespace AppBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Fields
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Class ImageType
 * The class is used to define user profile image form fields and security
 *
 * @package AppBundle\Form\Type\User
 */
class ImageType extends AbstractType
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
            ->add(  // Add a file field
                'file',
                FileType::class,
                [
                    'label' => 'Photo',
                    'image_property' => 'url'
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
            'data_class' => 'AppBundle\Entity\User\UserImage',
            'validation_groups' => 'default'// Targeted entity
        ));
    }

    /**
     * Define the type name
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ImageType';
    }

}
