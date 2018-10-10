<?php
namespace Wapp\AdministradorBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wapp\AdministradorBundle\Entity\EstadoCuenta;

/**
 * Proveedor controller.
 *
 */
class EstadoCuentaController extends Controller
{

    /**
     * Creates a new Proveedor entity.
     *
     */
    public function pdfAction($idProveedor, Request $request)
    {
        /*
        
        #Ejemplo 1, tomado de la documentacion Oficial TCPDF
        $pdf = $this->container->get("white_october.tcpdf")->create('LANDSCAPE', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAutoPageBreak(TRUE);
        $pdf->setPageOrientation('l');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('COOPIDROGAS');
        $pdf->SetKeywords('Estado de cuenta Tesoreria Proveedores.');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(7, 30, 7);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->addPage();
        #@Aqui se inicia a dar formato al contenido.
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('', 'B');
        //Imprimir Cabecera de la tabla
        $header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
        $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $pdf->Ln();
        //Se reataura el color de fondo.
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        //Imprimir contenido de la tabla.
        $fill = 0;
        for($x=1;$x<=20;$x++) {
            $pdf->Cell($w[0], 6, $x.'1', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, number_format($x.'1'), 'LR', 0, 'R', $fill);
            $pdf->Cell($w[3], 6, number_format($x.'2'), 'LR', 0, 'R', $fill);
            $pdf->Ln();
            $fill=!$fill;
        }
        $pdf->Cell(array_sum($w), 0, '', 'T');
        $pdf->Output('Estado_de_cuenta_'.date("Y-m-d H:i:s").'.pdf', 'I');
        #Aqui finaliza el ejemplo 1.
        
        */


        
        #Ejemplo 1, tomado de la documentacion Oficial TCPDF, se ajusta al formato que debe tener el informe real.
        $pdf = $this->container->get("white_october.tcpdf")->create('LANDSCAPE', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAutoPageBreak(TRUE);
        $pdf->setPageOrientation('l');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('COOPIDROGAS');
        $pdf->SetKeywords('Estado de cuenta Tesoreria Proveedores.');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(7, 30, 7);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->addPage();
        #@Aqui se inicia a dar formato al contenido.
        $pdf->SetFillColor(0, 62, 126);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(238, 58, 67);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('', 'B',8);
        //Imprimir Cabecera de la tabla
        $header = array('No.', 'Estado', 'Acreedor', 'Nombre Acreedor','Referencia','Fecha Pago','No. Documento','Clase','Bloqueo de Pago','Fecha Doc','Vencimient o Neto','Importe ML','Div','Texto');
        ###Paso 2 redistribuir los espacios de las cajas
        $w = array(15, 15, 15, 15,15,15,15,15,15,15,15,15,15,15);//paso1
        $w = array(10, 15, 30, 25,25, 15,25,25,15, 15,15,15,20,30);//paso2
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $pdf->Ln();
        //Se reataura el color de fondo.
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        //Imprimir contenido de la tabla.
        $fill = 0;
        //Datos de prueba
        for($x=1;$x<=20;$x++) {
            $pdf->Cell($w[0], 6, $x.'1', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, number_format($x.'1'), 'LR', 0, 'R', $fill);
            $pdf->Cell($w[3], 6, number_format($x.'2'), 'LR', 0, 'R', $fill);
            $pdf->Cell($w[4], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[5], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[6], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[7], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[8], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[9], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[10], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[11], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[12], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[13], 6, $x.'2', 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $fill=!$fill;
        }
        $pdf->Output('Estado_de_cuenta_'.date("Y-m-d H:i:s").'.pdf', 'I');
        //datos Reales
        /*$em = $this->getDoctrine()->getManager();
        //$estadosCuenta = $em->getRepository('WappAdministradorBundle:EstadoCuenta')->findAll();//Consulta basica
        $estadosCuenta=$em->createQuery("SELECT ec, p FROM WappAdministradorBundle:EstadoCuenta ec JOIN e.proveedor WHERE ec.proveedor=:idProveedor ")
        ->setparameter('idProveedor',$idProveedor)
        ->getResult();
        echo count($estadosCuenta);exit;
        
        $cont=0;
        foreach($estadosCuenta as $cuenta){
            $pdf->Cell($w[0], 6, $cont++, 'LR', 0, 'L', $fill);
            $pdf->Cell($w[1], 6, $cuenta->getEstado(), 'LR', 0, 'L', $fill);
            $pdf->Cell($w[2], 6, number_format($cont.'1'), 'LR', 0, 'R', $fill);
            $pdf->Cell($w[3], 6, number_format($cont.'2'), 'LR', 0, 'R', $fill);
            $pdf->Cell($w[4], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[5], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[6], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[7], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[8], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[9], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[10], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[11], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[12], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Cell($w[13], 6, $cont.'2', 'LR', 0, 'L', $fill);
            $pdf->Ln();
            $fill=!$fill;
        }
        $pdf->Cell(array_sum($w), 0, '', 'T');
        $pdf->Output('Estado_de_cuenta_'.date("Y-m-d H:i:s").'.pdf', 'I');
        #Aqui finaliza el ejemplo 2.*/
    }
}
