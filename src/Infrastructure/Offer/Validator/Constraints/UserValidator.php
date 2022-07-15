<?php

namespace App\Infrastructure\Offer\Validator\Constraints;

use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UserValidator extends ConstraintValidator
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $entity = $this->userRepository->find($value);

        if ($entity instanceof \App\Infrastructure\User\Entity\User) {
            return;
        }

        $this->context->buildViolation('User dont exist')->addViolation();
    }
}
