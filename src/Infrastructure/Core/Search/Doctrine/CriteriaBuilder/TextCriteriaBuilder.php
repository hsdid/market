<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Search\Doctrine\CriteriaBuilder;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\Criteria\TextCriteria;
use App\Infrastructure\Core\Search\Doctrine\Context;

final class TextCriteriaBuilder extends BaseCriteriaBuilder
{
    public function build(ContextInterface $context, CriteriaInterface $criteria): void
    {
        if (!$criteria instanceof TextCriteria) {
            return;
        }

        $queryBuilder = $context->getQueryBuilder();
        $parameterName = $this->getUniqueFieldName($criteria);
        $fieldName = $this->getGenericFieldName($criteria);

        if (null === $criteria->getValue()) {
            $context->getQueryBuilder()
                ->andWhere(sprintf('%s.%s IS NULL', Context::DEFAULT_ALIAS, $fieldName));

            return;
        }

        if (CriteriaInterface::EQUAL === $criteria->getOperator()) {
            $context->getQueryBuilder()
                ->andWhere(sprintf('LOWER(%s.%s) = LOWER(:%s)',
                    Context::DEFAULT_ALIAS,
                    $fieldName,
                    $parameterName
                ))
                ->setParameter($parameterName, $criteria->getValue());

            return;
        }

        if (CriteriaInterface::LIKE === $criteria->getOperator()) {
            $context->getQueryBuilder()
                ->andWhere($queryBuilder->expr()->like(
                    sprintf('LOWER(%s.%s)',
                        Context::DEFAULT_ALIAS,
                        $fieldName
                    ),
                    sprintf('LOWER(:%s)', $parameterName)
                ))
                ->setParameter($parameterName, sprintf('%%%s%%', $criteria->getValue()));

            return;
        }
    }

    public function allows(CriteriaInterface $criteria): bool
    {
        return $criteria instanceof TextCriteria
            && in_array($criteria->getOperator(), [CriteriaInterface::EQUAL, CriteriaInterface::LIKE]);
    }
}
