<?php
declare(strict_types=1);

namespace App\Domain\Core\Search;

use App\Domain\Core\Search\Context\ContextInterface;

class ContextContextQueryBuilder implements ContextQueryBuilderInterface
{
    protected CriteriaBuilderProviderInterface $criteriaBuilderProvider;

    public function __construct(CriteriaBuilderProviderInterface $criteriaBuilderProvider)
    {
        $this->criteriaBuilderProvider = $criteriaBuilderProvider;
    }

    public function buildQuery(ContextInterface $context, CriteriaCollectionInterface $criteriaCollection): void
    {
        foreach ($criteriaCollection as $criteria) {
            $exclude = $context->getParam(ContextInterface::EXCLUDE_PARAM);
            if (null !== $exclude && in_array(get_class($criteria), $exclude)) {
                continue;
            }

            $criteriaMatched = false;
            foreach ($this->criteriaBuilderProvider->getCriteriaBuilders($context) as $builder) {
                if ($builder->allows($criteria)) {
                    $builder->build($context, $criteria);
                    $criteriaMatched = true;
                }
            }

            if (!$criteriaMatched) {
                throw new NotSupportedCriteriaOperatorException(sprintf('Criteria %s[%s] is not supported', $criteria->getName(), $criteria->getOperator()));
            }
        }
    }
}
