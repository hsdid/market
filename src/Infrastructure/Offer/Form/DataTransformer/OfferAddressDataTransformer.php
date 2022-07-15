<?php
declare(strict_types=1);

namespace App\Infrastructure\Offer\Form\DataTransformer;

use App\Domain\Offer\ValueObject\Address;
use Symfony\Component\Form\DataTransformerInterface;

class OfferAddressDataTransformer implements DataTransformerInterface
{
    public function transform($value): ?array
    {
        return $value;
    }

    public function reverseTransform($value): Address
    {
        return new Address(
            $value['province'] ?? null,
            $value['city'] ?? null,
            $value['address'] ?? null,
            $value['street'] ?? null,
            $value['postal'] ?? null
        );
    }
}
