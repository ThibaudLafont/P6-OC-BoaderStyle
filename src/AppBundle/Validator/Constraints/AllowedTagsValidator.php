<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class AllowedTagsValidator
 * Execute a validation test with AllowedTags custom constraint
 * The concept is to allow use of specifics HTML tags (for text format for exemple)
 *
 * @package AppBundle\Validator\Constraints
 */
class AllowedTagsValidator extends ConstraintValidator
{
    /**
     * Execute a test with AllowedTags contraint on given string
     *
     * @param mixed $value           : Value waiting validation
     * @param Constraint $constraint : Contraint used for value validation (here AllowedTags)
     */
    public function validate($value, Constraint $constraint)
    {
        if (strlen($value) !== strlen(strip_tags($value, $constraint->allowedTags))) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ allowed_tags }}', $constraint->allowedTags)
                ->addViolation();
        }
    }
}
