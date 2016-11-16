<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Config\Definition\Exception\Exception;


class AuthenticationSuccessListener
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        //TODO use serializer
        /*
         * $serializer = $container->get('jms_serializer');
         * $serializer->serialize($data, $format);
         */
        $data['data'] = array(
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'roles' => $user->getRoles(),
        );

        $event->setData($data);
    }
}