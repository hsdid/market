<?php

namespace App\Infrastructure\Company\Validator\Constraints;

use App\Domain\Company\Company;
use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\Core\Id\CompanyId;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CompanyNameValidator extends ConstraintValidator
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
        $entity = $this->companyRepository->getByName($value);
        if (!$entity instanceof Company) {
            return;
        }

        $this->context->buildViolation('Company with this name already exist')->addViolation();
    }
}
