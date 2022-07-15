<?php
declare(strict_types=1);

namespace App\Domain\Core\Search\Criteria;

use DateTime;

class DateTimeCriteria extends AbstractCriteria
{
    /**
     * @var DateTime|null
     */
    protected $value;

    public function __construct(string $name, string $operator, ?DateTime $value)
    {
        parent::__construct($name, $operator);

        $this->value = $value;
    }

    public function getValue(): ?DateTime
    {
        return $this->value;
    }
}
