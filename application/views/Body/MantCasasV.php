<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
	  ?>

	<section class="container">

		<div class="container">
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-9">
		    	<h2><?php echo $nombreopcion?>&nbsp;<small><a class="fa fa-info-circle" data-toggle="tooltip" title="Manual de Usuario" id="ManualUsuario" href="<?php echo base_url(); ?>assets/Manuales/Manual de Usuario 0006 - Control de Residencias.pdf" target="_blank"></a></small>
		    	</h2>
		    </div>
		   <br>
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-12">
			  <button type="button" class="btn btn-success  btn-md" id="cargardata">
			    <span class="fa fa-refresh"></span> Cargar
			  </button>
			  <button type="button" class="btn btn-info btn-md" id="guardadata">
			    <span class="fa fa-save"></span> Guardar
			  </button>
			  <button type="button" class="btn btn-warning btn-md" id="borradata">
			    <span class="fa fa-save"></span> Borra Datos
			  </button>
			  <button type="button" class="btn btn-default btn-md" id="reinicio">
			    <span class="fa fa-cogs"></span> Reiniciar Codigos
		    </div>
		    <br><br><br><br><br>
		    <div class="col-sm-3 col-md-9 col-lg-12">
				<form class="form-horizontal" >
				  <div class="form-group">
					    <label class="col-lg-2 control-label">Sector:</label>
					    <div class="col-lg-4">
					      <select class="form-control" id='CmbSector'>
					      	<?php echo $sectores?>
					      </select>
					    </div>
					    <label for="disabledTextInput" class="col-lg-1 control-label">No Casa:</label>
					    <div class="col-lg-3">
					      <input class="form-control" id="nocasa" type="text" placeholder="Ingrese Codigo de Casa">
					    </div>
				   </div>
					<div class="form-group">
					    <label for="disabledTextInput" class="col-lg-2 control-label">Dir. Catastro:</label>
					    <div class="col-lg-8">
					      <input class="form-control" id="dircatastro" type="text" placeholder="Ingrese Direccion">
					    </div>
				    </div>
					<div class="form-group">
					    <label for="disabledTextInput" class="col-lg-2 control-label">Codigo Seguridad:</label>
					     <div class="col-lg-3">
					      <input class="form-control" id="codigoSec" type="text" placeholder="Ingrese Codigo de Seg" readonly="true">
					     </div>
					      <div class="col-lg-6">
					     		 <button type="button" class="btn btn-primary btn-md" id="gencodigo">
			    					<span class="fa fa-cogs"></span> Generar Codigo
			 			  		 </button>
					      </div>
				  </div>
				</form>
 		    </div>
 		     <br><br><br><br><br><br><br><br><br>
		    <div class="col-sm-3 col-md-9 col-lg-12">
				<form class="form-horizontal" >
				  <div class="form-group">	
					    <label for="disabledTextInput" class="col-lg-9 control-label">Buscar:</label>
					    <div class="col-lg-3">
					      <input class="form-control" id="filter" type="text" placeholder="Ingrese Valor a Buscar en Tabla">
					    </div>
				  </div>
				</form>
 		    </div>
		  </div>
		  <div class="row">
				<div class="table-responsive">
			    	<table class="table table-hover" id="tablarep">
					 	<thead>
					 		<th>No.</th>
					 		<th>Sector </th>
					 		<th>No. Casa</th>
					 		<th>Dir. Catrastro</th>
					 		<th>Estado</th>
					 		<th>Codigo Seg.</th>
					 		<th>F. Alta</th>
					 		<th>Opciones</th>
					 	</thead>
					 	<tbody id='reporte'>
					 		
					 	</tbody>
					</table>
			    </div>
		  </div>
		</div>
   </section>
<!-- MODAL- ACTUALIZACIONES -->
  <div class="modal fade" id="modalactualiza" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Actualizaci&oacute;n de Codigo de Seguridad</h4>
        </div>
        <div class="modal-body">
           <div class="container">
           		<div class="row">
           			<div class="col-lg-8">
           				<form class="form-horizontal">
							<div class="form-group">
							    <label for="disabledTextInput" class="col-lg-2 control-label">Codigo Seguridad:</label>
							     <div class="col-lg-3">
							      <input class="form-control" id="codigoSecModal" type="text" placeholder="Ingrese Codigo de Seg" readonly="true">
							     </div>
							      <div class="col-lg-3">
							     		 <button type="button" class="btn btn-primary btn-md" id="gencodigomodal">
					    					<span class="fa fa-cogs"></span> Generar Codigo
					 			  		 </button>
							      </div>
						  </div>
           					<div class="form-group">
		           				<label for="disabledTextInput" class="col-lg-2 control-label"> Motivo <span class="glyphicon glyphicon-edit"></span> :</label>
							    <div class="col-lg-6">
							    	<textarea class="form-control" id="txtmotivo" rows="2" maxlength="100" placeholder="Ingrese Motivo de Desasignacion"></textarea>
							    </div>
							</div>
					    </form>
           			</div>
           		</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning"  id="asigna">Actualizar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->
<input type="hidden" id="casaactualizacod" ></input>
<script type="text/javascript">
  $(document).ready(function(){
    $("#CmbSector").select().focus();
        $("#cargardata").click(function(){
        	if( $("#CmbSector").val()==0){
				swal("Terra System",'Debe Seleccionar un Sector',"warning");
				return false;
        	}else{
	              $.ajax({
	                url: '<?php echo base_url('MantCasasAjax/cargardatos');?>',
	                type:'POST',
	                data: {sector:$("#CmbSector").val()},
	                success: function(response){
	                  var results = jQuery.parseJSON(response);
	                    if (results.status == 401 ){
	                    	swal("Terra System",results.message,"warning");
	                  }else{
	                    $("#reporte").empty().append(results.data);
	                    inactivarcasa();
	                    actualizacod();
	                    }
	                } 
	            });
        	}
 
        });

        $("#guardadata").click(function(){
        	
        	if( ($("#nocasa").val()=='') || ($("#dircatastro").val()=='') || ($("#codigosec").val()=='' )|| ($("#CmbSector").val()==0 ) )
        	 {	
        	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
        	  return false;
        	 }else{
					$.ajax({
				                url: '<?php echo base_url('MantCasasAjax/insertadatos');?>',
				                type:'POST',
				                data: {nocasa:$("#nocasa").val(),dircatastro:$("#dircatastro").val(),sector:$("#CmbSector").val(),codigosec:$("#codigoSec").val()},
				                success: function(response){
				                  var results = jQuery.parseJSON(response);
				                    if (results.status == 200){
				                    swal('Terra System',results.message,'success');
				                    $("#cargardata").click();
				                  }else{
				                  	swal('Terra System',results.message,'warning');
				                    }
				                } 
				            }); 
        	 }


        });
        $("#gencodigo").click(function(){
        	
					$.ajax({
				                url: '<?php echo base_url('MantCasasAjax/generacodigo');?>',
				                type:'POST',
				                data: {},
				                success: function(response){
				                  var results = jQuery.parseJSON(response);
				                  if (results.status == 200){
				                    $("#codigoSec").val(results.data);
				                  }else{
				                  	$("#gencodigo").click();
				                    }
				                } 
				            }); 
        	 


        });

        $("#gencodigomodal").click(function(){
        	
					$.ajax({
				                url: '<?php echo base_url('MantCasasAjax/generacodigo');?>',
				                type:'POST',
				                data: {},
				                success: function(response){
				                  var results = jQuery.parseJSON(response);
				                  if (results.status == 200){
				                    $("#codigoSecModal").val(results.data);
				                  }else{
				                  	if (results.status == 401){
				                  	swal('Terra System',results.message,'warning');
				                  	setTimeout(Reintentar, 3000);
				                  	   
				                  	}else{
				                  		swal('Terra System',results.message,'warning');
				                  	}
				                  	
				                    }
				                } 
				            }); 
        	 


        });
        $("#asigna").click(function(){
        	
        	if( ($("#txtmotivo").val()=='') || ($("#codigoSecModal").val()=='')  )
        	 {	
        	  swal('Terra System','Debe Completar Los Datos para Actualizar','warning');
        	  return false;
        	 }else{
					$.ajax({
					                url: '<?php echo base_url('MantCasasAjax/actualizarcod');?>',
					                type:'POST',
					                data: {nocasa:$("#casaactualizacod").val(),codigosec:$("#codigoSecModal").val(),motivo:$("#txtmotivo").val()},
					                success: function(response){
					                  var results = jQuery.parseJSON(response);
					                    if (results.status == 200){
					                    swal('Terra System',results.message,'success');
					                    $("#cargardata").click();
					                    $("#modalactualiza").modal('hide');
					                  }else{
					                  	swal('Terra System',results.message,'warning');
					                    }
					                } 
							 }); 
        	 }


        });

		$("#reinicio").click(function(){
				idcasa=this.id;

		swal("Realmente Desea Reiniciar los Codigos de Seguridad?", {
		  icon: "warning",	
		   buttons: true,
		  dangerMode: true,
		})
		.then((value) => {
		  switch (value) {
		    case true:
				$.ajax({
			            url: '<?php echo base_url('MantCasasAjax/Reinicio');?>',
			            type:'POST',
			            data: {idcasa:idcasa},
			            success: function(response){
			              var results = jQuery.parseJSON(response);
			                if (results.status == 200){
							swal('Terra System',results.message,'success');
			              }else{
							swal('Terra System',results.message,'warning');
			                }
			            } 
			        }); 

		      break;
		  }
		});
		});
        $("#borradata").click(function(){
        	location.reload();
        })
        // presionando Enter
        $("#CmbSector").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#nocasa").focus();
            }
        });
        $("#nocasa").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#dircatastro").focus();
            }
        });
        $("#dircatastro").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#gencodigo").focus();
            }
        });
        $("#gencodigo").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#guardadata").focus();
            }
        });

        $("#codigoSecModal").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#txtmotivo").focus();
            }
        });
        $("#txtmotivo").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#asigna").focus();
            }
        });

		$('#modalactualiza').on('shown.bs.modal', function () {
		    $('#codigoSecModal').focus();
		});
		$('#modalactualiza').on('hidden.bs.modal', function () {
		    $('#codigoSecModal').val('');
		     $('#txtmotivo').val('');
		    
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



function inactivarcasa(){
	$(".eliminacasa").click(function(){
		idcasa=this.id;

swal("Realmente Desea Dar de Baja Esta Casa?", {
  icon: "warning",	
   buttons: true,
  dangerMode: true,
})
.then((value) => {
  switch (value) {
    case true:
		$.ajax({
	            url: '<?php echo base_url('MantCasasAjax/inactivacasas');?>',
	            type:'POST',
	            data: {idcasa:idcasa},
	            success: function(response){
	              var results = jQuery.parseJSON(response);
	                if (results.status == 200){
					swal('Terra System',results.message,'success');
	                $("#cargardata").click();
	              }else{
					swal('Terra System',results.message,'warning');
	                }
	            } 
	        }); 

      break;
  }
});
});
}
function actualizacod(){
	$(".actcod").click(function(){
		idcasa=this.id;
		$("#casaactualizacod").val(idcasa);
		$("#modalactualiza").modal('show');
	});
}
function Reintentar(){
$("#gencodigomodal").click();
}
</script>