<?php
include("../script/session1.php");
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

<style type="text/css">
	body{
		background-image: url("../img/logos/FONDO APP.png");
	}
	.cerrar_session1{
		background-color: #a37c4b; 
		border-color: #271d12; 
		color: white;
	}
	.cerrar_session1:hover{
		background-color: #271d12;
		border-color: #a37c4b;
		color: white;
	}
</style>

<?php
include("../script/conexion.php");
?>

<form id="formulario1" method="GET" action="index.php">
	<input type="hidden" id="condicion" name="condicion" value="registro1">
	<div class="row mt-2 mb-2">
		<div class="container">
			<div class="col-12 text-right">
				<a href="../index.php">
					<button type="button" class="btn cerrar_session1">Cerrar Sesión</button>
				</a>
			</div>
		</div>
		<div class="col-12 text-center">
			<img src="../img/logos/Dorado Completo.png" style="width:200px;">
		</div>
		<div class="col-12 text-center texto1" style="font-size: 18px; font-weight: bold; text-transform: uppercase; color: white;">
			Por favor complete el formulario
		</div>
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="documento_tipo" style="font-size:18px; font-weight: bold; color: white;">Tipo de Documento</label>
					<select class="form-control" id="documento_tipo" name="documento_tipo" required>
						<?php
						$sql1 = "SELECT * FROM documento_tipo";
						$proceso1 = mysqli_query($conexion,$sql1);
						while($row1 = mysqli_fetch_array($proceso1)) {
							$documento_tipo_id = $row1["id"];
							$documento_tipo_nombre = $row1["nombre"];
							echo '<option value="'.$documento_tipo_id.'">'.$documento_tipo_nombre.'</option>';
						}
						?>
					</select>
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="documento_numero" style="font-size:18px; font-weight: bold; color: white;">Número de Documento</label>
					<input type="text" id="documento_numero" name="documento_numero" class="form-control" required autocomplete="off" onkeypress="return soloNumeros1(event);" onkeyup="validarDocumento1(value,'documento_numero');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="primer_nombre" style="font-size:18px; font-weight: bold; color: white;">Primer Nombre</label>
					<input type="text" id="primer_nombre" name="primer_nombre" class="form-control" required autocomplete="off" onkeypress="return soloLetras1(event)" onkeyup="noEspacios1(value,'primer_nombre');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="segundo_nombre" style="font-size:18px; font-weight: bold; color: white;">Segundo Nombre</label>
					<input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control" required autocomplete="off" onkeypress="return soloLetras1(event)" onkeyup="noEspacios1(value,'segundo_nombre');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="primer_apellido" style="font-size:18px; font-weight: bold; color: white;">Primer Apellido</label>
					<input type="text" id="primer_apellido" name="primer_apellido" class="form-control" required autocomplete="off" onkeypress="return soloLetras1(event)" onkeyup="noEspacios1(value,'primer_apellido');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="segundo_apellido" style="font-size:18px; font-weight: bold; color: white;">Segundo Apellido</label>
					<input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control" required autocomplete="off" onkeypress="return soloLetras1(event)" onkeyup="noEspacios1(value,'segundo_apellido');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="correo" style="font-size:18px; font-weight: bold; color: white;">Correo Electrónico</label>
					<input type="email" id="correo" name="correo" class="form-control" required autocomplete="off" onkeyup="noEspacios1(value,'correo');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="correo2" style="font-size:18px; font-weight: bold; color: white;">Repetir Correo Electrónico</label>
					<input type="email" id="correo2" name="correo2" class="form-control" required autocomplete="off" onkeyup="noEspacios1(value,'correo2');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="telefono" style="font-size:18px; font-weight: bold; color: white;">Teléfono Celular (WhatsApp)</label>
					<input type="text" id="telefono" name="telefono" class="form-control" required autocomplete="off" onkeypress="return soloNumeros1(event);" onkeyup="noEspacios1(value,'telefono');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="barrio" style="font-size:18px; font-weight: bold; color: white;">Barrio</label>
					<input type="text" id="barrio" name="barrio" class="form-control" required autocomplete="off" onkeypress="return soloLetras1(event);" onkeyup="noEspacios1(value,'barrio');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="direccion" style="font-size:18px; font-weight: bold; color: white;">Dirección</label>
					<input type="text" id="direccion" name="direccion" class="form-control" required autocomplete="off" onkeyup="noEspacios1(value,'direccion');">
				</div>
				<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 form-group form-check">
					<label for="genero" style="font-size:18px; font-weight: bold; color: white;">Género</label>
					<select id="genero" name="genero" class="form-control" required>
						<?php
						$sql2 = "SELECT * FROM genero";
						$proceso2 = mysqli_query($conexion,$sql2);
						while($row2 = mysqli_fetch_array($proceso2)) {
							$genero_id = $row2["id"];
							$genero_nombre = $row2["nombre"];
							echo '<option value="'.$genero_id.'">'.$genero_nombre.'</option>';
						}
						?>
					</select>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group form-check">
					<label for="enterado" style="font-size:18px; font-weight: bold; color: white;">¿Cómo te has enterado de Camaleón?</label>
					<select id="enterado" name="enterado" class="form-control" required>
						<?php
						$sql3 = "SELECT * FROM enterado";
						$proceso3 = mysqli_query($conexion,$sql3);
						while($row3 = mysqli_fetch_array($proceso3)) {
							$enterado_id = $row3["id"];
							$enterado_nombre = $row3["nombre"];
							echo '<option value="'.$enterado_id.'">'.$enterado_nombre.'</option>';
						}
						?>
					</select>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
					<button type="submit" class="btn btn-success" style="font-size: 26px; text-transform:uppercase;">Registrar Información</button>
				</div>
			</div>
		</div>
	</div>
</form>

</body>
</html>

<script src="../js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="../js/popper.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="../js/helpers.js"></script>
<!--<script src="../js/whatsapp.js"></script>-->

<script>

	/***********************/
	/********PRUEBAS********/
	/***********************/

	$('#documento_numero').val("999999");
	$('#primer_nombre').val("Juan");
	$('#segundo_nombre').val("Jose");
	$('#primer_apellido').val("Maldonado");
	$('#segundo_apellido').val("La Cruz");
	$('#correo').val("juanmaldonado.co@gmail.com");
	$('#correo2').val("juanmaldonado.co@gmail.com");
	$('#telefono').val("3016984868");
	$('#barrio').val("Olarte");
	$('#direccion').val("Olarte x2");

	/***********************/
	/***********************/
	/***********************/

function editar1(id){
		$.ajax({
			type: 'POST',
			url: '../script/crud_usuarios.php',
			data: {
				"id": id,
				"condicion": "consultar_pasantes1",
			},
			dataType: "JSON",
			success: function(respuesta) {
				console.log(respuesta);
			},

			error: function(respuesta) {
				console.log(respuesta['responseText']);
			}
		});
}

function soloNumeros1(value){
		var code = (value.which) ? value.which : value.keyCode;
    if(code==8) {
			return true;
    } else if(code>=48 && code<=57) {
      return true;
    } else{
      return false;
    }
}

function validarDocumento1(value,id){
		var cantidad = value.length;
		if(cantidad==1 && value==0){
			$('#'+id).val("");
		}
}

function soloLetras1(value) {
		key=value.keyCode || value.which;
		teclado=String.fromCharCode(key).toLowerCase();
		letras="qwertyuiopasdfghjklñzxcvbnm ";
		especiales="8-37-38-46-164";
		teclado_especial=false;

    for(var i in especiales){
			if(key==especiales[i]){
				teclado_especial=true;
				break;
			}
		}

		if(letras.indexOf(teclado)==-1 && !teclado_especial){
			return false;
		}
}

function noEspacios1(value,id){
	var cantidad = value.length;
	if(value==" " && cantidad==1){
		$('#'+id).val("");
	}
}

$("#formulario1").on("submit", function(e){
	e.preventDefault();
	var f = $(this);

    $.ajax({
		type: 'POST',
		url: '../script/crud_pasantias.php',
		data: $('#formulario1').serialize(),
		dataType: "JSON",
		success: function(respuesta) {
			console.log(respuesta);
			
			if(respuesta["estatus"]=="error"){
				Swal.fire({
					title: 'Error!',
					text: respuesta["msg"],
					icon: 'error',
					position: 'center',
					showConfirmButton: true,
				});
			}else if(respuesta["estatus"]=="ok"){

				Swal.fire({
					title: 'Correcto!',
					text: respuesta["msg"],
					icon: 'success',
					position: 'center',
					showConfirmButton: true,
				});

				/*
				$('#documento_numero').val("");
				$('#primer_nombre').val("");
				$('#segundo_nombre').val("");
				$('#primer_apellido').val("");
				$('#segundo_apellido').val("");
				$('#correo').val("");
				$('#correo2').val("");
				$('#telefono').val("");
				$('#barrio').val("");
				$('#direccion').val("");
				*/

			}

		},

		error: function(respuesta) {
			console.log(respuesta['responseText']);
		}
	});

});

</script>