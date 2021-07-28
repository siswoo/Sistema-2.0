<?php
include('script/conexion.php');
include('script/conexion2.php');

$sql1 = "SELECT * FROM modelos WHERE sede != '' LIMIT 100";
$consulta1 = mysqli_query($conexion2,$sql1);
while($row1 = mysqli_fetch_array($consulta1)) {
	$nombre1 = $row1["nombre1"];
	$nombre2 = $row1["nombre2"];
	$apellido1 = $row1["apellido1"];
	$apellido2 = $row1["apellido2"];
	$documento_numero = $row1["documento_numero"];
	$correo = $row1["correo"];
	$direccion = $row1["direccion"];
	$usuario = $row1["usuario"];
	$telefono1 = $row1["telefono1"];
	$estatus = $row1["estatus"];
	//$barrio = $row1["barrio"];
	$direccion = $row1["direccion"];
	$responsable = 1;

	$id_empresa = $row1["id_empresa"];
	$id_pais = $row1["id_pais"];
	$fecha_creacion = $row1["fecha_inicio"];

	/*******************Quede haciendo lo de la exportacion - importacion de base de datos********************/

	$documento_tipo = $row1["documento_tipo"];
	$genero = $row1["genero"];
	$rol = $row1["rol"];

	if($documento_tipo=='Cedula de Ciudadania'){
		$documento_tipo = 1;
	}else if($documento_tipo=='Cedula de Extranjeria'){
		$documento_tipo = 2;
	}else if($documento_tipo=='Pasaporte'){
		$documento_tipo = 3;
	}else if($documento_tipo=='PEP'){
		$documento_tipo = 4;
	}

	if($genero=='Hombre'){
		$genero = 1;
	}else if($genero=='Mujer'){
		$genero = 2;
	}else if($genero=='Transexual'){
		$genero = 3;
	}

	if($estatus=='Activa'){
		$estatus = 2;
	}else if($estatus=='Inactiva'){
		$estatus = 3;
	}

	//Esta guardado con id 2 -> el rol de modelo
	$rol = 2;

}

?>