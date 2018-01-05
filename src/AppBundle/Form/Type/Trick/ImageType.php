<?php
namespace AppBundle\Form\Type\Trick;

use AppBundle\Entity\Trick\TrickImage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// Fields
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Class ImageType
 * The class is used to define trick's images form fields and security
 *
 * @package AppBundle\Form\Type\Trick
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
            ->add(  // Add the TrickImage's name
                'name',
                TextType::class,
                [
                    'label' => 'Nom'
                ]
            )
            ->add(  // Add the alternative description
                'alt',
                TextType::class,
                [
                    'label' => 'Description'
                ]
            )
            ->add(  // Set a file field
                'file',
                FileType::class,
                [
                    'label' => 'Fichier',
                    'constraints' => [
                        new Image([
                            'allowSquare' => false,
                            'allowPortrait' => false,
                            'allowLandscape' => true,
                            'minRatio' => '1.4',
                            'allowSquareMessage' => 'Une image au format paysage est demandée',
                            'allowPortraitMessage' => 'Une image au format paysage est demandée',
                            'minRatioMessage' => 'Votre image s\'approche trop d\'un carré (ratio min L/H : 1.4)'
                        ])
                    ],
                    'image_property' => 'url'       // Add the custom image_property, defined in ImageTypeExtension
                ]
            )
            ->add(  // Set a hidden position field, witch is used in trick display
                'position',
                HiddenType::class,
                [
                    'attr' => [
                        'class' => 'img_position',  // Specify a class_name for this field, for symfony-collection handling
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
        // TODO: CSRF ??
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Trick\TrickImage',  // Target entity,
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
