<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', '1');
 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session'));
 }

Class RpCasasPagoMantenimiento extends CI_Controller {
	Public function Index(){
		$this->load->model('RpCasasPagoMantenimiento_Model','GENR',true);
		$data = array();
		$data['nombreopcion']='Reporte de Pagos de Mantenimiento';
		/*$data['usuario']=$this->session->userdata('usuario');
		$data['opciones']=$this->session->userdata('menu');*/
		$data['sectores']=$this->GENR->Sectores();
		$data['tipodireccion']=$this->GENR->TipoDireccion();
		$this->load->view('header/headerMonitor.php',$data);
		$this->load->view('Body/RpCasasPagoMantenimientoV.php',$data);
		//$this->load->view('footer/footer.php',$data);

	}
}



?>