<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Form\Search\Symfony\Criteria;

use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\Criteria\NumericCriteria;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

final class NumericCriteriaType extends BaseCriteriaType
{
    protected function transformToCriteria(string $name, string $operator, $value, array $formOptions): CriteriaInterface
    {
        return new NumericCriteria($name, $operator, $value);
    }

    protected function getFieldType(): string
    {
        return NumberType::class;
    }
}
