<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\Form\Search\Symfony;

use App\Domain\Core\Search\Criteria\OrderByCriteria;
use App\Domain\Core\Search\Criteria\PaginationCriteria;
use App\Domain\Core\Search\CriteriaCollection\CriteriaCollection;
use App\Domain\Core\Search\CriteriaCollectionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class SearchType extends AbstractType
{
    private const DEFAULT_ITEMS_ON_PAGE = 15;
    private const ITEMS_ON_PAGE_LIMIT = 10000;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('_page', IntegerType::class, [
                'constraints' => [
                    new Range(['min' => 1]),
                ],
            ])
            ->add('_itemsOnPage', IntegerType::class, [
                'constraints' => [
                    new Range(['min' => 1, 'max' => self::ITEMS_ON_PAGE_LIMIT]),
                ],
            ])
            ->add('_orderBy', CollectionType::class, [
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'choices' => [
                        OrderByCriteria::DESC,
                        OrderByCriteria::ASC,
                    ],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
            ])
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                [$this, 'onPreSubmit']
            );

        $builder->addModelTransformer(new CallbackTransformer(
            function ($value) {
                return $value;
            },
            function (array $data) use ($options): CriteriaCollectionInterface {
                $criteriaItems = new CriteriaCollection();

                $fieldMappings = $options['field_mappings'];

                foreach ($data['_orderBy'] as $fieldName => $direction) {
                    if (array_key_exists($fieldName, $fieldMappings)) {
                        $fieldName = $fieldMappings[$fieldName];
                    }

                    $criteriaItems->add(new OrderByCriteria(
                        $fieldName,
                        $direction ?? OrderByCriteria::DESC
                    ));
                }

                if ($options['with_pagination']) {
                    $criteriaItems->add(new PaginationCriteria(
                        $data['_page'] ?? 1,
                        $data['_itemsOnPage'] ?? self::DEFAULT_ITEMS_ON_PAGE
                    ));
                }

                foreach (['_itemsOnPage', '_page', '_orderBy'] as $key) {
                    unset($data[$key]);
                }

                foreach ($data as $field) {
                    foreach ($field as $criteria) {
                        $criteriaItems->add($criteria);
                    }
                }

                return $criteriaItems;
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'field_mappings' => [],
            'with_pagination' => true,
        ]);
    }

    /**
     * Event converts simple criteria (without []) to supported by this form.
     * "name=test" is the same like "name[eq]=test".
     */
    public function onPreSubmit(PreSubmitEvent $event): void
    {
        $data = $event->getData();

        foreach ($data as $fieldName => $fieldValue) {
            // skip special fields
            if (str_starts_with($fieldName, '_')) {
                continue;
            }
            if (!is_array($fieldValue)) {
                $data[$fieldName] = [
                    $fieldValue,
                ];
            }
        }

        $event->setData($data);
    }
}
