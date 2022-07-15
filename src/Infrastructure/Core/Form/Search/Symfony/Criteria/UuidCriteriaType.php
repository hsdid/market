<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\Form\Search\Symfony\Criteria;

use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\Criteria\UuidCriteria;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Uid\Uuid;

final class UuidCriteriaType extends BaseCriteriaType
{

    protected function transformToCriteria(string $name, string $operator, $value, array $formOptions): CriteriaInterface
    {
        if (null === $value) {
            return new UuidCriteria($name, $operator, null);
        }

        $uuid = Uuid::fromString($value);

        return new UuidCriteria($name, $operator, $uuid);
    }

    protected function getFieldType(): string
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'entry_options' => [
                'constraints' => [new \Symfony\Component\Validator\Constraints\Uuid()],
            ],
        ]);
    }
}
