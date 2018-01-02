<?php
namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoTypeExtension extends AbstractTypeExtension
{
    /**
     * Specify the formtype we want to extend
     * @return string
     */
    public function getExtendedType()
    {
        return UrlType::class;
    }

    /**
     * Define what extras properties will be add to the UrlType
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // makes it legal for Url fields to have an video_property option
        $resolver->setDefined(array('video_property'));
    }

    /**
     * Called method when extended type view is build
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // Check if extra property is defined
        if (isset($options['video_property'])) {
            // this will be whatever class/entity is bound to your form (e.g. Media)
            $parentData = $form->getParent()->getData();

            $videoUrl = null;
            // If parent's data is found, get value of extra property
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $videoUrl = $accessor->getValue($parentData, $options['video_property']);
            }

            // set an "video_url", witch will be null if no parentData is found
            $view->vars['video_url'] = $videoUrl;
        }
    }

}
