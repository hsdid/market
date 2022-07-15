<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Search\Doctrine\CriteriaBuilder;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\Criteria\BooleanCriteria;
use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Infrastructure\Core\Search\Doctrine\Context;

final class BooleanCriteriaBuilder extends BaseCriteriaBuilder
{
    public function build(ContextInterface $context, CriteriaInterface $criteria): void
    {
        if (!$criteria instanceof BooleanCriteria) {
            return;
        }

        $parameterName = $this->getUniqueFieldName($criteria);
        $fieldName = $this->getGenericFieldName($criteria);

        $context->getQueryBuilder()
            ->andWhere(sprintf('%s.%s = :%s',
                Context::DEFAULT_ALIAS,
                $fieldName,
                $parameterName
            ))
            ->setParameter($parameterName, $criteria->getValue());
    }

    public function allows(CriteriaInterface $criteria): bool
    {
        return $criteria instanceof BooleanCriteria
            && in_array($criteria->getOperator(), [CriteriaInterface::EQUAL])
            && null !== $criteria->getValue();
    }
}
