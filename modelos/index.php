<?php
session_start();
if(@$_SESSION["camaleonapp_id"]=='' or @$_SESSION["camaleonapp_id"]==null){
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
$ubicacion='pasantes';
include("../script/conexion.php");
include("../header.php");
include("../permisologia.php");
$sqlub1 = "SELECT * FROM modulos WHERE nombre = '".$ubicacion."'";
$procesoub1 = mysqli_query($conexion,$sqlub1);
while($rowub1 = mysqli_fetch_array($procesoub1)) {
	$id_moduloub1 = $rowub1["id"];
}
$sqlp2 = "SELECT * FROM funciones_usuarios WHERE id_usuarios = ".$_SESSION["camaleonapp_id"]." and id_modulos = ".$id_moduloub1;
$procesoub2 = mysqli_query($conexion,$sqlp2);
while($rowub2 = mysqli_fetch_array($procesoub2)) {
	$modulo_crear = $rowub2["crear"];
	$modulo_modificar = $rowub2["modificar"];
	$modulo_eliminar = $rowub2["eliminar"];
}
?>

<div class="container mt-3">
	<div class="row">
		<input type="hidden" name="datatables" id="datatables" data-pagina="1" data-consultasporpagina="10" data-filtrado="" data-sede="">
		<div class="col-3 form-group form-check">
			<label for="consultasporpagina" style="color:black; font-weight: bold;">Consultas por Página</label>
			<select class="form-control" id="consultasporpagina" name="consultasporpagina">
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
		</div>
		<div class="col-4 form-group form-check">
			<label for="buscarfiltro" style="color:black; font-weight: bold;">Buscar</label>
			<input type="text" class="form-control" id="buscarfiltro" name="buscarfiltro">
		</div>
		<div class="col-3 form-group form-check">
			<label for="consultaporsede" style="color:black; font-weight: bold;">Consultas por Sede</label>
			<select class="form-control" id="consultaporsede" name="consultaporsede">
				<option value="">Todos</option>
				<?php
					$sql9 = "SELECT * FROM sedes WHERE id_empresa = ".$_SESSION['camaleonapp_empresa'];
					$proceso9 = mysqli_query($conexion,$sql9);
						while($row9 = mysqli_fetch_array($proceso9)) {
							echo '
								<option value="'.$row9["id"].'">'.$row9["nombre"].'</option>
							';			
						}
				?>
			</select>
		</div>
		<div class="col-2">
			<br>
			<button type="button" class="btn btn-info mt-2" onclick="filtrar1();">Filtrar</button>
		</div>
	</div>
</div>

<div id="resultado_table1">Aqui!</div>

<!--
<form id="formulario1" method="GET" action="index.php">
	<div class="row mt-2 mb-2">
		<div class="col-12 text-center" style="font-size: 18px; font-weight: bold;">
			Modulo de Pasantes
		</div>
	</div>
</form>

<div class="col-12" style="margin-top: 2rem;">
	<table id="example" class="table row-border hover table-bordered" style="font-size: 12px;">
		<thead>
			<tr>
				<th class="text-center">T Doc</th>
				<th class="text-center">Nº Doc</th>
				<th class="text-center">Nombre</th>
				<th class="text-center">Apellido</th>
				<th class="text-center">Género</th>
				<th class="text-center">Correo</th>
				<th class="text-center">Teléfono</th>
				<th class="text-center">Estatus</th>
				<th class="text-center">Sede</th>
				<th class="text-center">Fecha Inicio</th>
				<th class="text-center">Opciones</th>
				<th class="text-center">Admisión</th>
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
				$sql7 = "SELECT * FROM datos_nominas WHERE id = ".$_SESSION["camaleonapp_id"];
				$proceso7 = mysqli_query($conexion,$sql7);
				while($row7 = mysqli_fetch_array($proceso7)) {
					$nomina_sede = $row7["sede"];
				}
				$html_fs1 .= ' and sede =  '.$nomina_sede;
			}

			$consulta2 = "SELECT * FROM usuarios WHERE estatus_pasantes>0 ORDER BY fecha_creacion DESC ".$html_fc1;
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

				$sql3 = "SELECT * FROM datos_pasantes WHERE id_usuarios = ".$id_usuario.$html_fs1;
				$proceso3 = mysqli_query($conexion,$sql3);
				$contador3 = mysqli_num_rows($proceso3);
				if($contador3>=1){
					while($row3 = mysqli_fetch_array($proceso3)) {
						$sede_id = $row3["sede"];
						$fecha_creacion = $row3["fecha_creacion"];
						$pasante_estatus = $row3["estatus"];
						$pasante_turno = $row3["turno"];
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

					echo '
						<tr>
							<td class="text-center" id="documento_tipo_'.$id_usuario.'">'.$documento_tipo_nombre.'</td>
							<td class="text-center" id="documento_numero_'.$id_usuario.'">'.$documento_numero.'</td>
							<td class="text-center" nowrap id="nombres_'.$id_usuario.'">'.$nombre1." ".$nombre2.'</td>
							<td class="text-center" nowrap id="apellidos_'.$id_usuario.'">'.$apellido1." ".$apellido2.'</td>
							<td class="text-center" id="genero_'.$id_usuario.'">'.$genero.'</td>
							<td class="text-center" id="correo_personal_'.$id_usuario.'">'.$correo_personal.'</td>
							<td class="text-center" id="telefono_'.$id_usuario.'">'.$telefono.'</td>
						';

					if($pasante_estatus==2){
						echo '<td class="text-center" id="estatus_'.$id_usuario.'" style="color:green;">Aceptada</td>';	
					}else if($pasante_estatus==3){
						echo '<td class="text-center" id="estatus_'.$id_usuario.'" style="color:red;">Rechazada</td>';
					}else{
						echo '<td class="text-center" id="estatus_'.$id_usuario.'">En Proceso</td>';
					}

					echo '<td class="text-center" id="sede_nombre_'.$id_usuario.'">'.$sede_nombre.'</td>';

					echo '
						<td class="text-center">'.$fecha_creacion.'</td>
						<td class="text-center" id="opciones_'.$id_usuario.'">
					';

					if($modulo_modificar==1){
						echo '
							<i class="fas fa-edit" style="color:#0095ff; cursor:pointer;" title="" value="'.$id_usuario.'" data-toggle="modal" data-target="#exampleModal1" onclick="editar1('.$id_usuario.');"></i>
						';
					}

					/*
					if($modulo_eliminar==1){
						echo '
							<i class="fas fa-trash-alt ml-3" style="color:red; cursor:pointer;" data-toggle="popover-hover" onclick="eliminar1('.$id_usuario.');" value="'.$id_usuario.'"></i>
						';
					}
					*/

					echo '</td>';
					echo '<td class="text-center" id="admision_'.$id_usuario.'" nowrap>';

					if($pasante_estatus==1){
						echo '
							<button class="btn btn-success" value="'.$id_usuario.'" onclick="estatus('.$id_usuario.',2);">Aceptar</button>
							<button class="btn btn-danger" value="'.$id_usuario.'" onclick="estatus('.$id_usuario.',3);">Rechazar</button>
						';
					}else{
						echo '
							<i class="fab fa-black-tie" style="color:black; font-size: 30px; cursor:pointer;" data-toggle="modal" data-target="#exampleModal2" onclick="peticion1('.$id_usuario.');"></i>
						';
					}

					echo '
						</td>
					</tr>';
				}
			} ?>
		</tbody>
	</table>
</div>
-->

<!-- Modal aceptar_pasante1_modal1 -->
	<div class="modal fade" id="aceptar_pasante1_modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="#" method="POST" id="aceptar_pasante1_modal1_formulario" style="">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">INDICAR DATOS</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					    <div class="row">
					    	<input type="hidden" name="pasante_id" id="pasante_id">
					    	<input type="hidden" name="usuario_id" id="usuario_id">
						    <div class="col-12 form-group form-check">
							    <label for="turno" style="font-weight: bold;">Turno</label>
							    <select name="turno" id="turno" class="form-control" required>
							    	<option value="">Seleccione</option>
							    <?php
							    	$sql10 = "SELECT * FROM turnos";
							    	$proceso10 = mysqli_query($conexion,$sql10);
							    	while($row10 = mysqli_fetch_array($proceso10)) {
							    		$turnos_id = $row10["id"];
							    		$turnos_nombre = $row10["nombre"];
							    		echo '<option value="'.$turnos_id.'">'.$turnos_nombre.'</option>';
							    	}
							    ?>
							    </select>
						    </div>
						    <div class="col-12 form-group form-check">
							    <label for="sede" style="font-weight: bold;">Sede</label>
							    <select name="sede" id="sede" class="form-control" required>
							    	<option value="">Seleccione</option>
							    <?php
							    	$sql11 = "SELECT * FROM sedes WHERE id_empresa = ".$_SESSION['camaleonapp_empresa'];
							    	$proceso11 = mysqli_query($conexion,$sql11);
							    	while($row11 = mysqli_fetch_array($proceso11)) {
							    		$turnos_id = $row11["id"];
							    		$turnos_nombre = $row11["nombre"];
							    		echo '<option value="'.$turnos_id.'">'.$turnos_nombre.'</option>';
							    	}
							    ?>
							    </select>
						    </div>
					    </div>
					</div>
					<div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				        <button type="submit" class="btn btn-success" id="submit_edit1">Guardar</button>
			      	</div>
		      	</form>
	    	</div>
	  	</div>
	</div>
<!---------------------------------------->

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
		filtrar1();
		setInterval('filtrar1()',5000);
	} );

	function filtrar1(){
		var input_consultasporpagina = $('#consultasporpagina').val();
		var input_buscarfiltro = $('#buscarfiltro').val();
		var input_consultaporsede = $('#consultaporsede').val();
		
		$('#datatables').attr({'data-consultasporpagina':input_consultasporpagina})
		$('#datatables').attr({'data-filtrado':input_buscarfiltro})
		$('#datatables').attr({'data-sede':input_consultaporsede})

		var pagina = $('#datatables').attr('data-pagina');
		var consultasporpagina = $('#datatables').attr('data-consultasporpagina');
		var sede = $('#datatables').attr('data-sede');
		var filtrado = $('#datatables').attr('data-filtrado');
		var ubicacion_url = '<?php echo $ubicacion_url; ?>';

		$.ajax({
			type: 'POST',
			url: '../script/crud_pasantes.php',
			dataType: "JSON",
			data: {
				"pagina": pagina,
				"consultasporpagina": consultasporpagina,
				"sede": sede,
				"filtrado": filtrado,
				"link1": ubicacion_url,
				"condicion": "table1",
			},

			success: function(respuesta) {
				//console.log(respuesta);
				if(respuesta["estatus"]=="ok"){
					$('#resultado_table1').html(respuesta["html"]);
				}
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
	}

	function paginacion1(value){
		$('#datatables').attr({'data-pagina':value})
		filtrar1();
	}

	$('#myModal').on('shown.bs.modal', function () {
	  	$('#myInput').trigger('focus')
	});

	function aceptar_pasante1_modal1(pasante_id,usuario_id){
		$('#usuario_id').val(usuario_id);
		$('#pasante_id').val(pasante_id);
	}

	$("#aceptar_pasante1_modal1_formulario").on("submit", function(e){
		e.preventDefault();
		var pasante_id = $('#pasante_id').val();
		var usuario_id = $('#usuario_id').val();
		var turno = $('#turno').val();
		var sede = $('#sede').val();

		Swal.fire({
			title: 'Estas seguro?',
			text: "Verifica los datos antes de darle aceptar por favor!",
			icon: 'warning',
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, Seguro!',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'POST',
					url: '../script/crud_pasantes.php',
					dataType: "JSON",
					data: {
						"pasante_id": pasante_id,
						"usuario_id": usuario_id,
						"turno": turno,
						"sede": sede,
						"condicion": "aceptar_pasante1",
					},

					success: function(respuesta) {
						console.log(respuesta);

						if(respuesta["estatus"]=="ok"){
							Swal.fire({
								title: 'Correcto!',
								text: respuesta["msg"],
								icon: 'success',
							})
						}else if(respuesta["estatus"]=="error"){
							Swal.fire({
								title: 'Error',
								text: respuesta["msg"],
								icon: 'error',
							})
						}

					},

					error: function(respuesta) {
						console.log(respuesta["responseText"]);
					}
				});
			}
		})
	});

	function rechazar_pasante1(pasante_id,usuario_id){
		Swal.fire({
			title: 'Estas seguro?',
			text: "Los Cambios no se podran revertir!",
			icon: 'warning',
			showConfirmButton: true,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, Seguro!',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: 'POST',
					url: '../script/crud_pasantes.php',
					dataType: "JSON",
					data: {
						"pasante_id": pasante_id,
						"usuario_id": usuario_id,
						"condicion": "rechazar_pasante1",
					},

					success: function(respuesta) {
						console.log(respuesta);

						if(respuesta["estatus"]=="ok"){
							Swal.fire({
								title: 'Correcto!',
								text: respuesta["msg"],
								icon: 'success',
							})
						}else if(respuesta["estatus"]=="error"){
							Swal.fire({
								title: 'Error',
								text: respuesta["msg"],
								icon: 'error',
							})
						}

					},

					error: function(respuesta) {
						console.log(respuesta["responseText"]);
					}
				});
			}
		})
	}

</script>