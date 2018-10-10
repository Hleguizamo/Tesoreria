<?php

namespace Wapp\ProveedorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Wapp\ProveedorBundle\Entity\EstadoCuenta;
use Wapp\ProveedorBundle\Form\EstadoCuentaType;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use \DateTime;
/**
 * EstadoCuenta controller.
 *
 */
class EstadoCuentaController extends Controller
{
    /**
     * Lists all EstadoCuenta entities.
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
		
		$repo_ = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
		$repo_->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
		$inicount = $repo_->getQuery()->execute();	
		$total = 0;
		foreach($inicount as $repoc){ $total ++; }
		
		$repo = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
		$repo->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
		$repo->setFirstResult($iniciaResultados);
		$repo->setMaxResults($cantidadPorPagina);	
		$estadoCuentas = $repo->getQuery()->execute();
        
		return $this->render('WappProveedorBundle:estadocuenta:index.html.twig', array(
            'estadoCuentas' => $estadoCuentas,
			'cantidadPorPagina'=> $cantidadPorPagina,
			'paginaActual' => ($paginaActual + 1),
			'casevar' => 'index',
			'iniciaResultados'=>$iniciaResultados,
			'total'=>$total,
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
			$repo_ = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
			$repo_->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
			$inicount = $repo_->getQuery()->execute();	
			$total = 0;
			foreach($inicount as $repoc){ $total ++; }
			
			$repo = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
			$repo->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
			$repo->setFirstResult($iniciaResultados);
			$repo->setMaxResults($cantidadPorPagina);	
			$estadoCuentas = $repo->getQuery()->execute();
		}elseif($data["searchv"] == "advanced"){
			if($data["estado"] == "" && $data["referencia"] == "" && $data["fechapago"] == "" && $data["ndocumento"] == "" && $data["clase"] == "" && $data["fechadoc"] == "" && $data["vencimiento"] == "" && $data["dv"] == ""){
				$repo_ = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
				$repo_->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
				$inicount = $repo_->getQuery()->execute();	
				$total = 0;
				foreach($inicount as $repoc){ $total ++; }
				
				$repo = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
				$repo->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
				$repo->setFirstResult($iniciaResultados);
				$repo->setMaxResults($cantidadPorPagina);	
				$estadoCuentas = $repo->getQuery()->execute();
			}else{
				$repo = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
				$repo->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
				
				$repo_ = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
				$repo_->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
				
				if($data["estado"] != ""){
					$repo->andWhere('e.estado LIKE :estado')->setParameter('estado', '%'.$data["estado"].'%');
					$repo_->andWhere('e.estado LIKE :estado')->setParameter('estado', '%'.$data["estado"].'%');
				}
				
				if($data["referencia"] != ""){
					$repo->andWhere('e.referencia LIKE :referencia')->setParameter('referencia', '%'.$data["referencia"].'%');
					$repo_->andWhere('e.referencia LIKE :referencia')->setParameter('referencia', '%'.$data["referencia"].'%');
				}
				
				if($data["fechapago"] != ""){
					$repo->andWhere('e.fechaPago LIKE :fechaPago')->setParameter('fechaPago', '%'.$data["fechapago"].'%');
					$repo_->andWhere('e.fechaPago LIKE :fechaPago')->setParameter('fechaPago', '%'.$data["fechapago"].'%');
				}
				
				if($data["ndocumento"] != ""){
					$repo->andWhere('e.numeroDocumento LIKE :numeroDocumento')->setParameter('numeroDocumento', '%'.$data["ndocumento"].'%');
					$repo_->andWhere('e.numeroDocumento LIKE :numeroDocumento')->setParameter('numeroDocumento', '%'.$data["ndocumento"].'%');
				}
				
				if($data["clase"] != ""){
					$repo->andWhere('e.clase LIKE :clase')->setParameter('clase', '%'.$data["clase"].'%');
					$repo_->andWhere('e.clase LIKE :clase')->setParameter('clase', '%'.$data["clase"].'%');
				}
				
				if($data["fechadoc"] != ""){
					$repo->andWhere('e.fechaDocumento LIKE :fechaDocumento')->setParameter('fechaDocumento', '%'.$data["fechadoc"].'%');
					$repo_->andWhere('e.fechaDocumento LIKE :fechaDocumento')->setParameter('fechaDocumento', '%'.$data["fechadoc"].'%');
				}				
				if($data["vencimiento"] != ""){
					$repo->andWhere('e.vencimientoNeto LIKE :vencimientoNeto')->setParameter('vencimientoNeto', '%'.$data["vencimiento"].'%');
					$repo_->andWhere('e.vencimientoNeto LIKE :vencimientoNeto')->setParameter('vencimientoNeto', '%'.$data["vencimiento"].'%');
				}				
				
				if($data["dv"] != ""){
					   $repo->andWhere('e.dv LIKE :dv')->setParameter('dv', '%'.$data["dv"].'%');
					   $repo_->andWhere('e.dv LIKE :dv')->setParameter('dv', '%'.$data["dv"].'%');
				}
				$inicount = $repo_->getQuery()->execute();	
				$total = 0;
				foreach($inicount as $repoc){ $total ++; }
				
				$repo->setFirstResult($iniciaResultados);
				$repo->setMaxResults($cantidadPorPagina);					
				$estadoCuentas = $repo->getQuery()->execute();				
			}	
		}else{			
			$repo_ = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
			$repo_->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
			$repo_->andWhere('e.numeroDocumento LIKE :numeroDocumento')->setParameter('numeroDocumento', '%'.$data["searchv"].'%');
			$inicount = $repo_->getQuery()->execute();	
			$total = 0;
			foreach($inicount as $repoc){ $total ++; }
			
			$repo = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
			$repo->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);
			$repo->andWhere('e.numeroDocumento LIKE :numeroDocumento')->setParameter('numeroDocumento', '%'.$data["searchv"].'%');
			$repo->setFirstResult($iniciaResultados);
			$repo->setMaxResults($cantidadPorPagina);	
			$estadoCuentas = $repo->getQuery()->execute();
		}
		
        return $this->render('WappProveedorBundle:estadocuenta:index.html.twig', array(
            'estadoCuentas' => $estadoCuentas,
			'cantidadPorPagina'=> $cantidadPorPagina,
			'paginaActual' => ($paginaActual + 1),
			'casevar' => 'find',
			'iniciaResultados'=>$iniciaResultados,
			'total'=>$total,
			'data'=>$data,
        ));
    }
	
	/**
     * Export to Excel EstadoCuenta entity.
     *
     */
	 
	public function exportxlsAction(Request $request)
    {
		$useridObj = $this->get('security.context')->getToken()->getUser('Article', 1);
		$username = $useridObj->getUsername();
		$usercontacto = $useridObj->getContacto();
		$userrealnit = $useridObj->getNit();
		
		$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();				
		$entityManager = $this->getDoctrine()->getManager();   
		
		$useridObj = $this->get('security.context')->getToken()->getUser('Article', 1);
		$usernit=$useridObj->getId();	
		
		$repo = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
		$repo->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);		
		$posts = $repo->getQuery()->execute();

        $phpExcelObject->getProperties()->setCreator("")
           ->setLastModifiedBy("")
           ->setTitle("")
           ->setSubject("Copidrogas")
           ->setDescription("")
           ->setKeywords("")
           ->setCategory("");
		
		$phpExcelObject->getActiveSheet()->mergeCells('A1:N1');
	    $phpExcelObject->getActiveSheet()->setCellValue('A1','ESTADO DE CUENTA');
		$phpExcelObject->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		
		
		$phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A2', 'No.')
		   ->setCellValue('B2', 'Estado')
		   ->setCellValue('C2', 'Acreedor')
		   ->setCellValue('D2', 'Nombre Acreedor')		   
		   ->setCellValue('E2', 'Referencia')
		   ->setCellValue('F2', 'Fecha pago')
		   ->setCellValue('G2', 'No. Documento')
		   ->setCellValue('H2', 'Clase')
		   ->setCellValue('I2', 'Bloqueo pago')
		   ->setCellValue('J2', 'Fecha Doc')
		   ->setCellValue('K2', 'Vencimiento Neto')
		   ->setCellValue('L2', 'Importe en ML')
		   ->setCellValue('M2', 'Div')
		   ->setCellValue('N2', 'Texto');
		  $counter = 2;
		  $count = 1;
		  $countc = 0;

		  $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		  $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setWidth(14);
		  $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		  $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		  $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		  $phpExcelObject->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		  $phpExcelObject->getActiveSheet()->getColumnDimension('N')->setWidth(40);
		$totalt = 0;  
		foreach($posts as $post){ $counter++; $count++; $countc++;
		$temp1 = str_replace(".","",$post->getImporteMi());
        $phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A'.$counter, $countc)
		   ->setCellValue('B'.$counter, $post->getEstado())		   
		   ->setCellValue('C'.$counter, $userrealnit)
		   ->setCellValue('D'.$counter, $username)		   
		   ->setCellValue('E'.$counter, $post->getReferencia())
		   ->setCellValue('F'.$counter, $post->getFechaPago())
		   ->setCellValue('G'.$counter, $post->getNumeroDocumento())
		   ->setCellValue('H'.$counter, $post->getClase())
		   ->setCellValue('I'.$counter, $post->getBloqueoPago())
		   ->setCellValue('J'.$counter, $post->getFechaDocumento())
		   ->setCellValue('K'.$counter, $post->getVencimientoNeto())
		   ->setCellValue('L'.$counter, $temp1)
		   ->setCellValue('M'.$counter, $post->getDv())
		   ->setCellValue('N'.$counter, $post->getTexto());
			$totalt = $totalt + intval($temp1);
		}
		$counter++;
		$phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A'.$counter, "TOTAL")
		   ->setCellValue('B'.$counter, $totalt)
		   ->setCellValue('C'.$counter, "")
		   ->setCellValue('D'.$counter, "")
		   ->setCellValue('E'.$counter, "")
		   ->setCellValue('F'.$counter, "")
		   ->setCellValue('G'.$counter, "")
		   ->setCellValue('H'.$counter, "")
		   ->setCellValue('I'.$counter, "")
		   ->setCellValue('J'.$counter, "")
		   ->setCellValue('K'.$counter, "")
		   ->setCellValue('L'.$counter, "")
		   ->setCellValue('M'.$counter, "")
		   ->setCellValue('N'.$counter, "");
		   
		   
       $phpExcelObject->getActiveSheet()->setTitle('Copidrogas');
       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'estado_de_cuenta_'.date("Y-m-d H:i:s").'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
   }
    /**
     * Creates a new EstadoCuenta entity.
     *
     */
    public function newAction(Request $request)
    {
        $estadoCuentum = new EstadoCuenta();
        $form = $this->createForm(new EstadoCuentaType(), $estadoCuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estadoCuentum);
            $em->flush();

            return $this->redirectToRoute('estadocuenta_show', array('id' => $estadocuenta->getId()));
        }

        return $this->render('estadocuenta/new.html.twig', array(
            'estadoCuentum' => $estadoCuentum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EstadoCuenta entity.
     *
     */
    public function showAction(EstadoCuenta $estadoCuentum)
    {
        $deleteForm = $this->createDeleteForm($estadoCuentum);

        return $this->render('estadocuenta/show.html.twig', array(
            'estadoCuentum' => $estadoCuentum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EstadoCuenta entity.
     *
     */
    public function editAction(Request $request, EstadoCuenta $estadoCuentum)
    {
        $deleteForm = $this->createDeleteForm($estadoCuentum);
        $editForm = $this->createForm(new EstadoCuentaType(), $estadoCuentum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estadoCuentum);
            $em->flush();

            return $this->redirectToRoute('estadocuenta_edit', array('id' => $estadoCuentum->getId()));
        }

        return $this->render('estadocuenta/edit.html.twig', array(
            'estadoCuentum' => $estadoCuentum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EstadoCuenta entity.
     *
     */
    public function deleteAction(Request $request, EstadoCuenta $estadoCuentum)
    {
        $form = $this->createDeleteForm($estadoCuentum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($estadoCuentum);
            $em->flush();
        }

        return $this->redirectToRoute('estadocuenta_index');
    }

    /**
     * Creates a form to delete a EstadoCuenta entity.
     *
     * @param EstadoCuenta $estadoCuentum The EstadoCuenta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EstadoCuenta $estadoCuentum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estadocuenta_delete', array('id' => $estadoCuentum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
	/**
     * Export to PDF EstadoCuenta entity.
     *
     */
	public function exportpdfAction(Request $request){
		$useridObj = $this->get('security.context')->getToken()->getUser('Article', 1);
		$username = $useridObj->getUsername();
		$usercontacto = $useridObj->getContacto();

		$pdf = $this->container->get("white_october.tcpdf")->create('LANDSCAPE', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Copidrogas');
		$pdf->SetTitle('Copidrogas');
		$pdf->SetSubject('Copidrogas');
		$pdf->SetKeywords('Copidrogas');

		// set default header data
		$pdf->SetHeaderData("logo.png", "100", "Estado de Cuenta", $username);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 9);
		$pdf->AddPage();
		// column titles
		$header = array('#', 'Estado', 'Referencia', 'Fecha Pago', 'N Documento', 'Clase', 'B. Pago', 'Fecha Doc', 'Vencimiento', 'Importe ML', 'Div', 'Texto');
		
		// print colored table	
		
		$pdf->SetFillColor(186, 202, 218);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(128, 128, 128);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('', 'B');
        // Header
        $w = array(7, 20, 20, 20, 34, 30, 20, 20, 20, 20, 20, 40);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $pdf->Ln();
        // Color and font restoration
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        // Data
        $fill = 1;
		
		$entityManager = $this->getDoctrine()->getManager();  
      	
		$useridObj = $this->get('security.context')->getToken()->getUser('Article', 1);
		$usernit=$useridObj->getId();	
		
		$repo = $this->getDoctrine()->getRepository('WappProveedorBundle:EstadoCuenta')->createQueryBuilder('e');
		$repo->where('e.proveedor = :proveedor')->setParameter('proveedor', $usernit);		
		$posts = $repo->getQuery()->execute();
		
		$counter = 1;		
		$pdf->SetFont('helvetica', '', 8);
		
		$i=0;
		$pdf->setCellHeightRatio(1.5);
		$totalt=0;
		foreach($posts as $post){ ++$i; $ct = $i % 2;
			$temp1 = $post->getFechaPago();
			$temp1 = $temp1->format('Y-m-d');	
			$temp2 = $post->getFechaDocumento();
			$temp2 = $temp2->format('Y-m-d');	
			$imagen1 = $post->getEstado();
			$imagen1 = "<img src='images/Pendiente.png'>";
			$page_start = $pdf->getPage();
			$y_start = $pdf->GetY();
			$pdf->MultiCell($w[0], 0, $i, 1, 'C', $ct, 2, '', '', true, 0);	
			$y_end_1 = $pdf->GetY();	
			$pdf->setPage($page_start);	
			$pdf->MultiCell($w[1], 0, $post->getEstado(), 1, 'L', $ct, 1, $pdf->GetX() ,$y_start, true, 0);
			$pdf->Image('images/'.$post->getEstado().'.png',$w[1] + 19,$y_start + 1,2,2,'','','N','','');
			$pos = $pdf->GetX() + $w[1] + $w[0];
			$pdf->MultiCell($w[2], 0, $post->getReferencia(), 1, 'C', $ct, 1, $pos ,$y_start, true, 0);
			$pos = $pos + $w[2];
			$pdf->MultiCell($w[3], 0, $temp1, 1, 'C', $ct, 1, $pos ,$y_start, true, 0);
			$pos = $pos + $w[3];
			$pdf->MultiCell($w[4], 0, $post->getNumeroDocumento(), 1, 'L', $ct, 1, $pos ,$y_start, true, 0);	
			$pos = $pos + $w[4];
			$pdf->MultiCell($w[5], 0, $post->getClase(), 1, 'L', $ct, 1, $pos ,$y_start, true, 0);
			$pos = $pos + $w[5];
			$pdf->MultiCell($w[6], 0, $post->getBloqueoPago(), 1, 'L', $ct, 1, $pos ,$y_start, true, 0);
			$pos = $pos + $w[6];
			$pdf->MultiCell($w[7], 0, $temp2, 1, 'L', $ct, 1, $pos ,$y_start, true, 0);
			$pos = $pos + $w[7];
			$pdf->MultiCell($w[8], 0, $post->getVencimientoNeto(), 1, 'L', $ct, 1, $pos ,$y_start, true, 0);
			$pdf->Image('images/'.$post->getVencimientoNeto().'.png',$pos + 17, $y_start + 1,2,2,'','','N','','');
			$pos = $pos + $w[8];
			$pdf->MultiCell($w[9], 0, number_format($post->getImporteMi(),0,",","."), 1, 'L', $ct, 1, $pos ,$y_start, true, 0);
			$pos = $pos + $w[9];
			$pdf->MultiCell($w[10], 0, $post->getDv(), 1, 'L', $ct, 1, $pos ,$y_start, true, 0);
			$pos = $pos + $w[10];
			$pdf->MultiCell($w[11], 0, $post->getTexto(), 1, 'L', $ct, 1, $pos ,$y_start, true, 0);
			$totalt = $totalt + $post->getImporteMi();
		}
		$pdf->SetFillColor(186, 202, 218);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(128, 128, 128);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('', 'B');
		$space = "";
		$page_start = $pdf->getPage();
		$y_start = $pdf->GetY();
		$pdf->MultiCell($w[0], 0, $space, 1, 'C', 1, 2, '', '', true, 0);	
		$y_end_1 = $pdf->GetY();	
		$pdf->setPage($page_start);	
		$pdf->MultiCell($w[1], 0, $space, 1, 'C', 1, 1, $pdf->GetX() ,$y_start, true, 0);
		$pos = $pdf->GetX() + $w[1] + $w[0];
		$pdf->MultiCell($w[2], 0, $space, 1, 'C', 1, 1, $pos ,$y_start, true, 0);
		$pos = $pos + $w[2];
		$pdf->MultiCell($w[3], 0, $space, 1, 'C', 1, 1, $pos ,$y_start, true, 0);
		$pos = $pos + $w[3];
		$pdf->MultiCell($w[4], 0, $space, 1, 'L', 1, 1, $pos ,$y_start, true, 0);	
		$pos = $pos + $w[4];
		$pdf->MultiCell($w[5], 0, $space, 1, 'L', 1, 1, $pos ,$y_start, true, 0);
		$pos = $pos + $w[5];
		$pdf->MultiCell($w[6], 0, $space, 1, 'L', 1, 1, $pos ,$y_start, true, 0);
		$pos = $pos + $w[6];
		$pdf->MultiCell($w[7], 0, $space, 1, 'L', 1, 1, $pos ,$y_start, true, 0);
		$pos = $pos + $w[7];
		$pdf->MultiCell($w[8], 0, "Total:", 1, 'R', 1, 1, $pos ,$y_start, true, 0);
		$pos = $pos + $w[8];
		$pdf->MultiCell($w[9], 0, number_format($totalt,0,",","."), 1, 'L', 1, 1, $pos ,$y_start, true, 0);
		$pos = $pos + $w[9];
		$pdf->MultiCell($w[10], 0, $space, 1, 'L', 1, 1, $pos ,$y_start, true, 0);
		$pos = $pos + $w[10];
		$pdf->MultiCell($w[11], 0, $space, 1, 'L', 1, 1, $pos ,$y_start, true, 0);
		
		$pdf->Output('estado_de_cuenta_'.date("Y-m-d H:i:s").'.pdf', 'D');
	}	
}
