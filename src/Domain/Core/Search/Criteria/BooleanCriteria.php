<?php
declare(strict_types=1);

namespace App\Domain\Core\Search\Criteria;

class BooleanCriteria extends AbstractCriteria
{
    /**
     * @var bool|null
     */
    protected $value;

    public function __construct(string $name, string $operator, ?bool $value)
    {
        parent::__construct($name, $operator);

        $this->value = $value;
    }

    public function getValue(): ?bool
    {
        return $this->value;
    }
}
