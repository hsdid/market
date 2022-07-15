<?php
declare(strict_types=1);

namespace App\Infrastructure\Offer\Form\Type;

use Symfony\Component\Form\AbstractType;

class EditOfferFormType extends AbstractType
{
    public function getParent(): string
    {
        return OfferFormType::class;
    }
}
