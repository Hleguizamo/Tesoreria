<?php
namespace Wapp\AdministradorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wapp\AdministradorBundle\Entity\EstadoCuenta;
use Wapp\AdministradorBundle\Entity\Proveedor;

class actualizaEstadosCommand extends ContainerAwareCommand
	{
	public $conn;
    protected function configure() {
        parent::configure();
        $this->setName('actualiza:estados')->setDescription('Ejemplo de tarea actualizar estados.');		
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
			
        $output->writeln("Inicio de la tarea.");        
		
		$query = "truncate estado_cuenta";
		$truncate = $this->getContainer()->get('doctrine')->getConnection()->executeQuery($query, array(), array());
		$proveedores = $this->setProveedores();
		$fileName = '/home/planos/Tesoreria/estprov.txt';
		$x = 1;
		if($fp = fopen ($fileName,"r")){
			while($datos = fgetcsv($fp, 1000, "\t")){				 
				$tmp1 = explode(";", $datos[0]);
				if(!isset($proveedores[intval($tmp1[1])])){
					$output->writeln("Usuario No encontrado ingresandolo al sistema.".intval($tmp1[1]));	
					$sqlP = "INSERT INTO proveedor (nit, razon_social, nombre_contacto, email, contrasena, actualizacion, cambio_clave) VALUES ('".intval($tmp1[1])."', '".utf8_encode($tmp1[2])."', '".utf8_encode($tmp1[2])."', '', '".intval($tmp1[1])."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d")."')";
					$insert = $this->getContainer()->get('doctrine')->getConnection()->executeQuery($sqlP, array(), array());			
					$proveedores = $this->setProveedores();
				}
				$fecha1 = (substr($tmp1[4], 0, 4)=='0000' OR substr($tmp1[4], 0, 4)=='')?null:"'".substr($tmp1[4], 0, 4)."-".substr($tmp1[4], 4, 2)."-".substr($tmp1[4], 6, 2)."'";
				$fecha2 = substr($tmp1[8], 0, 4)."-".substr($tmp1[8], 4, 2)."-".substr($tmp1[8], 6, 2);
				$query2 = "INSERT INTO estado_cuenta (estado, proveedor_id, referencia, ";
				$query2 .= ($fecha1) ? "fecha_pago, ":''; 
				$query2 .= " numero_documento, clase, bloqueo_pago, fecha_documento, vencimiento_neto, importe_mi, dv, texto) ";
				$query2 .= " VALUES ('".trim($tmp1[0])."', '".$proveedores[intval($tmp1[1])]."','".utf8_encode($tmp1[3])."',";
				$temp10=str_replace(array("."," "), array("",""), $tmp1[10]);
				$query2 .= ($fecha1) ? $fecha1.",":'';
				$query2 .= "'".$tmp1[5]."','".$tmp1[6]."','".$tmp1[7]."','".$fecha2."','".$tmp1[9]."','".$temp10."','".utf8_encode($tmp1[11])."','".utf8_encode(str_replace("'", "", $tmp1[12]))."')";				
				$output->writeln($x." -> ".intval($tmp1[1])." Ingresado");				
				$update = $this->getContainer()->get('doctrine')->getConnection()->executeQuery($query2, array(), array());			
				$x++;
			}
		}		
        $output->writeln("He terminado las tareas...");
    }	
	protected function setProveedores(){
		$repo_ = $this->getContainer()->get('doctrine')->getRepository('WappAdministradorBundle:Proveedor')->createQueryBuilder('e');		
		$inicount = $repo_->getQuery()->execute();			
		$proveedores = array();
		foreach($inicount as $repoc){ 
			$proveedores[$repoc->getNit()] = $repoc->getId();
		}
		return $proveedores;	
	}
}
?>
