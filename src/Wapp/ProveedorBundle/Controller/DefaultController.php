<?php

namespace Wapp\ProveedorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WappProveedorBundle:Default:index.html.twig');
    }
	public function loginAction()
    {        		
		return $this->render('WappProveedorBundle:Default:login.html.twig');
    }
	public function logoutAction()
    {
        return $this->render('WappProveedorBundle:Default:login.html.twig');
    }
}
