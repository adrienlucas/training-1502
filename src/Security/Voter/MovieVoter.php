<?php

namespace App\Security\Voter;

use App\Entity\Movie;
use Laminas\EventManager\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MovieVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['MOVIE_EDIT', 'MOVIE_DELETE'])
            && $subject instanceof Movie;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface || !$subject instanceof Movie) {
            return false;
        }

        switch ($attribute) {
            case 'MOVIE_EDIT':
                return in_array('ROLE_ADMIN', $user->getRoles())
                 || ($subject->creator->isEqualTo($user));
            case 'MOVIE_DELETE':
                return in_array('ROLE_ADMIN', $user->getRoles());
        }

        return false;
    }
}


//
//$eventDispatcher = new EventDispatcher();
//$eventDispatcher->addListener('order.paid', [new LoggerNotifier(), 'orderPaid']);
//$eventDispatcher->addListener('order.refund', [new LoggerNotifier(), 'orderRefunded']);
//
//class LoggerNotifier
//{
//    public function orderPaid(Event $event)
//    {
//
//    }
//
//    public function orderRefunded(Event $event)
//    {
//
//    }
//}
//
//$eventDispatcher->addSubscriber(new SomethingSubscriber());
//
//class LoggerNotifierSubscriber implements EventSubscriberInterface
//{
//    public function orderPaid(Event $event)
//    {
//
//    }
//
//    public function orderRefunded(Event $event)
//    {
//
//    }
//
//    public static function getSubscribedEvents()
//    {
//        return [
//            'order.paid' => 'orderPaid',
//            'order.refund' => 'orderRefunded',
//        ];
//    }
//}
//
//
//class OrderService
//{
//    private EventDispatcher $eventDispatcher;
//    public function confirmOrder($order)
//    {
//        $order->changeStatus('confirmed');
//        $order->save();
//
//        $this->eventDispatcher->dispatch(new Event($order), 'order.paid');
//    }
//}
