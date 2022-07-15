<?php

namespace App\Infrastructure\Offer\Validator\Constraints;

use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\Core\Id\CompanyId;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CompanyValidator extends ConstraintValidator
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }
        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $entity = $this->companyRepository->getById(new CompanyId($value));

        if ($entity instanceof \App\Domain\Company\Company) {
            return;
        }
        $this->context->buildViolation('Company dont exist')->addViolation();
    }
}
