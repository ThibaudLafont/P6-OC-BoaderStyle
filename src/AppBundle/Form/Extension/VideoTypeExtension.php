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
    public function getExtendedType()
    {
        return UrlType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
// makes it legal for FileType fields to have an image_property option
        $resolver->setDefined(array('video_property'));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['video_property'])) {
// this will be whatever class/entity is bound to your form (e.g. Media)
            $parentData = $form->getParent()->getData();

            $videoUrl = null;
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $videoUrl = $accessor->getValue($parentData, $options['video_property']);
            }

// set an "image_url" variable that will be available when rendering this field
            $view->vars['video_url'] = $videoUrl;
        }
    }

}