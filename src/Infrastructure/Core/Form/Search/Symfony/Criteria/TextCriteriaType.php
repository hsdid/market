<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Form\Search\Symfony\Criteria;

use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\Criteria\TextCriteria;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class TextCriteriaType extends BaseCriteriaType
{
    protected function transformToCriteria(string $name, string $operator, $value, array $formOptions): CriteriaInterface
    {
        return new TextCriteria($name, $operator, $value);
    }

    protected function getFieldType(): string
    {
        return TextType::class;
    }
}