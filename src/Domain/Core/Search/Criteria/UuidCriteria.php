<?php
declare(strict_types=1);

namespace App\Domain\Core\Search\Criteria;

use App\Domain\Core\Model\Identifier;
use Symfony\Component\Uid\Uuid;

class UuidCriteria extends AbstractCriteria
{
    /**
     * @var Uuid|null
     */
    protected $value;

    public function __construct(string $name, string $operator, ?Uuid $value)
    {
        parent::__construct($name, $operator);

        $this->value = $value;
    }

    public function getValue(): ?Uuid
    {
        return $this->value;
    }

    public static function fromIdentifier(string $name, string $operator, Identifier $identifier): UuidCriteria
    {
        $value = Uuid::fromString((string) $identifier);

        return new UuidCriteria($name, $operator, $value);
    }
}
