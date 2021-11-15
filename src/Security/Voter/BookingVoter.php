<?php

namespace App\Security\Voter;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class BookingVoter extends Voter
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['show', 'edit', 'delete'])
            && $subject instanceof \App\Entity\Booking;
    }

    protected function voteOnAttribute(string $attribute, $booking, TokenInterface $token): bool
    {
        $userid = $token->getUser()->getUserIdentifier();
        $user = $this->userRepository->find($userid);
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'show':
                return $booking->getUser()==$user;
                break;
            case 'edit':
                return $booking->getUser()==$user;
                break;
            case 'delete':
                return $booking->getUser()==$user;   
                break;
        }
        return false;
    }
}
