<?php
declare(strict_types=1);

namespace App\Domain\Core\Search\Criteria;

class NumericCriteria extends AbstractCriteria
{
    /**
     * @var float|null
     */
    protected $value;

    public function __construct(string $name, string $operator, ?float $value)
    {
        parent::__construct($name, $operator);

        $this->value = $value;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }
}
