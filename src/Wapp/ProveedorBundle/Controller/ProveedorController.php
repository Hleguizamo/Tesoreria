<?php

namespace Wapp\ProveedorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wapp\ProveedorBundle\Entity\Proveedor;
use Wapp\ProveedorBundle\Form\ProveedorType;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $proveedors = $em->getRepository('WappProveedorBundle:Proveedor')->findAll();

        return $this->render('WappProveedorBundle:proveedor:indexproveedor.html.twig', array(
            'proveedors' => $proveedors,
        ));
    }    

    /**
     * Displays a form to edit an existing Proveedor entity.
     *
     */
    public function editAction(Request $request, Proveedor $proveedor)
    {
        $data = $request->request->all();		
		$em = $this->getDoctrine()->getManager();
		$useridObj = $this->get('security.context')->getToken()->getUser('Article', 1);
		$userid=$useridObj->getId();
		
		if($proveedor->getId() != $userid){			
			return $this->redirectToRoute('estadocuenta_index', array());
		}
		
		$editForm = $this->createForm(new ProveedorType(), $proveedor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {            
            $em->persist($proveedor);
            $em->flush();
			$this->addFlash('success', 'Sus datos fueron actualizados correctamente');
            return $this->redirectToRoute('estadocuenta_index', array());
        }		
        return $this->render('WappProveedorBundle:proveedor:editproveedor.html.twig', array(
            'proveedor' => $proveedor,
            'edit_form' => $editForm->createView()
        ));
    }
}
