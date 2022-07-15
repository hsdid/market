<?php
declare(strict_types=1);

namespace App\Infrastructure\User\Form\Type;

use App\Infrastructure\Core\Form\Search\Symfony\Criteria\DateTimeCriteriaType;
use App\Infrastructure\Core\Form\Search\Symfony\Criteria\TextCriteriaType;
use App\Infrastructure\Core\Form\Search\Symfony\Criteria\UuidCriteriaType;
use App\Infrastructure\Core\Form\Search\Symfony\SearchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('id', UuidCriteriaType::class);
        $builder->add('email', TextCriteriaType::class);
        $builder->add('firstName', TextCriteriaType::class);
        $builder->add('lastName', TextCriteriaType::class);
        $builder->add('createdAt', DateTimeCriteriaType::class);
    }

    public function getParent(): string
    {
        return SearchType::class;
    }
}
