<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<style type="text/css">
		.img-rounded{
			display: none;
		}
	</style>
	<section class="container">

		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-md-9 col-lg-9">
		    	<h2><?php echo $nombreopcion?>&nbsp;<small><a class="fa fa-info-circle" data-toggle="tooltip" title="Manual de Usuario" id="ManualUsuario" href="<?php echo base_url(); ?>assets/Manuales/Manual de Usuario 0011 - Reporte de Pagos Garita.pdf" target="_blank"></a></small></h2>
		    </div>
			</div>
			<div class="row">
				<div class="col-sm-3 col-md-9 col-lg-12">
				  <button type="button" class="btn btn-success  btn-md" id="cargardata">
				    <span class="fa fa-refresh"></span> Buscar
				  </button> 
	    	</div>
			</div>
			<div class="clear-fix">&nbsp;</div>
			<div class="row">
				<div class="col-lg-6" style="padding-left: 5px; padding-right: 5px">
					<div class="panel panel-default">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-home" aria-hidden="true"></span> Código-Sector-Casa:
						</div>
				  	<div class="panel-body" style="max-height: 450px; overflow: auto">
							<div class="col-sm-3 col-md-9 col-lg-4">
								<div class="form-group">
							  	<label for="usr">Código Seguridad:</label>
							  	<input class="form-control" id="codseg" placeholder="Ingrese el código">
								</div>
							</div>
							<div class="col-sm-3 col-md-9 col-lg-4">
								<div class="form-group">
								  <label for="usr">Sector:</label>
								  <select class="form-control" id='CmbSector' onchange="BuscaCasa()">
									  <?php echo $sectores?>
									</select>
								</div>
							</div>
							<div class="col-sm-3 col-md-9 col-lg-4">
								<div class="form-group">
								  <label for="usr">Casa:</label>
								  <select class="form-control" id='cmbCasa'>
										<option value="0">Seleccione Casa</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<div class="col-lg-6" style="padding-left: 5px; padding-right: 5px">
				<div class="panel panel-default">
					<div class="panel-heading">
						<span class="glyphicon glyphicon-home" aria-hidden="true"></span> Dirección Catastro:
					</div>
				  	<div class="panel-body" style="max-height: 450px; overflow: auto">
					    <div class="col-lg-2">
					    	<div class="form-group">
					    		<label></label>
				  				<input class="form-control" id="direct1" placeholder="00" maxlength="2">
								</div>							
							</div>
							<div class="col-lg-4">
				  			<div class="form-group">
					    		<label></label>
					  			<select class="form-control" id='CmbTipoDir'>
									  <?php echo $tipodireccion?>
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
					    		<label></label>
				  				<input class="form-control" id="direct2" placeholder="--" maxlength="2">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
					    		<label></label>
									<table>
										<tr>
											<td><input class="form-control" id="direct3" placeholder="00" maxlength="2"></td>
											<td> - </td>
											<td><input class="form-control" id="direct4" placeholder="00" maxlength="2"></td>
										</tr>
									</table>
								</div>	
							</div>
				  	</div>
				</div>
				</div>
			</div>
			<div class="clear-fix">&nbsp;</div>
			<div class="row bg-info">
				<div class="col-lg-12">
					<div class="col-lg-12">
								
					</div>
				</div>
				<div class="col-lg-12">
					<div class="col-lg-8">
						<div class="col-lg-12">
							<div class="col-sm-3 col-md-9 col-lg-12">
								<div class="form-group">
							  	<label for="usr">Cliente:</label>
							  	<input class="form-control" id="lbcliente" readonly="">
								</div>
							</div>	
						</div>
						<div class="col-lg-12">
							<div class="col-sm-3 col-md-9 col-lg-6">
								<div class="form-group">
							  	<label for="usr">Sector-Casa:</label>
							  	<input class="form-control" id="lbsectorcasa" readonly="">
								</div>
							</div>
							<div class="col-sm-3 col-md-9 col-lg-6">
								<div class="form-group">
							  	<label for="usr">Dirección Catastro:</label>
							  	<input class="form-control" id="lbdircastro" readonly="">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="col-sm-3 col-md-9 col-lg-6">
								<div class="form-group">
							  	<label for="usr">Estado de pago Cliente:</label>
							  	<input class="form-control" id="lbestado" readonly="">
								</div>
							</div>
							<div class="col-sm-3 col-md-9 col-lg-6">
								<div class="form-group">
							  	<label for="usr">Código Seguridad:</label>
							  	<input class="form-control" id="lbcodseg" readonly="">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="col-sm-3 col-md-9 col-lg-6">
								<div class="form-group">
							  	<label for="usr">Fecha Ultimo Pago:</label>
							  	<input class="form-control" id="lbpago" readonly="">
								</div>
							</div>
							<div class="col-sm-3 col-md-9 col-lg-6">
								<div class="form-group">
							  	<label for="usr">Contacto:</label>
							  	<textarea class="form-control" id="lbcontacto" readonly=""></textarea>
								</div>
							</div>
						</div>
					</div>	
					<div class="col-lg-2">
						<div class="clear-fix">&nbsp;</div>
						<img src="<?php echo base_url(); ?>/imagenes/verde.JPG" class="img-fluid img-rounded" alt="Responsive image" id="img1">
						<img src="<?php echo base_url(); ?>/imagenes/amario.JPG" class="img-fluid img-rounded" alt="Responsive image" id="img2">
						<img src="<?php echo base_url(); ?>/imagenes/rojo.JPG" class="img-fluid img-rounded" alt="Responsive image" id="img3"> 
					</div>		
				</div>
			</div>
			<div class="clear-fix">&nbsp;</div>
   </section>
<script type="text/javascript">
  $(document).ready(function(){

  	$("#codseg").numeric(10);
  	$("#direct1").numeric(10);
  	$("#direct3").numeric(10);
  	$("#direct4").numeric(10); 
    $("#CmbSector").select().focus();
    $(".img-rounded").hide();


    jQuery("#direct2").keyup(function(){
    	$("#direct2").val($("#direct2").val().toUpperCase());
    	this.value = this.value.replace(/[^A-Z]/g,'');
    });
    
    $("#cargardata").click(function(){
      	var sector = $("#CmbSector").val();
      	var codigo = $("#codseg").val();
      	var casa   = $("#cmbCasa").val();
      	var numero1 = $("#direct1").val();
      	var tiponum = $("#CmbTipoDir").val();
      	var numero2 = $("#direct2").val();
      	var numero3 = $("#direct3").val();
      	var numero4 = $("#direct4").val();
      	var banderaDirec = true;

      	if(numero1 == "" || tiponum == "" || numero3 == "" || numero4 == ""){
      		banderaDirec = false;
      	}


        if(codigo == "" && sector==0 && casa == 0 && banderaDirec == false){
					swal("Terra System",'Ingrese un valor en los campos de busqueda',"warning");
					return false;
        }else if(sector != 0 && casa == 0){
        	swal("Terra System",'Seleccione una Casa',"warning");
					return false;
        }else{
          $.ajax({
            url: '<?php echo base_url('RpCasasPagoMantenimientoAjax/cargardatos');?>',
            type:'POST',
            data: {
    				numero1: numero1,
    				tiponum: tiponum,
    				numero2: numero2,
    				numero3: numero3,
    				numero4: numero4,
    				sector: sector,
    				codigo: codigo,
    				casa: casa
    			},
            success: function(response){
              var results = jQuery.parseJSON(response);
              if (results.status == 401 ){
                swal("Terra System",results.message,"warning");
                $("#reporte").empty().append('');
                $("#lbcliente").val('');
                $("#lbsectorcasa").val('');
                $("#lbdircastro").val('');
                $("#lbestado").val('');
                $("#lbcodseg").val('');
                $("#lbpago").val('');
                $("#lbcontacto").val('');
              }else{
                $("#reporte").empty().append(results.data);
                $("#lbcliente").val(results.data.Cliente);
                $("#lbsectorcasa").val(results.data.SectorCasa);
                $("#lbdircastro").val(results.data.DirecCatastro);
                $("#lbestado").val(results.data.EstadoPagoCliente);
                $("#lbcodseg").val(results.data.CodSeguridad);
                $("#lbpago").val(results.data.FechaPago);
                $("#lbcontacto").val(results.data.Contacto);
                $(".img-rounded").hide();
                if(results.data.ImgEst <= 0)
                	$('#img1').show();
                if(results.data.ImgEst == 1)
                	$('#img2').show();
                if(results.data.ImgEst >= 2)
                	$('#img3').show();
              }
            } 
        	});
        }
      });

      // presionando Enter
      $("#CmbSector").on("keydown", function (e) {
        if (e.keyCode === 13) {  
          $("#cmbCasa").focus();
        }
      });

      $("#codseg").on("keydown", function (e) {
        if (e.keyCode === 13) {  
          $("#CmbSector").focus();
        }
      });

      $("#cmbCasa").on("keydown", function (e) {
        if (e.keyCode === 13) {  
          $("#direct1").focus();
        }
      });
      $("#direct1").on("keydown", function (e) {
        if (e.keyCode === 13) {  
          $("#CmbTipoDir").focus();
        }
      });
      $("#CmbTipoDir").on("keydown", function (e) {
        if (e.keyCode === 13) {  
          $("#direct2").focus();
        }
      });
      $("#direct2").on("keydown", function (e) {
        if (e.keyCode === 13) {  
          $("#direct3").focus();
        }
      });
      $("#direct3").on("keydown", function (e) {
        if (e.keyCode === 13) {  
          $("#direct4").focus();
        }
      });
              
			$(function() {
		  	var theTable = $('#tablarep')
		  	theTable.find("tbody > tr").find("td:eq(1)").mousedown(function(){
		    	$(this).prev().find(":checkbox").click()
		  	});
		  	$("#filter").keyup(function() {
		    	$.uiTableFilter( theTable, this.value );
		  	})
			  $('#filter-form').submit(function(){
			    theTable.find("tbody > tr:visible > td:eq(1)").mousedown();
			    return false;
			  }).focus(); //Give focus to input field
			});
  });

function mostrardetalle(){
	$('.detallemonto').click(function(){
		id_casag=this.id;
		llena_detalle();
        $("#dialog_detalle").modal('show');
	});
}

function llena_detalle(){    	
  $.ajax({
    url: '<?php echo base_url('RpCasasPagoMantenimientoAjax/llena_detalle');?>',
    type:'POST',
    data: {id_casa:id_casag},
    success: function(response){
      var results = jQuery.parseJSON(response);
      if (results.status == 401 ){
        $("#reporte_detalle").empty();
      }else{
        $("#reporte_detalle").empty().append(results.data);
      }
    } 
  });    	
}


function BloquearPantalla(parametros){
	if (parametros==1 ){ //cargando
		$.blockUI({ message: '<h1><img src="<?php echo base_url(); ?>assets/imagenes/waiting.gif" /> </h1>' });
	}
	if(parametros==2){ // procesando
		$.blockUI({ message: '<h1><img src="<?php echo base_url(); ?>assets/imagenes/cortinilla2.gif" /> </h1>' });	
	}
}

function DesbloquearPantalla(){
	$.unblockUI();
}

function BuscaCasa(){
	var sector = $('#CmbSector').val();
	if(sector == 0 || sector == -1 ){
		$("#cmbCasa").empty().html('<option value=0>Seleccione Casa</option>');
	}else{
		$.ajax({
      url: '<?php echo base_url('RpCasasPagoMantenimientoAjax/cargardaCasas');?>',
      type:'POST',
      data: {sector:sector},
      success: function(response){
        var results = jQuery.parseJSON(response);
        if (results.status == 401 ){
          swal("Terra System",results.message,"warning");
        }else{
          $("#cmbCasa").empty().html(results.data);
        }
      } 
  	});
	}
}

</script>