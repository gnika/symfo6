<?php
// src/Security/SiteVoter.php
namespace App\Security;

use App\Entity\Site;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SiteVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';

    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Site) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Site object, thanks to `supports()`
        /** @var Site $site */
        $site = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($site, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Site $site, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($site, $user)) {
            return true;
        }

        // the Post object could have, for example, a method `isPrivate()`
        return false;
    }

    private function canEdit(Site $site, User $user): bool
    {

        // this assumes that the Post object has a `getOwner()` method
        return  $site->getUsers()->contains($user);
    }

}