<?php
declare(strict_types=1);

namespace App\Infrastructure\Company\Form;

use App\Infrastructure\Company\Validator\Constraints\CompanyName;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CompanyFromType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new CompanyName(),
            ],
        ]);
        $builder->add('description', TextType::class, [
            'constraints' => [
                new NotBlank(),
            ],
        ]);
        $builder->add('address', CompanyAddressFormType::class, [
            'required' => false,
        ]);
        $builder->add('active', CheckboxType::class, [
            'constraints' => [
                new NotBlank(),
            ],
        ]);
        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
