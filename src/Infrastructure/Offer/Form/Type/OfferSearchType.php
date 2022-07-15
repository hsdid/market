<?php
declare(strict_types=1);

namespace App\Infrastructure\Offer\Form\Type;

use App\Infrastructure\Core\Form\Search\Symfony\Criteria\BooleanCriteriaType;
use App\Infrastructure\Core\Form\Search\Symfony\Criteria\DateTimeCriteriaType;
use App\Infrastructure\Core\Form\Search\Symfony\Criteria\NumericCriteriaType;
use App\Infrastructure\Core\Form\Search\Symfony\Criteria\TextCriteriaType;
use App\Infrastructure\Core\Form\Search\Symfony\Criteria\UuidCriteriaType;
use App\Infrastructure\Core\Form\Search\Symfony\SearchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class OfferSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('offerId', UuidCriteriaType::class);
        $builder->add('userId', UuidCriteriaType::class);
        $builder->add('title', TextCriteriaType::class);
        $builder->add('description', TextCriteriaType::class);
        $builder->add('companyId', UuidCriteriaType::class);
        $builder->add('address:street', TextCriteriaType::class);
        $builder->add('address:address', TextCriteriaType::class);
        $builder->add('address:province', TextCriteriaType::class);
        $builder->add('address:city', TextCriteriaType::class);
        $builder->add('address:postal', TextCriteriaType::class);
        $builder->add('address:country', TextCriteriaType::class);
        $builder->add('active', BooleanCriteriaType::class);
        $builder->add('price:minPrice', NumericCriteriaType::class);
        $builder->add('price:maxPrice', NumericCriteriaType::class);
        $builder->add('createdAt', DateTimeCriteriaType::class);
    }

    public function getParent(): string
    {
        return SearchType::class;
    }
}
