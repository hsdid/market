<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Form\Search\Symfony\Criteria;

use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\Criteria\DateTimeCriteria;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DateTimeCriteriaType extends BaseCriteriaType
{
    protected function transformToCriteria(string $name, string $operator, $value, array $formOptions): CriteriaInterface
    {
        return new DateTimeCriteria($name, $operator, $value);
    }

    protected function getFieldType(): string
    {
        return DateTimeType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'entry_options' => [
                'widget' => 'single_text',
                'format' => DateTimeType::HTML5_FORMAT,
            ],
        ]);
    }
}