<?php
declare(strict_types=1);

namespace App\Infrastructure\Offer\Form\Type;

use App\Infrastructure\Offer\Validator\Constraints\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class OfferFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'constraints' => [
                new NotBlank(),
            ],
        ]);
        $builder->add('description', TextType::class, [
            'constraints' => [
                new NotBlank(),
            ],
        ]);
        $builder->add('companyId', TextType::class, [
            'constraints' => [
                new Uuid(),
                new Company(),
            ],
        ]);
        $builder->add('address', OfferAddressFormType::class, [
            'required' => false,
        ]);

        $this->addPriceRange($builder);

        //zwraca 1 dla true, i pusty string dla false
        $builder->add('active', CheckboxType::class, [
        ]);

        parent::buildForm($builder, $options);
    }

    private function addPriceRange(FormBuilderInterface $builder): void
    {
        $builder->add('price', FormType::class, [
        ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                if (!array_key_exists('price', $data)) {
                    return;
                }

                $form->get('price')
                    ->add(
                        'minPrice',
                        NumberType::class, [
                        ]
                    )
                    ->add(
                        'maxPrice',
                        NumberType::class, [
                        ]
                    );

            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
