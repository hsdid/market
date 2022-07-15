<?php

declare(strict_types=1);

namespace App\Domain\Core\Search\Criteria;

class TextCriteria extends AbstractCriteria
{
    /**
     * @var string|null
     */
    protected $value;

    public function __construct(string $name, string $operator, ?string $value)
    {
        parent::__construct($name, $operator);

        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
