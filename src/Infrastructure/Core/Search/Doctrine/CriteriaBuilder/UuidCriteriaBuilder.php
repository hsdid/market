<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Search\Doctrine\CriteriaBuilder;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\Criteria\UuidCriteria;
use App\Infrastructure\Core\Search\Doctrine\Context;

final class UuidCriteriaBuilder extends BaseCriteriaBuilder
{
    public function build(ContextInterface $context, CriteriaInterface $criteria): void
    {
        if (!$criteria instanceof UuidCriteria) {
            return;
        }

        $parameterName = $this->getUniqueFieldName($criteria);
        $fieldName = $this->getGenericFieldName($criteria);

        if (null === $criteria->getValue()) {
            $context->getQueryBuilder()
                ->andWhere(sprintf('%s.%s IS NULL', Context::DEFAULT_ALIAS, $fieldName));

            return;
        }

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
        return $criteria instanceof UuidCriteria
            && in_array($criteria->getOperator(), [CriteriaInterface::EQUAL]);
    }
}
