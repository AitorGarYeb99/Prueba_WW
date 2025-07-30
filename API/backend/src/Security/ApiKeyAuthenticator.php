<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        // Aplica el autenticador sólo a rutas de la API
        return str_starts_with($request->getPathInfo(), '/api');
    }

    public function authenticate(Request $request): Passport
    {
        $apiKey = $request->headers->get('X-API-KEY');


        if (!$apiKey || $apiKey !== '12345') {
            throw new AuthenticationException('Invalid API Key');
        }

        // UserBadge identifica al usuario, devolviendo uno en memoria con ROLE_USER
        $userBadge = new UserBadge('api-key-user', function (string $identifier) {
            return new InMemoryUser($identifier, null, ['ROLE_USER']);
        });
        return new SelfValidatingPassport($userBadge);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?JsonResponse
    {
        return new JsonResponse(['error' => 'Unauthorized'], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?JsonResponse
    {
        // Si la autenticación es correcta, continúa la ejecución normal
        return null;
    }
}
