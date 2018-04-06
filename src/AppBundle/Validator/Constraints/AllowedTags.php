<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class AllowedTags
 * Constraint used to allow the use of specified HTML tags
 * Permit a XSS protection for safe use of HTML in string user's inputs
 *
 * Work with AllowedTagsValidator
 *
 * @Annotation
 * @package AppBundle\Validator\Constraints
 */
class AllowedTags extends Constraint
{

    /**
     * Store the HTML tags witch are allowed
     *
     * @var String
     */
    public $allowedTags;

    /**
     * This message will be displayed in case of unauthorized HTML tags use
     *
     * @var string
     */
    public $message = 'Les seules balises html autorisées sont {{ allowed_tags }}';

}
