<?php

namespace Wapp\AdministradorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wapp\AdministradorBundle\Entity\Proveedor;
use Wapp\AdministradorBundle\Form\ProveedorType;

/**
 * Proveedor controller.
 *
 */
class ProveedorController extends Controller
{
    /**
     * Lists all Proveedor entities.
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
		
		$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');		
		$inicount = $repo_->getQuery()->execute();	
		$total = 0;		
		foreach($inicount as $repoc){ $total ++; }
		
		$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');		
		$repo->setFirstResult($iniciaResultados);
		$repo->setMaxResults($cantidadPorPagina);	
		
		$proveedors = $repo->orderBy('e.razonSocial', 'ASC')->getQuery()->execute();		
        
        return $this->render('WappAdministradorBundle:proveedor:index.html.twig', array(
            'proveedors' => $proveedors,
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
			$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');			
			$inicount = $repo_->getQuery()->execute();	
			$total = 0;
			foreach($inicount as $repoc){ $total ++; }
			
			$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');			
			$repo->setFirstResult($iniciaResultados);
			$repo->setMaxResults($cantidadPorPagina);	
			$proveedors = $repo->orderBy('e.razonSocial', 'ASC')->getQuery()->execute();
		}elseif($data["searchv"] == "advanced"){
			if($data["nit"] == "" && $data["email"] == "" && $data["razon_social"] == ""){
				$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');				
				$inicount = $repo_->getQuery()->execute();	
				$total = 0;
				foreach($inicount as $repoc){ $total ++; }
				
				$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');				
				$repo->setFirstResult($iniciaResultados);
				$repo->setMaxResults($cantidadPorPagina);	
				$proveedors = $repo->getQuery()->execute();
			}else{
				$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');				
				$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');				
				
				if($data["nit"] != ""){
					$repo->andWhere('e.nit LIKE :nit')->setParameter('nit', '%'.$data["nit"].'%');
					$repo_->andWhere('e.nit LIKE :nit')->setParameter('nit', '%'.$data["nit"].'%');
				}
				
				if($data["email"] != ""){
					$repo->andWhere('e.email LIKE :email')->setParameter('email', '%'.$data["email"].'%');
					$repo_->andWhere('e.email LIKE :email')->setParameter('email', '%'.$data["email"].'%');
				}
				
				if($data["razon_social"] != ""){
					$repo->andWhere('e.razonSocial LIKE :razonSocial')->setParameter('razonSocial', '%'.$data["razon_social"].'%');
					$repo_->andWhere('e.razonSocial LIKE :razonSocial')->setParameter('razonSocial', '%'.$data["razon_social"].'%');
				}
				
				$inicount = $repo_->getQuery()->execute();	
				$total = 0;
				foreach($inicount as $repoc){ $total ++; }
				
				$repo->setFirstResult($iniciaResultados);
				$repo->setMaxResults($cantidadPorPagina);					
				$proveedors = $repo->orderBy('e.razonSocial', 'ASC')->getQuery()->execute();				
			}	
		}else{			
			$repo_ = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');			
			$repo_->andWhere('e.nit LIKE :nit')->setParameter('nit', '%'.$data["searchv"].'%');
			$inicount = $repo_->getQuery()->execute();	
			$total = 0;
			foreach($inicount as $repoc){ $total ++; }
			
			$repo = $this->getDoctrine()->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');			
			$repo->andWhere('e.nit LIKE :nit')->setParameter('nit', '%'.$data["searchv"].'%');
			$repo->setFirstResult($iniciaResultados);
			$repo->setMaxResults($cantidadPorPagina);	
			$proveedors = $repo->orderBy('e.razonSocial', 'ASC')->getQuery()->execute();
		}
		
        return $this->render('WappAdministradorBundle:proveedor:index.html.twig', array(
            'proveedors' => $proveedors,
			'cantidadPorPagina'=> $cantidadPorPagina,
			'paginaActual' => ($paginaActual + 1),
			'casevar' => 'find',
			'iniciaResultados'=>$iniciaResultados,
			'total'=>$total,
			'data'=>$data,
        ));
    }
	
    /**
     * Creates a new Proveedor entity.
     *
     */
    public function newAction(Request $request)
    {
        $proveedor = new Proveedor();
        $form = $this->createForm(new ProveedorType(), $proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proveedor);
			
			$date = date("d-m-Y H:i:s");
			

			$proveedor->setActualizacion(new \DateTime($date));
			$proveedor->setCambioClave(new \DateTime($date));
			$proveedor->setUltimaClave(0);
            
			$em->flush();
			$this->addFlash('success', 'Proveedor creado correctamente');
            //return $this->redirectToRoute('proveedor_show', array('id' => $proveedor->getId()));
			return $this->redirectToRoute('proveedor_index');
        }

        return $this->render('WappAdministradorBundle:proveedor:new.html.twig', array(
            'proveedor' => $proveedor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Proveedor entity.
     *
     */
    public function showAction(Proveedor $proveedor)
    {
        $deleteForm = $this->createDeleteForm($proveedor);

        return $this->render('WappAdministradorBundle:proveedor:show.html.twig', array(
            'proveedor' => $proveedor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Proveedor entity.
     *
     */
    public function editAction(Request $request, Proveedor $proveedor)
    {
        $deleteForm = $this->createDeleteForm($proveedor);
        $editForm = $this->createForm(new ProveedorType(), $proveedor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proveedor);
            $em->flush();

            //return $this->redirectToRoute('proveedor_edit', array('id' => $proveedor->getId()));
			$this->addFlash('success', 'Datos de proveedor actualizados correctamente');
			return $this->redirectToRoute('proveedor_index');
        }

        return $this->render('WappAdministradorBundle:proveedor:edit.html.twig', array(
            'proveedor' => $proveedor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Proveedor entity.
     *
     */
    public function deleteAction(Request $request, Proveedor $proveedor)
    {
        $form = $this->createDeleteForm($proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($proveedor);
            $em->flush();
        }

        return $this->redirectToRoute('proveedor_index');
    }

    /**
     * Creates a form to delete a Proveedor entity.
     *
     * @param Proveedor $proveedor The Proveedor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Proveedor $proveedor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proveedor_delete', array('id' => $proveedor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
	/**
     * Deletes a Proveedor entity from index.
     *
     */
    public function dindexAction(Request $request, Proveedor $proveedor)
    {
        $em = $this->getDoctrine()->getManager();
		$em->remove($proveedor);
		$em->flush();
		$this->addFlash('success', 'Proveedor eliminado correctamente'.$proveedor->getId());
        return $this->redirectToRoute('proveedor_index', array());
    }
}
