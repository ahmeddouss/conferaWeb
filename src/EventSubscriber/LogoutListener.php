<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LogoutListener implements EventSubscriberInterface
{
    private UrlGeneratorInterface $urlGenerator;
    private TokenStorageInterface $tokenStorage;
    private RequestStack $requestStack;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        TokenStorageInterface $tokenStorage,
        RequestStack $requestStack
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => 'onLogoutSuccess',
        ];
    }

    public function onLogoutSuccess(LogoutEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->tokenStorage->getToken()->getUser();

        dump($user); // Add this line for debugging

        if ($user) {
            $userRoles = $user->getRoles();

            dump($userRoles); // Add this line for debugging

            // If the user has 'ROLE_ADMIN' role, redirect to 'app_adminlogin'
            if (in_array('ROLE_ADMIN', $userRoles, true)) {
                $response = new RedirectResponse($this->urlGenerator->generate('app_adminlogin'));
                $event->setResponse($response);
            }
        } else {
            // For other roles, or if the user is not authenticated, redirect to the default path
            $response = new RedirectResponse($this->urlGenerator->generate('home'));
            $event->setResponse($response);
        }
    }
}
