<?php
declare(strict_types=1);
namespace App\Infrastructure\Core\Form\Search\Symfony\Criteria;

use App\Domain\Core\Search\Criteria\BooleanCriteria;
use App\Domain\Core\Search\Criteria\CriteriaInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

final class BooleanCriteriaType extends BaseCriteriaType
{

    protected function transformToCriteria(string $name, string $operator, $value, array $formOptions): CriteriaInterface
    {
        return new BooleanCriteria($name, $operator, $value);
    }

    protected function getFieldType(): string
    {
        return CheckboxType::class;
    }
}
