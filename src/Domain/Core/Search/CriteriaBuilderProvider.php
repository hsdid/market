<?php

declare(strict_types=1);

namespace App\Domain\Core\Search;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\CriteriaBuilder\CriteriaBuilderInterface;

class CriteriaBuilderProvider implements CriteriaBuilderProviderInterface
{
    /**
     * @var CriteriaBuilderInterface[]
     */
    protected array $contextCriteriaBuilders = [];

    public function addCriteriaBuilder(string $context, CriteriaBuilderInterface $criteriaBuilder): void
    {
        $this->contextCriteriaBuilders[] = [$context, $criteriaBuilder];
    }

    /**
     * @return CriteriaBuilderInterface[]
     */
    public function getCriteriaBuilders(ContextInterface $context): array
    {

        $contextBuilders = array_filter($this->contextCriteriaBuilders, function (array $item) use ($context): bool {
            list($contextBuilder) = $item;

            return 0 === strpos(
                    $context->getName().ContextInterface::CONTEXT_SEPARATOR,
                    $contextBuilder.ContextInterface::CONTEXT_SEPARATOR
                );
        });

        if (0 === count($contextBuilders)) {
            throw new \InvalidArgumentException('Given context does not have any criteria builders');
        }

        return array_map(function (array $item): CriteriaBuilderInterface {
            list(, $builder) = $item;

            return $builder;
        },
            $contextBuilders
        );
    }
}