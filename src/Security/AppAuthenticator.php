<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;//ca redirect les utilisateurs au page apres log in 

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->getPayload()->getString('username');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $username);

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')),
                new RememberMeBadge(),//keeps you logged in if cheking remember me kifech?
                //taamel log in tsir l creeation mtaa session f serveur seveur yabaath coockie l nav mtaa session edhika w yabaath cookie okhra tabka stored for weeks f nav 
                //donc kol ma todkhel ykhalik logged in l cookie hedhi expires waktli session toufa,fel cas normal session
            ]   // toufa kif tsaker e nav wala baed chway wakt.If the session expires later, but the REMEMBERME cookie is still valid, Symfony uses it to recreate the session.
        );
    }
    //After logging in, Symfony stores your authentication in the session:
    //Then it uses the session ID (PHPSESSID) to find this session on each new request — so you stay logged in.
    //donc baed kol visit ll site server yaamle session lik enti w yabaath cookie l nav feha l'id mtaa session mteik bch kif 
    //tloadi page okhra tabka logged in.


    //hedhi execute apres log in w taamel feha l config mtaa l page li theb l utilisateur yemchilha par defaut 
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        /*if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }*/

        // For example:
        // return new RedirectResponse($this->urlGenerator->generate('some_route'));
        return new RedirectResponse($this->urlGenerator->generate('admin.category.index'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
