<?php

namespace Wapp\AdministradorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WappAdministradorBundle:Default:index.html.twig');
    }
    public function loginAction()
    {
        return $this->render('WappAdministradorBundle:Default:login.html.twig');
    }
	public function logoutAction()
    {
        return $this->render('WappAdministradorBundle:Default:login.html.twig');
    }	
}
