<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', '1');


Class RepIngresosAjax extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   			$response = array(
			    'status' => 200,
			    'message' => '',
			    'data' => '',
			);
 }
 

	Public function cargardatos(){

		$this->load->model('RepIngresos_Model','MAN',true);

		$fini = $this->input->post('fini');
		$ffin = $this->input->post('ffin');
		$cliente=$this->input->post('cliente');

		$datasect=$this->MAN->Reporte($fini,$ffin,$cliente);
		//print_r($datasect);
		$rp='';
		$totalmant=0;
		$totaltarjetas=0;
		$grantotal=0;
		if($datasect['status']==200)
		 {
		 	$contador=1;
			 foreach ($datasect['data'] as $data) {

				$rp.='<tr>
						<td>'.$contador.'</td>
						<td>'.$data['recibo'].'</td>
						<td>'.$data['cliente'].'</td>
						<td>'.$data['ncasa'].'</td>
						<td>'.$data['nsector'].'</td>
						<td>'.$data['fpago'].'</td>
						<td>'.$data['moneda'].'</td>
						<td>'.$data['cuota_mat'].'</td>
						<td>'.$data['tarjetas'].'</td>
						<td>'.$data['monto'].'</td>

					  </tr>';
						$contador++;
						$totalmant=$totalmant+$data['cuota_mat'];
						$totaltarjetas=$totaltarjetas+$data['tarjetas'];
						$grantotal=$grantotal+$data['monto'];

			}	
			$rp.='<tr>
			       <td colspan="6" style="text-align:right;"><b>Totales:</b></td>
			       <td><b>'.$data['moneda'].'<b></td>
			       <td><b>'.$totalmant.'<b></td>
			       <td><b>'.$totaltarjetas.'<b></td>
			       <td><b>'.$grantotal.'<b></td>
			     </tr>';
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

	Public function autocompleteclientes() {
		$this->load->model('RepIngresos_Model','MAN',true);
	    $frase = $this->input->post('cliente');
	    $frases = str_replace(' ', '%', $frase);
	    $listado = $this->MAN->TraeClientes($frases);
	    $response['status'] = 200;

	        foreach ($listado['data'] as $ln) {
	            $items[utf8_encode($ln['id_identidad'])]= utf8_encode(trim("[".$ln['id_identidad']. "] - ".$ln['ncliente']));
	        }
	        $result = array();

	        foreach ($items as $key=>$value) {
	            array_push($result, array("id"=>$key,  "value"=>strip_tags($value) ) );
	        }

	    echo json_encode($result);
	}

	public function generar_excel($fini,$ffin,$cliente){
		$this->load->model('RepIngresos_Model','MAN',true);
	    $datasect=$this->MAN->Reporte($fini,$ffin,$cliente);
	    if($datasect['status']==200){
	    	$contador=1;
	        //Cargamos la librería de excel.
	        $this->load->library('Excel'); $this->excel->setActiveSheetIndex(0);
	        $this->excel->getActiveSheet()->setTitle('Reporte de Ingresos');
	        
	        //Contador de filas
	        $contador = 1;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(100);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
	        //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'No.');
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Recibo');
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Cliente');
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Casa');
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Sector');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Fecha Pago');
	        $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Moneda');
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Mantenimiento');
	        $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Tarjetas');
	        $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Monto');
	        //Definimos la data del cuerpo.    
	        $contadorln=1;    
	        foreach ($datasect['data'] as $data) {
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}",$contadorln);
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}",$data['recibo']);
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}",$data['cliente']);
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}",$data['ncasa']);
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}",$data['nsector']);
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}",$data['fpago']);
	        $this->excel->getActiveSheet()->setCellValue("G{$contador}",$data['moneda']);
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}",$data['cuota_mat']);
	        $this->excel->getActiveSheet()->setCellValue("I{$contador}",$data['tarjetas']);
	        $this->excel->getActiveSheet()->setCellValue("J{$contador}",$data['monto']);
	        $contadorln++;
	        }
	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Rep_Ingresos.xls";
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
