<?php
declare(strict_types=1);
namespace App\Infrastructure\Company\Form;

use App\Infrastructure\Company\Form\DataTransformer\CompanyAddressDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CompanyAddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('street', TextType::class, [
            'required' => false,
        ])->add('address', TextType::class,[
            'required' => false,
        ])->add('province', TextType::class, [
            'required' => false,
        ])->add('city', TextType::class, [
            'required' => false,
        ])->add('postal', TextType::class, [
            'required' => false,
        ]);

        $builder->addModelTransformer(new CompanyAddressDataTransformer());
    }
}
