<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class RpCasasPagoMantenimientoAjax extends CI_Controller {

 function __construct()
 {
   	parent::__construct();
			$response = array(
	    'status' => 200,
	    'message' => '',
	    'data' => '',
		);
 	}
 

	Public function cargardaCasas(){
		$sector = $this->input->post('sector');
		$this->load->model('RpCasasPagoMantenimiento_Model','GENR',true);
		$datasect=$this->GENR->Casas($sector);
		$inputCasa='<option value=0>Seleccione Casa</option>'; 
	    $response['status']=200;
	    $response['data']=$datasect;
		echo json_encode($response); 	
	}

	Public function cargardatos(){
		$datos = 	array(
						    'EstadoPagoCliente' => '',
						    'DirecCatastro' => '',
						    'CodSeguridad' => '',
						    'SectorCasa' => '',
						    'FechaPago' => '',
						    'IdCliente' => '',
						    'Contacto' => '',
						    'Cliente' => '',
						    'ImgEst' => '',
							);
		$numero1 = $this->input->post('numero1');
		$tiponum = $this->input->post('tiponum');
		$numero2 = $this->input->post('numero2');
		$numero3 = $this->input->post('numero3');
		$numero4 = $this->input->post('numero4');
		$codigo = $this->input->post('codigo');
		$sector = $this->input->post('sector');
		$casa = $this->input->post('casa');
		$this->load->model('RpCasasPagoMantenimiento_Model','GENR',true);
		$datasect=$this->GENR->InfoPagos(
																			$sector, 
																			$casa, 
																			$codigo, 
																			$numero1, 
																			$tiponum, 
																			$numero2, 
																			$numero3, 
																			$numero4
																		);
		$rp='';
		$textoTel = '';
		$contador=0;
		$mesUltimoPago=0;
		$annoUltimoPago=0;
		$mesActual=0;
		$annoActual=0;
		$banderaDiaPago=0;
		if($datasect['status']==200)
		 {
		 	$color='class="success "'; 
			 	foreach ($datasect['data'] as $data) {
			 		$contador=$contador+1;
					$rp.='<tr '.$color.'>
									<td align="right">'.$contador.'</td>
									<td>'.$data['sector'].'</td>
									<td align="center">'.$data['casa'].'</td>
									<td align="center">'.$data['codigo_seg'].'</td>
									<td>'.$data['dir_catastro'].'</td>
									<td>'.$data['nombrecliente'].'</td>
									<td>'.$data['estado'].'</td>
									<td>'.$data['fecha'].'</td>
					  		</tr>';

					
					$datos['EstadoPagoCliente'] = $data['estado'];
					$datos['DirecCatastro'] = $data['dir_catastro'];
					$datos['CodSeguridad'] = $data['codigo_seg'];
					$datos['SectorCasa'] = $data['sector'].'-'.$data['casa'];
					$datos['FechaPago'] = $data['fecha'];
					$datos['IdCliente'] = $data['id_identidad'];
					$datos['Cliente'] = $data['nombrecliente'];
					$mesUltimoPago = $data['mes'];
					$annoUltimoPago = $data['anno'];
					$mesAlta =  $data['mesalta'];
					$annoAlta =  $data['annoalta'];
			}
			$datatel=$this->GENR->Telefonos($datos['IdCliente']);
			if($datatel['status']==200){
				foreach ($datatel['data'] as $data) {
					$textoTel .= $data['contacto'].' ';
				}	
			}else{
				$textoTel = '--------';
			}
			$datadiapago=$this->GENR->DiaPago();
			if($datadiapago['status']==200){
				foreach ($datadiapago['data'] as $data) {
					$mesActual = $data['mesact'];
					$annoActual = $data['annoact'];
					$banderaDiaPago = $data['bandera'];
					$diaPago = $data['diapago'];
				}	
			}

			if($mesUltimoPago==''||$mesUltimoPago==null){
				$fechaPago = $annoAlta.'-'.$mesAlta.'-1';
				$fechaCobro = $annoActual.'-'.$mesActual.'-'.$diaPago;
				$datos['FechaPago'] = '';
			}else if($mesUltimoPago<$mesAlta && $annoUltimoPago<=$annoAlta){
				$fechaPago = $annoAlta.'-'.$mesAlta.'-1';
				$fechaCobro = $annoActual.'-'.$mesActual.'-'.$diaPago;
				$datos['FechaPago'] = '';
			}else{
				$fechaPago = $annoUltimoPago.'-'.$mesUltimoPago.'-1';
				$fechaCobro = $annoActual.'-'.$mesActual.'-'.$diaPago;
			}
			$fechainicial = new DateTime($fechaPago);
			$fechafinal = new DateTime($fechaCobro);
			$diferencia = $fechainicial->diff($fechafinal);
			$meses = ( $diferencia->y * 12 ) + $diferencia->m;
			
			if($meses==2 && $banderaDiaPago==1){
				$meses=1;
			}

			$datos['ImgEst'] = $meses;	
		


			$datos['Contacto'] = $textoTel;		
			$response['status']=200;
			$response['data']=$datos;
			echo json_encode($response); 
		 }
		 if($datasect['status']==401){
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	echo json_encode($response);
		}	
	}

	Public function llena_detalle(){
		$id_casa = $this->input->post('id_casa');
		$this->load->model('RpCasasPagoMantenimiento_Model','GENR',true);
		$datasect=$this->GENR->InfoPagos($id_casa);
		$rp='';
		if($datasect['status']==200)
		 {
			 foreach ($datasect['data'] as $data) {
				$rp.='<tr>
						<td align="right">'.$data['cuotab'].'</td>
						<td align="right">'.$data['numtarjetasp'].'</td>
						<td align="right">'.$data['valorxtplastica'].'</td>
						<td align="right">'.$data['numtarjetasadic'].'</td>
						<td align="right">'.$data['valorxtadic'].'</td>
					  </tr>';
			}	
			    $response['status']=200;
			    $response['data']=$rp;
			echo json_encode($response); 
		 }
		 if($datasect['status']==401){
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	echo json_encode($response);
		 }	
	}


	public function generar_excel($sector){
		$this->load->model('RpCasasActivas_Model','MANC',true);
	    $datasect=$this->MANC->Reporte($sector);
	    if($datasect['status']==200){
	    	$contador=1;
	        //Cargamos la librería de excel.
	        $this->load->library('Excel'); $this->excel->setActiveSheetIndex(0);
	        $this->excel->getActiveSheet()->setTitle('Reporte Gral.');
	        //Contador de filas
	        $contador = 1;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(70);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	        //columnas para los TELEFONOS
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
	        //columnas para las TARJETAS
	        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
	        //columnas para los VEHICULOS
	        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
	        //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("M{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("R{$contador}")->getFont()->setBold(true);
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'No.');
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Sector');
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'No. Casa');
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Cod.Seg.');
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Dir. Catastro');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Cliente');
	        $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'F.Alta');
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Telefonos');
	        $this->excel->getActiveSheet()->setCellValue("M{$contador}", 'Tarjetas');
	        $this->excel->getActiveSheet()->setCellValue("R{$contador}", 'Vehiculos');
	        $this->excel->setActiveSheetIndex(0)->mergecells('H1:L1');
	        $this->excel->setActiveSheetIndex(0)->mergecells('M1:Q1');
	        $this->excel->setActiveSheetIndex(0)->mergecells('R1:V1');
	        //Definimos la data del cuerpo.    
	        $contadorln=1;    
	        foreach ($datasect['data'] as $data) {
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

		        $this->excel->getActiveSheet()->setCellValue("A{$contador}",$contadorln);
		        $this->excel->getActiveSheet()->setCellValue("B{$contador}",$data['nombsector']);
		        $this->excel->getActiveSheet()->setCellValue("C{$contador}",$data['nocasa']);
		        $this->excel->getActiveSheet()->setCellValue("D{$contador}",$data['codigo_seg']);
		        $this->excel->getActiveSheet()->setCellValue("E{$contador}",$data['dir_completa']);
		        $this->excel->getActiveSheet()->setCellValue("F{$contador}",$data['nombrecliente']);
		        $this->excel->getActiveSheet()->setCellValue("G{$contador}",$data['falta']);

		        //OBTENEMOS LOS TELEFONOS DE CADA CLIENTE
			    $datatele=$this->MANC->Telefonos($data['id_identidad']);
			    if($datatele['status']==200){
			    	$col='H';
			      foreach ($datatele['data'] as $data) {	
			      	$this->excel->getActiveSheet()->setCellValue($col.$contador,$data['numtel']);
			      	$col++;
			      }
			    }	

		        //OBTENEMOS LAS TARJETAS DE CADA CLIENTE
			    $datatarje=$this->MANC->Tarjetas($data['id_identidad']);
			    if($datatarje['status']==200){
			    	$col='M';
			      foreach ($datatarje['data'] as $data) {	
			      	$this->excel->getActiveSheet()->setCellValue($col.$contador,$data['numero']);
			      	$col++;
			      }
			    }	

		        //OBTENEMOS LAS VEHICULOS DE CADA CLIENTE
			    $datavehi=$this->MANC->Vehiculos($data['id_identidad']);
			    if($datavehi['status']==200){
			    	$col='R';
			      foreach ($datavehi['data'] as $data) {	
			      	$this->excel->getActiveSheet()->setCellValue($col.$contador,$data['placa']);
			      	$col++;
			      }
			    }	

		        $contadorln++;
	        }
	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Rep_CasasActivas.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output');
	     }else{
	        echo 'No se han encontrado llamadas';
	        exit;        
	     }
	  }	
}