<?php
declare(strict_types=1);

namespace App\Domain\Core\Search\Criteria;

interface CriteriaInterface
{
    public const DEFAULT = 'default';
    public const HAS_VALUE = 'hasValue';
    public const NOT_HAS_VALUE = 'notHasValue';
    public const EQUAL = 'eq';
    public const LESS_THAN = 'lt';
    public const LESS_THAN_EQUAL = 'lte';
    public const GREATER_THAN = 'gt';
    public const GREATER_THAN_EQUAL = 'gte';
    public const LIKE = 'like';
    public const IS_TYPE = 'isType';
    public const IN = 'in';

    public function getName(): string;

    public function getOperator(): string;
}
