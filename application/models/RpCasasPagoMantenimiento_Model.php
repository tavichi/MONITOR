<?php  
Class RpCasasPagoMantenimiento_Model extends CI_Model {

    public function Sectores() {
        $query = "SELECT lpad(trim(nombre),'20','0') as orden,id_sector,codigo 
        					FROM dbs_sector 
        					WHERE id_estados=1";
        return $this->db->dropdown_array($query, 'id_sector', 'codigo','Seleccione Sector',0);
    }

    public function Casas($sector) {
        $query = "SELECT orden, id_casa, numero
									FROM(
										SELECT lpad(trim(numero),'20','0') as orden, id_casa, numero 
										FROM dbs_casa 
										WHERE id_sector=$sector
									)t1 ORDER BY orden ASC;";

        return $this->db->dropdown_array($query, 'id_casa', 'numero','Seleccione Casa',0);
     }

    public function TipoDireccion() {
      $query = "SELECT id_tipodireccion as cod, nombre 
								FROM dbs_tipodireccion;";

      return $this->db->dropdown_array($query, 'cod', 'nombre','Seleccione',0);
    }


	 	Public function InfoPagos(
	 														$sector, 
															$casa, 
															$codigo, 
															$numero1, 
															$tiponum, 
															$numero2, 
															$numero3, 
															$numero4
														){
	 		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
			);
			$filtroCasa = '';
			$filtroCodigo = '';
			$filtroSector = '';
			$filtronumero1 = '';
			$filtrotiponum = '';
			$filtronumero2 = '';
			$filtronumero3 = '';
			$filtronumero4 = '';

	 		if($casa != 0 && $casa != '' && $casa != null)
	 			$filtroCasa = " AND id_casa = ".$casa;

	 		if($codigo != 0 && $codigo != '' && $codigo != null)
	 			$filtroCodigo = " AND codigo_seg = ".$codigo;

	 		if($sector != 0 && $sector != '' && $sector != null)
	 			$filtroSector = " AND id_sector = ".$sector;

	 		if($numero1 != '' && $numero1 != null)
	 			$filtronumero1 = " AND numcalleave = ".$numero1;

	 		if($tiponum != 0 && $tiponum != '' && $tiponum != null)
	 			$filtrotiponum = " AND id_tipodireccion = ".$tiponum;

	 		if($numero2 != '' && $numero2 != null)
	 			$filtronumero2 = " AND UPPER(literal) = '".$numero2."'";

	 		if($numero3 != '' && $numero3 != null)
	 			$filtronumero3 = " AND numcasa1 = ".$numero3;

	 		if($numero4 != '' && $numero4 != null)
	 			$filtronumero4 = " AND numcasa2 = ".$numero4;

	 		$query="SELECT 	id_asignacasa, sector, casa, codigo_seg, dir_catastro, nombrecliente, estado, 
			 								id_casa, id_sector, fecha, id_identidad, numcalleave, 
			 								id_tipodireccion, literal, numcasa1, numcasa2, mes, anno, falta,
			 								MONTH(falta) as mesalta, YEAR(falta) as annoalta
							FROM dbv_pagocasas 
							WHERE 1 = 1
							$filtroSector
							$filtroCasa
							$filtroCodigo
							$filtronumero1
							$filtrotiponum
							$filtronumero2
							$filtronumero3
							$filtronumero4 
							ORDER BY anno DESC, mes DESC LIMIT 1;";

		 $result=$this->db->query($query);
		 $rep=$result->result_array();

		 	if ($result->num_rows()>0){
		    $response['status']=200;
		    $response['data']=$rep;
		    $response['message']='';
		    return $response;
		 	}else{
		 		$response['status']=401;
		 		$response['message']='Datos no encontrados para mostrar';
		 		$response['data']='';
		 		return $response;
		 	}
	 	}	 

	 Public function llena_detalle($id_casa){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 
	 }	

	Public function Telefonos($id_identidad){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query="SELECT CONCAT(b.nombre,': ',a.numero) as contacto
						FROM dbs_telefono a
						INNER JOIN dbs_tipotel b on(b.id_tipotel=a.id_tipotel)
						WHERE id_identidad=$id_identidad
						AND a.f_baja is null;";

		 $result=$this->db->query($query);
		 $rep=$result->result_array();

		 if ($result->num_rows()>0){
		    $response['status']=200;
		    $response['data']=$rep;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	}

	Public function DiaPago(){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query="SELECT diapago, DAY(NOW()) as hoy, MONTH(NOW()) as mesact, YEAR(NOW()) as annoact,
									 (CASE WHEN diapago >= DAY(NOW()) THEN 1 ELSE 2 END) as bandera
						FROM dbs_diapago
						WHERE estado = 1;";

		 $result=$this->db->query($query);
		 $rep=$result->result_array();

		 if ($result->num_rows()>0){
		    $response['status']=200;
		    $response['data']=$rep;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	}
}

