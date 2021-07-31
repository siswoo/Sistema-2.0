<?php
session_start();
if(@$_SESSION["id"]=='' or @$_SESSION["id"]==null){
	include("../expirada1.php");
	exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/dataTables.bootstrap4.min.css">
    <link href="../resources/fontawesome/css/all.css" rel="stylesheet">
    <title>Camaleon Sistem</title>
  </head>
<body>

<?php
$ubicacion='modelos';
include("../script/conexion.php");
include("../header.php");
$sqlub1 = "SELECT * FROM modulos WHERE nombre = '".$ubicacion."'";
$procesoub1 = mysqli_query($conexion,$sqlub1);
while($rowub1 = mysqli_fetch_array($procesoub1)) {
	$id_moduloub1 = $rowub1["id"];
}
$sqlp2 = "SELECT * FROM funciones_usuarios WHERE id_usuarios = ".$_SESSION["id"]." and id_modulos = ".$id_moduloub1;
$procesoub2 = mysqli_query($conexion,$sqlp2);
while($rowub2 = mysqli_fetch_array($procesoub2)) {
	$modulo_ver = $rowub2["ver"];
	$modulo_crear = $rowub2["crear"];
	$modulo_modificar = $rowub2["modificar"];
	$modulo_eliminar = $rowub2["eliminar"];
}
?>

<form id="formulario1" method="GET" action="index.php">
	<div class="row mt-2 mb-2">
		<div class="col-12 text-center" style="font-size: 18px; font-weight: bold;">
			Listado de Modelos
		</div>
		<div class="col-4 form-group form-check mt-3">
			<label for="fc" style="font-weight: bold; font-size: 14px;">Cantidad de Consultas</label>
			<select class="form-control" id="fc" name="fc" required>
				<option value="50" <?php if(@$_GET["fc"]==50){echo "Selected"; } ?>>50</option>
				<option value="100" <?php if(@$_GET["fc"]==100){echo "Selected"; } ?>>100</option>
				<option value="200" <?php if(@$_GET["fc"]==200){echo "Selected"; } ?>>200</option>
				<option value="500" <?php if(@$_GET["fc"]==500){echo "Selected"; } ?>>500</option>
				<option value="1000" <?php if(@$_GET["fc"]==1000){echo "Selected"; } ?>>1000</option>
				<option value="0" <?php if(@$_GET["fc"]=="0"){echo "Selected"; } ?>>Todos</option>
			</select>
		</div>
		<div class="col-4 form-group form-check mt-3">
			<label for="fs" style="font-weight: bold; font-size: 14px;">Sedes</label>
			<select class="form-control" id="fs" name="fs">
				<option value="">Todos</option>
				<?php
				$sql1 = "SELECT * FROM sedes";
				$proceso1 = mysqli_query($conexion,$sql1);
				while($row1 = mysqli_fetch_array($proceso1)) { ?>
					<option value="<?php echo $row1['id']; ?>" <?php if(@$_GET["fs"]==$row1['id']){echo "Selected"; } ?>><?php echo $row1['nombre']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-4 form-group text-center form-check mt-3">
			<label for="fc" style="font-weight: bold; font-size: 14px;">&nbsp;</label>
			<p>
				<button type="submit" class="btn btn-primary">Filtrar</button>
			</p>
		</div>
	</div>
</form>

<div class="col-12" style="margin-top: 2rem;">
	<table id="example" class="table row-border hover table-bordered" style="font-size: 12px;">
		<thead>
			<tr>
				<th class="text-center">ID</th>
				<th class="text-center">Nombre Completo</th>
				<th class="text-center">T Doc</th>
				<th class="text-center">Nº Doc</th>
				<th class="text-center">Género</th>
				<th class="text-center">Estatus</th>
				<th class="text-center">Sede</th>
				<th class="text-center">Fecha Inicio</th>
				<th class="text-center">Opciones</th>
			</tr>
		</thead>
		<tbody id="resultados">
			<?php
			$html_fc1 = '';
			$html_fs1 = '';
			
			if(@$_GET["fc"]>1){
				$html_fc1 .= ' LIMIT '.$_GET["fc"];
			}else if(@$_GET["fc"]=="0"){
				$html_fc1 .= '';
			}else{
				$html_fc1 .= ' LIMIT 50';
			}

			if(@$_GET["fs"]>1){
				$html_fs1 .= ' and sede = '.$_GET["fs"];
			}else if(@$_GET["fs"]==""){
				$html_fs1 .= '';
			}else{
				$sql7 = "SELECT * FROM datos_nominas WHERE id = ".$_SESSION["id"];
				$proceso7 = mysqli_query($conexion,$sql7);
				while($row7 = mysqli_fetch_array($proceso7)) {
					$nomina_sede = $row7["sede"];
				}
				$html_fs1 .= ' and sede =  '.$nomina_sede;
			}

			$consulta2 = "SELECT * FROM usuarios WHERE estatus_modelo>0 ORDER BY fecha_creacion DESC ".$html_fc1;
			$resultado2 = mysqli_query( $conexion, $consulta2 );
			while($row2 = mysqli_fetch_array($resultado2)) {
				$id_usuario 			= $row2['id'];
				$documento_tipo 		= $row2['documento_tipo'];
				$documento_numero 		= $row2['documento_numero'];
				$nombre1 				= $row2['nombre1'];
				$nombre2 				= $row2['nombre2'];
				$apellido1 				= $row2['apellido1'];
				$apellido2 				= $row2['apellido2'];
				$genero 				= $row2['genero'];
				$correo_personal 		= $row2['correo_personal'];
				$telefono 				= $row2['telefono'];
				$direccion 				= $row2['direccion'];

				$sql3 = "SELECT * FROM datos_modelos WHERE id_usuarios = ".$id_usuario.$html_fs1;
				$proceso3 = mysqli_query($conexion,$sql3);
				$contador3 = mysqli_num_rows($proceso3);
				if($contador3>=1){
					while($row3 = mysqli_fetch_array($proceso3)) {
						$id_modelos = $row3["id"];
						$sede_id = $row3["sede"];
						$fecha_creacion = $row3["fecha_creacion"];
						$modelo_estatus = $row3["estatus"];
						$modelo_turno = $row3["turno"];
					}

					$sql4 = "SELECT * FROM sedes WHERE id = ".$sede_id;
					$proceso4 = mysqli_query($conexion,$sql4);
					while($row4 = mysqli_fetch_array($proceso4)) {
						$sede_nombre = $row4["nombre"];
					}

					$sql5 = "SELECT * FROM documento_tipo WHERE id = ".$documento_tipo;
					$proceso5 = mysqli_query($conexion,$sql5);
					while($row5 = mysqli_fetch_array($proceso5)) {
						$documento_tipo_nombre = $row5["nombre"];
					}

					if($modelo_estatus==1){
						$html_estatus1 = "Activo";
					}else{
						$html_estatus1 = "Inactivo";
					}

					echo '
						<tr>
							<td class="text-center" nowrap id="id_'.$id_usuario.'">'.$id_modelos.'</td>
							<td class="text-center" nowrap id="nombres_'.$id_usuario.'">'.$nombre1." ".$nombre2." ".$apellido1." ".$apellido2.'</td>
							<td class="text-center" id="documento_tipo_'.$id_usuario.'">'.$documento_tipo_nombre.'</td>
							<td class="text-center" id="documento_numero_'.$id_usuario.'">'.$documento_numero.'</td>
							<td class="text-center" nowrap id="genero_'.$id_usuario.'">'.$genero.'</td>
							<td class="text-center" id="estatus_'.$id_usuario.'">'.$html_estatus1.'</td>
							<td class="text-center" id="sede_'.$id_usuario.'">'.$sede_nombre.'</td>
							<td class="text-center">'.$fecha_creacion.'</td>
							<td class="text-center" id="opciones_'.$id_usuario.'">
								<i class="far fa-address-card" style="color:black; font-size: 30px; cursor:pointer;" data-toggle="modal" data-target="#exampleModal1" onclick="consultar_personal1('.$id_usuario.');"></i>
								<i class="far fa-image" style="color:black; font-size: 32px; cursor:pointer;" onclick="consultar_documentos('.$id_usuario.');"></i>
							</td>
						</tr>
					';
				}
			} ?>
		</tbody>
	</table>
</div>

<!-- Modal Editar Bancarios -->
	<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="form_modal_edit" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Datos Generales del Modelo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
					    	<input type="hidden" name="consulta1_id" id="consulta1_id">
						    <div class="col-12 form-group form-check">
							    <label for="consulta1_nombre">Nombre Completo</label>
							    <input type="text" id="consulta1_nombre" name="consulta1_nombre" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_documento_tipo">Documento Tipo</label>
							    <input type="text" name="consulta1_documento_tipo" id="consulta1_documento_tipo" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_documento_numero">Documento Número</label>
							    <input type="text" id="consulta1_documento_numero" name="consulta1_documento_numero" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_correo_personal">Correo</label>
							    <input type="text" id="consulta1_correo_personal" name="consulta1_correo_personal" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_telefono">Teléfono</label>
							    <input type="text" id="consulta1_telefono" name="consulta1_telefono" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_genero">Genero</label>
							    <input type="text" id="consulta1_genero" name="consulta1_genero" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_sede">Sede</label>
							    <input type="text" id="consulta1_sede" name="consulta1_sede" class="form-control" disabled>
						    </div>
						    
						    <div class="col-12 text-center" style="font-weight: bold; font-size: 22px;">Datos Bancarios</div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_banco_cedula">Cédula del Titular</label>
							    <input type="text" id="consulta1_banco_cedula" name="consulta1_banco_cedula" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_banco_nombre">Nombre del Titular</label>
							    <input type="text" id="consulta1_banco_nombre" name="consulta1_banco_nombre" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_banco_banco">Nombre del Banco</label>
							    <input type="text" id="consulta1_banco_banco" name="consulta1_banco_banco" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_bcpp">Pertenece la Cuenta</label>
							    <input type="text" id="consulta1_bcpp" name="consulta1_bcpp" class="form-control" disabled>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="consulta1_banco_tipo_documento">Tipo de Documento del Titular</label>
							    <input type="text" id="consulta1_banco_tipo_documento" name="consulta1_banco_tipo_documento" class="form-control" disabled>
						    </div>

						    <div class="col-12 text-center" style="font-weight: bold; font-size: 22px;">Datos Corporales</div>
							<div class="col-6 form-group form-check">
							    <label for="consulta1_altura">Altura</label>
							    <input type="text" id="consulta1_altura" name="consulta1_altura" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_peso">Peso</label>
							    <input type="text" id="consulta1_peso" name="consulta1_peso" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_tpene">Tamaño de Pene</label>
							    <input type="text" id="consulta1_tpene" name="consulta1_tpene" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_tsosten">Tamaño de Sosten</label>
							    <input type="text" id="consulta1_tsosten" name="consulta1_tsosten" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_tbusto">Tamaño de Busto</label>
							    <input type="text" id="consulta1_tbusto" name="consulta1_tbusto" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_tcintura">Tamaño de Cintura</label>
							    <input type="text" id="consulta1_tcintura" name="consulta1_tcintura" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_caderas">Tamaño de Caderas</label>
							    <input type="text" id="consulta1_caderas" name="consulta1_caderas" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_tipo_cuerpo">Tipo de Cuerpo</label>
							    <input type="text" id="consulta1_tipo_cuerpo" name="consulta1_tipo_cuerpo" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_pvello">Posee Vello Púbico</label>
							    <input type="text" id="consulta1_pvello" name="consulta1_pvello" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_color_cabello">Color de Cabello</label>
							    <input type="text" id="consulta1_color_cabello" name="consulta1_color_cabello" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_color_ojos">Color de Ojos</label>
							    <input type="text" id="consulta1_color_ojos" name="consulta1_color_ojos" class="form-control" disabled>
						    </div>
						    <div class="col-6 form-group form-check">
							    <label for="consulta1_ptattu">Posee Tattú</label>
							    <input type="text" id="consulta1_ptattu" name="consulta1_ptattu" class="form-control" disabled>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="consulta1_ppiercing">Posee Piercing</label>
							    <input type="text" id="consulta1_ppiercing" name="consulta1_ppiercing" class="form-control" disabled>
						    </div>
						</div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			      	</div>
			    </div>
		      </form>
	    </div>
	</div>
<!-- FIN Modal Editar Bancarios -->

<!-- Modal Editar Bancarios -->
	<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="form_modal_peticion1" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Peticiones</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
					    	<input type="hidden" name="peticion1_id" id="peticion1_id" value="">
						    <div class="col-12 form-group form-check">
							    <label for="peticion_opcion">Opción</label>
							    <select id="peticion_opcion" name="peticion_opcion" class="form-control" required>
							    	<option value="">Seleccione</option>
							    	<option value="1">Cambio de Datos</option>
							    	<option value="2">Cambio de Sede</option>
							    	<option value="3">Cambio de Estatus</option>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
						    	<label for="peticion_asunto">Asunto</label>
						    	<input type="text" id="peticion_asunto" name="peticion_asunto" class="form-control" required>
						    </div>
						</div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success" id="peticion_submit1">Guardar</button>
			      	</div>
			    </div>
		      </form>
	    </div>
	</div>
<!-- FIN Modal Editar Bancarios -->


</body>
</html>

<script src="../js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="../js/popper.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>

	$(document).ready(function() {
    	var table = $('#example').DataTable( {
        	"lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],

        	"language": {
	            "lengthMenu": "Mostrar _MENU_ Registros por página",
	            "zeroRecords": "No se ha encontrado resultados",
	            "info": "Ubicado en la página <strong>_PAGE_</strong> de <strong>_PAGES_</strong>",
	            "infoEmpty": "Sin registros actualmente",
	            "infoFiltered": "(Filtrado de <strong>_MAX_</strong> total registros)",
	            "paginate": {
			        "first":      "Primero",
			        "last":       "Última",
			        "next":       "Siguiente",
			        "previous":   "Anterior"
			    },
			    "search": "Buscar",
        	},

        	"paging": true,
        	"order": [[ 7, "desc" ]],

    	} );


    	/***************POPOVERS*******************/
		$(function () {
			$('[data-toggle="popover"]').popover()
		})

		// popovers initialization - on hover
		$('[data-toggle="popover-hover"]').popover({
		  html: true,
		  trigger: 'hover',
		  placement: 'bottom',
		  /*content: function () { return '<img src="' + $(this).data('img') + '" />'; }*/
		});

		// popovers initialization - on click
		$('[data-toggle="popover-click"]').popover({
		  html: true,
		  trigger: 'click',
		  placement: 'bottom',
		  content: function () { return '<img src="' + $(this).data('img') + '" />'; }
		});
    	/******************************************/
	} );

	$('#myModal').on('shown.bs.modal', function () {
	  	$('#myInput').trigger('focus')
	});

	$("#form_modal_edit").on("submit", function(e){
		e.preventDefault();
		var f = $(this);
		var edit_id = $('#edit_id').val();
		var edit_nombre1 = $('#edit_nombre1').val();
		var edit_nombre2 = $('#edit_nombre2').val();
		var edit_apellido1 = $('#edit_apellido1').val();
		var edit_apellido2 = $('#edit_apellido2').val();
		var edit_documento_tipo = $('#edit_documento_tipo').val();
		var edit_documento_numero = $('#edit_documento_numero').val();
		var edit_correo_personal = $('#edit_correo_personal').val();
		var edit_telefono = $('#edit_telefono').val();
		var edit_genero = $('#edit_genero').val();
		var edit_sede = $('#edit_sede').val();
		/************************************/
		var fc = $('#fc').val();
		var fs = $('#fs').val();
		/************************************/

		$.ajax({
	        url: '../script/crud_usuarios.php',
	        type: 'POST',
	        dataType: "JSON",
	        data: {
				"id": edit_id,
				"nombre1": edit_nombre1,
				"nombre2": edit_nombre2,
				"apellido1": edit_apellido1,
				"apellido2": edit_apellido2,
				"documento_tipo": edit_documento_tipo,
				"documento_numero": edit_documento_numero,
				"correo_personal": edit_correo_personal,
				"telefono": edit_telefono,
				"genero": edit_genero,
				"sede": edit_sede,
				"condicion": "editar_pasantes1",
			},

	        beforeSend: function (){},

	        success: function(respuesta){
	        	console.log(respuesta);
	        	if(respuesta["estatus"]==1){
	        		Swal.fire({
						title: 'Exito',
						text: "Datos Modificados",
						icon: 'success',
						position: 'center',
						showConfirmButton: false,
						timer: 2000
					});
					$('#documento_tipo_'+edit_id).html(respuesta["documento_tipo"]);
					$('#documento_numero_'+edit_id).html(respuesta["documento_numero"]);
					$('#nombres_'+edit_id).html(respuesta["nombres"]);
					$('#apellidos_'+edit_id).html(respuesta["apellidos"]);
					$('#genero_'+edit_id).html(respuesta["genero"]);
					$('#correo_personal_'+edit_id).html(respuesta["correo_personal"]);
					$('#telefono_'+edit_id).html(respuesta["telefono"]);
					$('#sede_nombre_'+edit_id).html(respuesta["sede"]);
	        	}else if(respuesta["estatus"]==0){
	        		Swal.fire({
						title: 'Error',
						text: "El pasante ya fue aceptado o rechazado",
						icon: 'error',
						position: 'center',
						showConfirmButton: false,
						timer: 2000
					});
	        	}

	        	$("#exampleModal1").modal('hide');
				$('#exampleModal1').removeClass('modal-open');
				$('.modal-backdrop').remove();
	        },

	        error: function(respuesta){
	           	console.log(respuesta['responseText']);
	        }
	    });
	});

	function consultar_personal1(id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_modelos.php',
			data: {
				"id": id,
				"condicion": "consultar_personal1",
			},
			dataType: "JSON",
			success: function(respuesta) {
				console.log(respuesta);
				$("#consulta1_id").val(id);
				$("#consulta1_nombre").val(respuesta["nombre"]);
				$("#consulta1_documento_tipo").val(respuesta["documento_tipo"]);
				$("#consulta1_documento_numero").val(respuesta["documento_numero"]);
				$("#consulta1_correo_personal").val(respuesta["correo_personal"]);
				$("#consulta1_telefono").val(respuesta["telefono"]);
				$("#consulta1_genero").val(respuesta["genero"]);
				$("#consulta1_sede").val(respuesta["sede"]);

				$("#consulta1_banco_cedula").val(respuesta["banco_cedula"]);
				$("#consulta1_banco_nombre").val(respuesta["banco_nombre"]);
				$("#consulta1_banco_tipo").val(respuesta["banco_tipo"]);
				$("#consulta1_banco_numero").val(respuesta["banco_numero"]);
				$("#consulta1_banco_banco").val(respuesta["banco_banco"]);
				$("#consulta1_bcpp").val(respuesta["banco_bcpp"]);
				$("#consulta1_banco_tipo_documento").val(respuesta["banco_tipo_documento"]);
				$("#consulta1_altura").val(respuesta["altura"]);
				$("#consulta1_peso").val(respuesta["peso"]);
				$("#consulta1_tpene").val(respuesta["tpene"]);
				$("#consulta1_tsosten").val(respuesta["tsosten"]);
				$("#consulta1_tbusto").val(respuesta["tbusto"]);
				$("#consulta1_tcintura").val(respuesta["tcintura"]);
				$("#consulta1_tcaderas").val(respuesta["tcaderas"]);
				$("#consulta1_tipo_cuerpo").val(respuesta["tipo_cuerpo"]);
				$("#consulta1_pvello").val(respuesta["pvello"]);
				$("#consulta1_color_cabello").val(respuesta["color_cabello"]);
				$("#consulta1_color_ojos").val(respuesta["color_ojos"]);
				$("#consulta1_ptattu").val(respuesta["ptattu"]);
				$("#consulta1_ppiercing").val(respuesta["ppiercing"]);
				$("#consulta1_turno").val(respuesta["turno"]);
				$("#consulta1_estatus").val(respuesta["estatus"]);
				$("#consulta1_fecha_creacion").val(respuesta["fecha_creacion"]);
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function consultar_documentos(id){
		Swal.fire({
			title: 'Mantenimiento',
			text: "Modulo Imcompleto",
			icon: 'error',
			position: 'center',
			showConfirmButton: false,
			timer: 2000
		});
	}

</script>