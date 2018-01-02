<?php
namespace AppBundle\Form\Type\Trick;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Fields
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class VideoType
 * The class is used to define trick's videos form fields and security
 *
 * @package AppBundle\Form\Type\Trick
 */
class VideoType extends AbstractType
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
            ->add(  // Add the video's name
                'name',
                TextType::class,
                [
                    'label' => 'Nom'
                ]
            )
            ->add(  // Add the video's alternative description
                'alt',
                TextType::class,
                [
                    'label' => 'Description'
                ]
            )
            ->add(  // Add the source
                'src',
                UrlType::class,
                [
                    'label' => 'Url',
                    'video_property' => 'src'  // Specify that a custom video_property can be defined
                ]
            )
            ->add(  // Add the position for ordered display
                'position',
                HiddenType::class,
                [
                    'attr' => [
                        'class' => 'vid_position',
                    ]
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
            'data_class' => 'AppBundle\Entity\Trick\TrickVideo'  // Targeted entity
        ));
    }

    /**
     * Define the type name
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'VideoType';
    }

}
