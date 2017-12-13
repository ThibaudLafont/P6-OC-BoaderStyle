<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AllowedTags extends Constraint
{
    public $allowedTags;
    public $message = 'Les seules balises html autorisées sont {{ allowed_tags }}';
}