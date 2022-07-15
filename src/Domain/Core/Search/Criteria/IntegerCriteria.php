<?php
declare(strict_types=1);

namespace App\Domain\Core\Search\Criteria;

class IntegerCriteria extends AbstractCriteria
{
    /**
     * @var int|null
     */
    protected $value;

    public function __construct(string $name, string $operator, ?int $value)
    {
        parent::__construct($name, $operator);

        $this->value = $value;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }
}
