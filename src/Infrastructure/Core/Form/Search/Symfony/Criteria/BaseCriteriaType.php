<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Form\Search\Symfony\Criteria;

use App\Domain\Core\Search\Criteria\CriteriaInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseCriteriaType extends CollectionType
{
    abstract protected function transformToCriteria(string $name, string $operator, $value, array $formOptions): CriteriaInterface;

    abstract protected function getFieldType(): string;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(new CallbackTransformer(
            function ($value) {
                return $value;
            },
            function (array $conditions) use ($builder, $options): array {
                $criteria = [];
                foreach ($conditions as $operator => $value) {
                    $operator = is_int($operator) ? $options['default_operator'] : $operator;

                    if (is_array($options['allowed_operators']) && !in_array($operator, $options['allowed_operators'])) {
                        throw new TransformationFailedException('', 0, null, sprintf('Criteria operator %s[%s] is not allowed', $builder->getName(), $operator));
                    }

                    $fieldName = $options['field_name'] ?? $builder->getName();
                    $criteria[] = $this->transformToCriteria(
                        $fieldName,
                        $operator,
                        true == $options['to_lower'] && null !== $value ? mb_strtolower($value) : $value,
                        $options
                    );
                }

                return $criteria;
            }
        ));
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'entry_type' => $this->getFieldType(),
            'default_operator' => CriteriaInterface::EQUAL,
            'allowed_operators' => null,
            'field_name' => null,
            'to_lower' => false,
            'allow_add' => true,
            'allow_delete' => true,
            'error_bubbling' => false,
        ]);
    }
}
