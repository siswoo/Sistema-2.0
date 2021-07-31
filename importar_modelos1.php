<?php
include('script/conexion.php');
include('script/conexion2.php');
header("Content-type: text/html; charset=utf8");

/****************PRUEBAS*******************/

$sql1 = "TRUNCATE usuarios";
$sql2 = "TRUNCATE datos_pasantes";
$sql3 = "TRUNCATE datos_modelos";
$consulta1 = mysqli_query($conexion,$sql1);
$consulta2 = mysqli_query($conexion,$sql2);
$consulta3 = mysqli_query($conexion,$sql3);
$sql4 = "INSERT INTO usuarios (nombre1,nombre2,apellido1,apellido2,documento_tipo,documento_numero,correo_personal,correo_empresa,clave,telefono,rol,estatus_modelo,estatus_nomina,estatus_satelite,estatus_pasantia,estatus_empresa,estatus_pasantes,genero,direccion,responsable,id_empresa,id_pais,fecha_modificacion,fecha_creacion) VALUES
('Juan','Jose','Maldonado','La Cruz',1,'955948708101993','juanmaldonado.co@gmail.com','programador@camaleonmg.com','e1f2e2d4f6598c43c2a45d2bd3acb7be','3016984868',1,1,1,0,1,1,1,1,'Barrio Olarte',1,1,5,'','2021-04-18')";
$consulta4 = mysqli_query($conexion,$sql4);
exit;
/******************************************/

$sql1 = "SELECT * FROM modelos WHERE (sede >= 1 and sede <= 4) or sede = 6";
$consulta1 = mysqli_query($conexion2,$sql1);
while($row1 = mysqli_fetch_array($consulta1)) {
	$id = $row1["id"];
	$nombre1 = mb_strtolower($row1["nombre1"]);
	$nombre2 = mb_strtolower($row1["nombre2"]);
	$apellido1 = mb_strtolower($row1["apellido1"]);
	$apellido2 = mb_strtolower($row1["apellido2"]);
	$documento_numero = $row1["documento_numero"];
	$correo = mb_strtolower($row1["correo"]);
	$direccion = mb_strtolower($row1["direccion"]);
	$usuario = $row1["usuario"];
	$telefono = $row1["telefono1"];
	$estatus = $row1["estatus"];
	$responsable = 1;

	$id_empresa = 1;
	$id_pais = 5;

	$fecha_creacion = $row1["fecha_inicio"];

	$documento_tipo = $row1["documento_tipo"];
	$genero = $row1["genero"];

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

	$rol = 2; //Esta guardado con id 2 -> el rol de modelo

	$estatus_pasantes = 1;

	if($estatus==2){
		$estatus_modelo = 1;
		$estatus_modelo2 = 2;
	}else if($estatus==3){
		$estatus_modelo = 2;
		$estatus_modelo2 = 3;
	}

    $clave_original = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 8);
    $clave = md5($clave_original);

    $turno = $row1["turno"];
	    
	if($turno==''){
	    $turno_modelo = '0';
	}else if($turno=='Mañana'){
	    $turno_modelo = 1;
	}else if($turno=='Tarde'){
	    $turno_modelo = 2;
	}else if($turno=='Noche'){
	    $turno_modelo = 3;
	}else if($turno=='Satelite'){
	    $turno_modelo = 4;
	}

    if($turno_modelo!=4){
		$sql2 = "INSERT INTO usuarios (nombre1,nombre2,apellido1,apellido2,documento_tipo,documento_numero,correo_personal,clave,telefono,rol,estatus_modelo,estatus_pasantes,genero,direccion,responsable,id_empresa,id_pais,fecha_creacion) VALUES 
		('".$nombre1."','".$nombre2."','".$apellido1."','".$apellido2."',".$documento_tipo.",".$documento_numero.",'".$correo."','".$clave."','".$telefono."',".$rol.",".$estatus_modelo.",".$estatus_pasantes.",".$genero.",'".$direccion."',".$responsable.",".$id_empresa.",".$id_pais.",'".$fecha_creacion."')";
		$consulta2 = mysqli_query($conexion,$sql2);
		$id_usuarios = mysqli_insert_id($conexion);

		$banco_cedula = $row1["banco_cedula"];
	    $banco_nombre = mb_strtolower($row1["banco_nombre"]);
	    $banco_tipo = $row1["banco_tipo"];
	    $banco_numero = $row1["banco_numero"];
	    $banco_banco = $row1["banco_banco"];
	    $banco_bcpp = $row1["BCPP"];
	    $banco_tipo_documento = $row1["banco_tipo_documento"];

	    if($banco_tipo_documento=='Cedula de Ciudadania'){
			$banco_tipo_documento = 1;
		}else if($banco_tipo_documento=='Cedula de Extranjeria'){
			$banco_tipo_documento = 2;
		}else if($banco_tipo_documento=='Pasaporte'){
			$banco_tipo_documento = 3;
		}else if($banco_tipo_documento=='PEP'){
			$banco_tipo_documento = 4;
		}else{
			$banco_tipo_documento = 0;
		}

	    $altura = $row1["altura"];
	    $peso = $row1["peso"];
	    $tpene = $row1["tpene"];
	    $tsosten = $row1["tsosten"];
	    $tbusto = $row1["tbusto"];
	    $tcintura = $row1["tcintura"];
	    $tcaderas = $row1["tcaderas"];
	    $tipo_cuerpo = $row1["tipo_cuerpo"];
	    $pvello = $row1["Pvello"];
	    $color_cabello = $row1["tcaderas"];
	    $color_ojos = $row1["color_ojos"];
	    $ptattu = $row1["Ptattu"];
	    $ppiercing = $row1["Ppiercing"];

	    $sede = $row1["sede"];

	    $sql5 = "SELECT * FROM datos_pasantes WHERE id_usuarios = ".$id_usuarios;
	    $consulta5 = mysqli_query($conexion,$sql5);
	    $contador5 = mysqli_num_rows($consulta5);

	    $sql6 = "SELECT * FROM datos_modelos WHERE id_usuarios = ".$id_usuarios;
	    $consulta6 = mysqli_query($conexion,$sql6);
	    $contador6 = mysqli_num_rows($consulta6);

	    if($contador5==0){
			$sql3 = "INSERT INTO datos_pasantes (id_usuarios,sede,estatus,turno,fecha_creacion) VALUES 
			(".$id_usuarios.",".$sede.",".$estatus_modelo2.",".$turno_modelo.",'".$fecha_creacion."')";
			$consulta3 = mysqli_query($conexion,$sql3);
	    }

	    if($contador6==0){
			$sql4 = "INSERT INTO datos_modelos (id,id_usuarios,banco_cedula,banco_nombre,banco_tipo,banco_numero,banco_banco,banco_bcpp,banco_tipo_documento,altura,peso,tpene,tsosten,tbusto,tcintura,tcaderas,tipo_cuerpo,pvello,color_cabello,color_ojos,ptattu,ppiercing,turno,estatus,sede,fecha_creacion) VALUES (".$id.",".$id_usuarios.",'".$banco_cedula."','".$banco_nombre."','".$banco_tipo."','".$banco_numero."','".$banco_banco."','".$banco_bcpp."','".$banco_tipo_documento."','".$altura."','".$peso."','".$tpene."','".$tsosten."','".$tbusto."','".$tcintura."','".$tcaderas."','".$tipo_cuerpo."','".$pvello."','".$color_cabello."','".$color_ojos."','".$ptattu."','".$ppiercing."',".$turno_modelo.",".$estatus.",".$sede.",'".$fecha_creacion."')";
			$consulta4 = mysqli_query($conexion,$sql4);
		}
    }


}

?>