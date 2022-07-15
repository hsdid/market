<?php
declare(strict_types=1);
namespace App\Infrastructure\Offer\Voter;

use App\Domain\Core\Id\UserId;
use App\Domain\Offer\Offer;
use App\Domain\User\UserInterface;
use App\Infrastructure\User\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class OfferVoter extends Voter
{
    const EDIT = 'edit';

    protected function supports(string $attribute, $subject): bool
    {
        if ($attribute != self::EDIT) {
            return false;
        }

        if (!$subject instanceof Offer) {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        $offer = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($offer, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Offer $offer, UserInterface $user): bool
    {
        return (string)($user->getId()) === (string)$offer->getUserId();
    }
}
