<?php
namespace Wapp\ProveedorBundle\Listener;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Wapp\ProveedorBundle\Entity\AuthProveedor;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Custom authentication success handler
 */
class LoginListener implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface, LogoutSuccessHandlerInterface {
    private $container;
    private $em;
    /**
     * Constructor
     * @param container   $container
     */
    public function __construct($container){
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }
    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from AbstractAuthenticationListener.
     * @param Request        $request
     * @param TokenInterface $token
     * @return Response The response to return
     */
    function onAuthenticationSuccess(Request $request, TokenInterface $token){
        
        $uri = $this->container->get('router')->generate('estadocuenta_index');
        return new RedirectResponse($uri);
    }

    /**
     * This is called when an interactive authentication attempt fails. This is
     * called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return Response The response to return, never null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception){

		$usuario = $request->request->get('_username');		
        /*$log = $this->container->get('Util');
        $log->auditoriaLoginFailure('(PRPROV4) Intento de inicio de sesión fallido', $usuario);*/
        $referer = $request->headers->get('referer');		
        $request->getSession()->getFlashBag()->add('error', $exception->getMessage());        
		return new RedirectResponse('login?error=1');
    }

    /**
     * Creates a Response object to send upon a successful logout.
     *
     * @param Request $request
     *
     * @return Response never null
     */
    public function onLogoutSuccess(Request $request)
    {
        if ($this->container->get('security.context')->getToken())
        {
            $usuario = $this->container->get('security.context')->getToken()->getUser();
            /*$log = $this->container->get('Util');
            $log->registralog('(PRPROV2) Sesión de usuario cerrada', $usuario->getId());*/
        }

        $uri = $this->container->get('router')->generate('default_login');
        $response = new RedirectResponse($uri);
        return $response;
    }

}
