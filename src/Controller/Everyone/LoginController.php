<?php

namespace App\Controller\Everyone;

use App\Message\Event\LoggedInEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class LoginController
{
    /**
     * @Route("/login", name="login")
     */
    public function __invoke(
        Request $request,
        Environment $twig,
        AuthenticationUtils $authenticationUtils,
        TokenStorageInterface $tokenStorage,
        UrlGeneratorInterface $urlGenerator,
        MessageBusInterface $eventBus
    ): Response {
        if ($tokenStorage->getToken()->getUser() instanceof User) {
            $eventBus->dispatch(new LoggedInEvent());

            return new RedirectResponse($urlGenerator->generate('vettige_vrijdag'));
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        return new Response($twig->render('login/login.html.twig', [
                'error' => $error
            ]));
    }
}
