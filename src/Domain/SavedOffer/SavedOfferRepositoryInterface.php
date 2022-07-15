<?php

namespace App\Domain\SavedOffer;

interface SavedOfferRepositoryInterface
{
    public function save(SavedOffer $savedOffer): void;
    public function getById(OfferId $id): ?SavedOffer;
}