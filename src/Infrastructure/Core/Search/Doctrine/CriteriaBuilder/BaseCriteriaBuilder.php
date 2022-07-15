<?php

namespace App\Infrastructure\Core\Search\Doctrine\CriteriaBuilder;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\CriteriaBuilder\CriteriaBuilderInterface;
use App\Infrastructure\Core\Search\Doctrine\Context;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class BaseCriteriaBuilder implements CriteriaBuilderInterface
{
    protected function getUniqueFieldName(CriteriaInterface $criteria, string $alias = ''): string
    {
        $name = $this->getGenericFieldName($criteria);
        $name = str_replace('.', '', $name);

        return sprintf(
            '%s%s_%s',
            empty($alias) ? '' : ($alias.'_'),
            $name,
            spl_object_id($criteria)
        );
    }

    protected function getUniqueAliasName(CriteriaInterface $criteria, string $alias = ''): string
    {
        return sprintf(
            '%s%s',
            empty($alias) ? '' : ($alias.'_'),
            spl_object_id($criteria)
        );
    }

    protected function getGenericFieldName(CriteriaInterface $criteria): string
    {
        return str_replace(':', '.', $criteria->getName());
    }

    protected function getClassMetadata(ContextInterface $context): ClassMetadata
    {
        $queryBuilder = $context->getQueryBuilder();
        $entityManager = $queryBuilder->getEntityManager();
        $class = $context->getParam(Context::CLASS_PARAM);

        if (null === $class) {
            throw new \LogicException(sprintf('Context parameter %s is not defined', Context::CLASS_PARAM));
        }

        return $entityManager->getClassMetadata($class);
    }
}
