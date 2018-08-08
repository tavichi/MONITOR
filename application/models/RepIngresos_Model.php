<?php  
Class RepIngresos_Model extends CI_Model {


	 Public function TraeClientes($complemento){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $query=$this->db->query("SELECT ncliente,id_identidad 
									from (
									SELECT CONCAT_WS(' - ',CONCAT_WS(' ',a.nombres,a.apellidos),a.nit ) as ncliente, a.id_identidad 
									from dbs_identidad a 
									join dbs_identidadr b on (b.id_identidad=a.id_identidad and b.id_rol=1)
									where a.id_estadoide=1
									ORDER BY ncliente) a 
									where ncliente like UPPER('%".$complemento."%') LIMIT 5");
		 $clientes=$query->result_array();

		    $response['status']=200;
		    $response['data']=$clientes;
		    $response['message']='';
		    return $response;		 
	 }

	 Public function Reporte($fechaini,$fechafin,$complemento){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
	 	if ($complemento>0){
	 		$agregar="AND b.id_cliente=".$complemento;
	 	}else{
	 		$agregar="";
	 	}
	 	$query="SELECT recibo,cliente,nsector,ncasa,fpago,monto, sum(cuota) as cuota_mat,sum(tarjeta) as tarjetas,moneda ,IF(nsector REGEXP '[A-Z]$','A','B') as abr from (
				SELECT b.recibo,CONCAT_WS(' - ',CONCAT_WS(' ',d.nombres,d.apellidos)) as cliente,	f.nombre AS nsector,
					   c.numero AS ncasa,CONVERT(DATE_FORMAT(a.f_pago, '%d %M %Y %T'),CHARACTER) AS fpago, a.monto, 
					   e.simbolo as moneda,
					   IF(g.id_producto = 1, g.base+g.iva, 0) as Cuota,								
					   IF(g.id_producto = 2, g.base+g.iva, 0) as Tarjeta
				from dbs_pagorecibo a
				INNER JOIN dbs_recibo b on (b.recibo=a.recibo and b.id_empresa=a.id_empresa and b.id_serie=a.id_serie and b.id_tipodoc=a.id_tipodoc)
				INNER JOIN dbs_casa c on (c.id_casa=b.id_casa)
				INNER JOIN dbs_identidad d on (d.id_identidad=b.id_cliente)
				INNER JOIN dbs_moneda e on (e.id_moneda=a.id_moneda)
				INNER JOIN dbs_sector f on (f.id_sector=c.id_sector)
				INNER JOIN dbs_detallerecibo g on (g.recibo=b.recibo and g.id_empresa=b.id_empresa and g.id_serie=b.id_serie and g.id_tipodoc=b.id_tipodoc)
				INNER JOIN dbs_producto h on (h.id_producto=g.id_producto)
				where 1=1 
				And date(a.f_pago) BETWEEN '".$fechaini."' and '".$fechafin."' ". $agregar."
				GROUP BY b.recibo,g.id_producto) a
				GROUP BY recibo
				order by  abr ,lpad(nsector,20,0)";

		//print_r("<pre>".$query."</pre>");die();
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

