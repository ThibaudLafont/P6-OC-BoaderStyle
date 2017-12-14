<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AllowedTagsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (strlen($value) !== strlen(strip_tags($value, $constraint->allowedTags))) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ allowed_tags }}', $constraint->allowedTags)
                ->addViolation();
        }
    }
}
