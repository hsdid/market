<?php
declare(strict_types=1);

namespace App\Domain\Core\Model;

interface Identifier
{
    public function __toString();
}