<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Search\Doctrine\CriteriaBuilder;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\Criteria\DateTimeCriteria;
use App\Infrastructure\Core\Search\Doctrine\Context;

class DateTimeCriteriaBuilder extends BaseCriteriaBuilder
{

    public function build(ContextInterface $context, CriteriaInterface $criteria): void
    {
        if (!$criteria instanceof DateTimeCriteria) {
            return;
        }

        $parameterName = $this->getUniqueFieldName($criteria);
        $contextBuilder = $context->getQueryBuilder();

        $fieldName = sprintf('%s.%s',
            Context::DEFAULT_ALIAS,
            $this->getGenericFieldName($criteria)
        );
        $value = sprintf(':%s',
            $parameterName
        );

        if (null === $criteria->getValue()) {
            $context->getQueryBuilder()
                ->andWhere(sprintf('%s IS NULL', $fieldName));

            return;
        }

        $expression = null;
        switch ($criteria->getOperator()) {
            case CriteriaInterface::EQUAL:
                $expression = $contextBuilder->expr()->eq($fieldName, $value);
                break;
            case CriteriaInterface::LESS_THAN:
                $expression = $contextBuilder->expr()->lt($fieldName, $value);
                break;
            case CriteriaInterface::LESS_THAN_EQUAL:
                $expression = $contextBuilder->expr()->lte($fieldName, $value);
                break;
            case CriteriaInterface::GREATER_THAN:
                $expression = $contextBuilder->expr()->gt($fieldName, $value);
                break;
            case CriteriaInterface::GREATER_THAN_EQUAL:
                $expression = $contextBuilder->expr()->gte($fieldName, $value);
                break;
        }

        $context->getQueryBuilder()
            ->andWhere($expression)
            ->setParameter($parameterName, $criteria->getValue());
    }

    public function allows(CriteriaInterface $criteria): bool
    {
        return $criteria instanceof DateTimeCriteria
            && in_array($criteria->getOperator(), [CriteriaInterface::EQUAL, CriteriaInterface::GREATER_THAN,
                CriteriaInterface::GREATER_THAN_EQUAL, CriteriaInterface::LESS_THAN, CriteriaInterface::LESS_THAN_EQUAL, ]);
    }
}
