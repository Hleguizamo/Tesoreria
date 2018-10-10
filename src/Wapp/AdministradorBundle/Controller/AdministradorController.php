<?php

namespace Wapp\AdministradorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


use Wapp\AdministradorBundle\Entity\Administrador;
use Wapp\AdministradorBundle\Form\AdministradorType;

/**
 * Administrador controller.
 *
 */
class AdministradorController extends Controller
{
    /**
     * Lists all Administrador entities.
     * 
     */
    public function indexAction(Request $request)
    {        		
		$data = $request->request->all();
		
		$cantidadPorPagina = isset($data["cantidadPorPagina"]) ? $data["cantidadPorPagina"] : 50;		
		$paginaActual = isset($data["paginaActual"]) ? $data["paginaActual"] : 0;
		$iniciaResultados = $paginaActual * $cantidadPorPagina;
		
		$em = $this->getDoctrine()->getManager();
		$useridObj = $this->get('security.context')->getToken()->getUser('Article', 1);
		$usernit=$useridObj->getId();	
		
		$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');		
		$inicount = $repo_->getQuery()->execute();	
		$total = 0;		
		foreach($inicount as $repoc){ $total ++; }
		
		$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');		
		$repo->setFirstResult($iniciaResultados);
		$repo->setMaxResults($cantidadPorPagina);	
		
		$administradors = $repo->getQuery()->execute();		
        return $this->render('WappAdministradorBundle:administrador:index.html.twig', array(
            'administradors' => $administradors,
			'cantidadPorPagina'=> $cantidadPorPagina,
			'paginaActual' => ($paginaActual + 1),
			'casevar' => 'index',
			'iniciaResultados'=>$iniciaResultados,
			'total'=>$total,
			'data'=>$data,
        ));        
    }
	/**
     * Find EstadoCuenta entities.
     * 
     */
    public function findAction(Request $request)
    {        
		$data = $request->request->all();
		
		$cantidadPorPagina = isset($data["cantidadPorPagina"]) ? $data["cantidadPorPagina"] : 50;		
		$paginaActual = isset($data["paginaActual"]) ? $data["paginaActual"] : 0;
		$iniciaResultados = $paginaActual * $cantidadPorPagina;
		
		$em = $this->getDoctrine()->getManager();
		
		$useridObj = $this->get('security.context')->getToken()->getUser('Article', 1);
		$usernit=$useridObj->getId();

        if($data["searchv"] == ""){
			$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');			
			$inicount = $repo_->getQuery()->execute();	
			$total = 0;
			foreach($inicount as $repoc){ $total ++; }
			
			$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');			
			$repo->setFirstResult($iniciaResultados);
			$repo->setMaxResults($cantidadPorPagina);	
			$administradors = $repo->getQuery()->execute();
		}elseif($data["searchv"] == "advanced"){
			if($data["usuario"] == "" && $data["email"] == "" && $data["nombre"] == ""){
				$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');				
				$inicount = $repo_->getQuery()->execute();	
				$total = 0;
				foreach($inicount as $repoc){ $total ++; }
				
				$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');				
				$repo->setFirstResult($iniciaResultados);
				$repo->setMaxResults($cantidadPorPagina);	
				$administradors = $repo->getQuery()->execute();
			}else{
				$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');				
				$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');				
				if($data["nombre"] != ""){
					$repo->andWhere('e.nombre LIKE :nombre')->setParameter('nombre', '%'.$data["nombre"].'%');
					$repo_->andWhere('e.nombre LIKE :nombre')->setParameter('nombre', '%'.$data["nombre"].'%');
				}
				
				if($data["usuario"] != ""){
					$repo->andWhere('e.usuario LIKE :usuario')->setParameter('usuario', '%'.$data["usuario"].'%');
					$repo_->andWhere('e.usuario LIKE :usuario')->setParameter('usuario', '%'.$data["usuario"].'%');
				}
				
				if($data["email"] != ""){
					$repo->andWhere('e.email LIKE :email')->setParameter('email', '%'.$data["email"].'%');
					$repo_->andWhere('e.email LIKE :email')->setParameter('email', '%'.$data["email"].'%');
				}
				
				$inicount = $repo_->getQuery()->execute();	
				$total = 0;
				foreach($inicount as $repoc){ $total ++; }
				
				$repo->setFirstResult($iniciaResultados);
				$repo->setMaxResults($cantidadPorPagina);					
				$administradors = $repo->getQuery()->execute();				
			}	
		}else{			
			$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');			
			$repo_->andWhere('e.usuario LIKE :usuario')->setParameter('usuario', '%'.$data["searchv"].'%');
			$inicount = $repo_->getQuery()->execute();	
			$total = 0;
			foreach($inicount as $repoc){ $total ++; }
			
			$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Administrador')->createQueryBuilder('e');			
			$repo->andWhere('e.usuario LIKE :usuario')->setParameter('usuario', '%'.$data["searchv"].'%');
			$repo->setFirstResult($iniciaResultados);
			$repo->setMaxResults($cantidadPorPagina);	
			$administradors = $repo->getQuery()->execute();
		}
		
        return $this->render('WappAdministradorBundle:administrador:index.html.twig', array(
            'administradors' => $administradors,
			'cantidadPorPagina'=> $cantidadPorPagina,
			'paginaActual' => ($paginaActual + 1),
			'casevar' => 'index',
			'iniciaResultados'=>$iniciaResultados,
			'total'=>$total,
			'data'=>$data,
        ));   
    }	

    /**
     * Creates a new Administrador entity.
     *
     */
    public function newAction(Request $request)
    {
        $administrador = new Administrador();
        $form = $this->createForm(new AdministradorType(), $administrador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($administrador);
            $em->flush();
			$this->addFlash('success', 'Administrador creado correctamente');
            //return $this->redirectToRoute('administrador_show', array('id' => $administrador->getId()));
			return $this->redirectToRoute('administrador_index');
        }

        return $this->render('WappAdministradorBundle:administrador:new.html.twig', array(
            'administrador' => $administrador,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Administrador entity.
     *
     */
    public function showAction(Administrador $administrador)
    {
        $deleteForm = $this->createDeleteForm($administrador);

        return $this->render('WappAdministradorBundle:administrador:show.html.twig', array(
            'administrador' => $administrador,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Administrador entity.
     *
     */
    public function editAction(Request $request, Administrador $administrador)
    {
        $deleteForm = $this->createDeleteForm($administrador);
        $editForm = $this->createForm(new AdministradorType(), $administrador);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($administrador);
            $em->flush();
			$this->addFlash('success', 'Datos de administrador actualizados correctamente');
            //return $this->redirectToRoute('administrador_edit', array('id' => $administrador->getId()));
			return $this->redirectToRoute('administrador_index');
        }

        return $this->render('WappAdministradorBundle:administrador:edit.html.twig', array(
            'administrador' => $administrador,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Administrador entity.
     *
     */
    public function deleteAction(Request $request, Administrador $administrador)
    {
        $form = $this->createDeleteForm($administrador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($administrador);
            $em->flush();
        }

        return $this->redirectToRoute('administrador_index');
    }

    /**
     * Creates a form to delete a Administrador entity.
     *
     * @param Administrador $administrador The Administrador entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Administrador $administrador)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administrador_delete', array('id' => $administrador->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
	
	/**
     * Deletes a Administrador entity from index.
     *
     */
    public function dindexAction(Request $request, Administrador $administrador)
    {
        $this->addFlash('success', 'Administrador eliminado correctamente');
		$em = $this->getDoctrine()->getManager();
		$em->remove($administrador);
		$em->flush();
        return $this->redirectToRoute('administrador_index', array());
    }
}
