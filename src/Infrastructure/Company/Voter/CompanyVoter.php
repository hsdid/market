<?php
declare(strict_types=1);
namespace App\Infrastructure\Company\Voter;

use App\Domain\Company\Company;
use App\Domain\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CompanyVoter extends Voter
{
    const EDIT = 'edit';

    protected function supports(string $attribute, $subject)
    {
        if ($attribute != self::EDIT) {
            return false;
        }

        if (!$subject instanceof Company) {
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

        $company = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($company, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Company $company, UserInterface $user): bool
    {
        return (string)($user->getId()) === (string)$company->getUser()->getId();
    }
}