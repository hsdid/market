<?php

namespace App\Domain\Core\Search\Criteria;

abstract class AbstractCriteria implements CriteriaInterface
{
    protected string $name;
    protected string $operator;
    /**
     * @var mixed
     */
    protected $value;

    public function __construct(string $name, string $operator)
    {
        $this->name = $name;
        $this->operator = $operator;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }
}
