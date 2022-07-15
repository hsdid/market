<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Search\Doctrine\CriteriaBuilder;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\Criteria\OrderByCriteria;
use App\Domain\Core\Search\NotSupportedCriteriaOperatorException;
use App\Infrastructure\Core\Search\Doctrine\Context;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;

final class OrderByCriteriaBuilder extends BaseCriteriaBuilder
{
    private const DOCTRINE_RELATION_TYPE = 'type';
    private const ONE_TO_MANY_DOCTRINE_RELATION_TYPE = 2;

    public function build(ContextInterface $context, CriteriaInterface $criteria): void
    {
        if (!$criteria instanceof OrderByCriteria) {
            return;
        }

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $context->getQueryBuilder();
        $fieldName = $this->getGenericFieldName($criteria);
        $entityManager = $queryBuilder->getEntityManager();
        $metadata = $this->getClassMetadata($context);

        if (!$this->isFieldValid($entityManager, $metadata, $fieldName)) {
            throw new NotSupportedCriteriaOperatorException(sprintf('Order by %s is not supported', $fieldName));
        }

        $aliasName = Context::DEFAULT_ALIAS;
//        if ($this->isTranslatableField($entityManager, $metadata, $fieldName)) {
//            $aliasName = $this->getUniqueFieldName($criteria, 'trans');
//            $queryBuilder
//                ->join(sprintf('%s.translations', Context::DEFAULT_ALIAS), $aliasName)
//                ->andWhere(sprintf('%s.locale = :locale', $aliasName))
//                ->setParameter('locale', $criteria->getLocale());
//        }

        if ($this->isDiscriminatorField($metadata, $fieldName)) {
            $queryBuilder->addOrderBy(
                sprintf('TYPE(%s)',
                    $aliasName,
                ),
                $criteria->getOperator()
            );

            return;
        }

        $queryBuilder->addOrderBy(
            sprintf('%s.%s',
                $aliasName,
                $this->getGenericFieldName($criteria)
            ),
            $criteria->getOperator()
        );
    }

    public function allows(CriteriaInterface $criteria): bool
    {
        return $criteria instanceof OrderByCriteria;
    }

    protected function isFieldValid(EntityManagerInterface $entityManager, ClassMetadata $metadata, string $fieldName): bool
    {
        $fieldNames = $metadata->getFieldNames();

        if (in_array($fieldName, $fieldNames) && false === strpos($metadata->getTypeOfField($fieldName), 'json_array')) {
            return true;
        }

        if ($this->isTranslatableField($entityManager, $metadata, $fieldName)) {
            return true;
        }

        if ($this->isAssociatedField($metadata, $fieldName)) {
            return true;
        }

        if ($this->isDiscriminatorField($metadata, $fieldName)) {
            return true;
        }

        return false;
    }

    protected function isAssociatedField(ClassMetadata $metadata, string $fieldName): bool
    {
        $mappings = $metadata->getAssociationMappings();

        if (!array_key_exists($fieldName, $mappings)) {
            return false;
        }

        $mapping = $mappings[$fieldName];

        return self::ONE_TO_MANY_DOCTRINE_RELATION_TYPE === $mapping[self::DOCTRINE_RELATION_TYPE];
    }

    protected function isDiscriminatorField(ClassMetadata $metadata, string $fieldName): bool
    {
        return isset($metadata->discriminatorColumn['name']) && $metadata->discriminatorColumn['name'] === $fieldName;
    }

    protected function isTranslatableField(EntityManagerInterface $entityManager, ClassMetadata $metadata, string $fieldName): bool
    {
        $fieldNames = [];
        $mappings = $metadata->getAssociationMappings();

        if (array_key_exists('translations', $mappings)) {
            $transMetadata = $entityManager->getClassMetadata($mappings['translations']['targetEntity']);
            $fieldNames = array_diff($transMetadata->getFieldNames(), ['locale', 'id']);
        }

        return in_array($fieldName, $fieldNames);
    }
}
