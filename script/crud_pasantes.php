<?php
@session_start();

/*
$length = 6;
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
}
echo  $randomString;
exit;
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../resources/PHPMailer/PHPMailer/src/Exception.php';
require '../resources/PHPMailer/PHPMailer/src/PHPMailer.php';
require '../resources/PHPMailer/PHPMailer/src/SMTP.php';
include('conexion.php');
include('conexion2.php');
$condicion = $_POST["condicion"];
$datetime = date('Y-m-d H:i:s');
$empresa = $_SESSION["camaleonapp_empresa"];


if($condicion=='table1'){
	$pagina = $_POST["pagina"];
	$consultasporpagina = $_POST["consultasporpagina"];
	$filtrado = $_POST["filtrado"];
	$link1 = $_POST["link1"];
	$sede = $_POST["sede"];
	$link1 = explode("/",$link1);
	$link1 = $link1[3];

	if($pagina==0 or $pagina==''){
		$pagina = 1;
	}

	if($consultasporpagina==0 or $consultasporpagina==''){
		$consultasporpagina = 10;
	}

	if($filtrado!=''){
		$filtrado = ' and (nombre1 LIKE "%'.$filtrado.'%" or nombre2 LIKE "%'.$filtrado.'%" or apellido1 LIKE "%'.$filtrado.'%" or apellido2 LIKE "%'.$filtrado.'%" or documento_numero LIKE "%'.$filtrado.'%" or us.correo_personal LIKE "%'.$filtrado.'%" or telefono LIKE "%'.$filtrado.'%")';
	}

	if($sede!=''){
		$sede = ' and (dpa.sede = '.$sede.') ';
	}

	$limit = $consultasporpagina;
	$offset = ($pagina - 1) * $consultasporpagina;
	/*
	$sql1 = "SELECT * FROM datos_pasantes";
	$proceso1 = mysqli_query($conexion,$sql1);
	$conteo1 = mysqli_num_rows($proceso1);

	$paginas = ceil($conteo1 / $consultasporpagina);
	*/

	$sql2 = "SELECT 
		dpa.id as id,
		dti.nombre as documento_tipo,
		us.documento_numero as documento_numero,
		us.nombre1 as nombre1,
		us.nombre2 as nombre2,
		us.apellido1 as apellido1,
		us.apellido2 as apellido2,
		ge.nombre as genero,
		us.correo_personal as correo,
		us.telefono as telefono,
		us.estatus_pasantes as estatus,
		pa.nombre as pais,
		pa.codigo as pais_codigo,
		se.nombre as sede,
		se.id as id_sede,
		dpa.fecha_creacion as fecha_creacion
		FROM usuarios us
		INNER JOIN datos_pasantes dpa
		ON us.id = dpa.id_usuarios 
		INNER JOIN documento_tipo dti
		ON us.documento_tipo = dti.id
		INNER JOIN genero ge
		ON us.genero = ge.id
		INNER JOIN paises pa
		ON us.id_pais = pa.id
		INNER JOIN sedes se
		ON dpa.sede = se.id 
		WHERE us.id != 0 
		".$filtrado." 
		".$sede." 
		ORDER BY dpa.fecha_creacion DESC LIMIT ".$limit." OFFSET ".$offset."
	";

	$proceso2 = mysqli_query($conexion,$sql2);
	$conteo1 = mysqli_num_rows($proceso2);
	$paginas = ceil($conteo1 / $consultasporpagina);

	$html = '';

	$html .= '
		<div class="col-xs-12">
	        <table class="table table-bordered">
	            <thead>
	            <tr>
	                <th class="text-center">T Doc</th>
	                <th class="text-center">N Doc</th>
	                <th class="text-center">Nombre</th>
	                <th class="text-center">Género</th>
	                <th class="text-center">Correo</th>
	                <th class="text-center">Teléfono</th>
	                <th class="text-center">Estatus</th>
	                <th class="text-center">Sede</th>
	                <th class="text-center">Ingreso</th>
	                <th class="text-center">Opciones</th>
	            </tr>
	            </thead>
	            <tbody>
	';
	if($conteo1>=1){
		while($row2 = mysqli_fetch_array($proceso2)) {
			if($row2["estatus"]==1){
				$pasante_estatus = "Proceso";
			}else if($row2["estatus"]==2){
				$pasante_estatus = "Aceptado";
			}else if($row2["estatus"]==3){
				$pasante_estatus = "Rechazado";
			}
			$html .= '
		                <tr id="tr_'.$row2["id"].'">
		                    <td style="text-align:center;">'.$row2["documento_tipo"].'</td>
		                    <td style="text-align:center;">'.$row2["documento_numero"].'</td>
		                    <td style="text-align:justify;">'.$row2["nombre1"]." ".$row2["nombre2"]." ".$row2["apellido1"]." ".$row2["apellido2"].'</td>
		                    <td style="text-align:center;">'.$row2["genero"].'</td>
		                    <td style="text-align:center;">'.$row2["correo"].'</td>
		                    <td style="text-align:center;">'.$row2["telefono"].'</td>
		                    <td  style="text-align:center;">'.$pasante_estatus.'</td>
		                    <td style="text-align:center;">'.$row2["sede"].'</td>
		                    <td nowrap="nowrap">'.$row2["fecha_creacion"].'</td>
		                    <td nowrap="nowrap">
		                    	<button type="button" class="btn btn-success">A</button>
		                    	<button type="button" class="btn btn-danger">R</button>
		                    </td>
		                </tr>
		    ';
		}
	}else{
		$html .= '<tr><td colspan="10" class="text-center" style="font-weight:bold;font-size:20px;">Sin Resultados</td></tr>';
	}

	$html .= '
	            </tbody>
	        </table>
	        <nav>
	            <div class="row">
	                <div class="col-xs-12 col-sm-4 text-center">
	                    <p>Mostrando '.$consultasporpagina.' de '.$conteo1.' Datos disponibles</p>
	                </div>
	                <div class="col-xs-12 col-sm-4 text-center">
	                    <p>Página '.$pagina.' de '.$paginas.' </p>
	                </div> 
	                <div class="col-xs-12 col-sm-4">
			            <nav aria-label="Page navigation" style="float:right; padding-right:2rem;">
							<ul class="pagination">
	';
	
	if ($pagina > 1) {
		$html .= '
								<li class="page-item">
									<a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#">
										<span aria-hidden="true">Anterior</span>
									</a>
								</li>
		';
	}

	$diferenciapagina = 3;
	
	/*********MENOS********/
	if($pagina==2){
		$html .= '
		                		<li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#">
			                            '.($pagina-1).'
			                        </a>
			                    </li>
		';
	}else if($pagina==3){
		$html .= '
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-2).');" href="#"">
			                            '.($pagina-2).'
			                        </a>
			                    </li>
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#"">
			                            '.($pagina-1).'
			                        </a>
			                    </li>
	';
	}else if($pagina>=4){
		$html .= '
		                		<li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-3).');" href="#"">
			                            '.($pagina-3).'
			                        </a>
			                    </li>
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-2).');" href="#"">
			                            '.($pagina-2).'
			                        </a>
			                    </li>
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina-1).');" href="#"">
			                            '.($pagina-1).'
			                        </a>
			                    </li>
		';
	} 

	/*********MAS********/
	$opcionmas = $pagina+3;
	if($paginas==0){
		$opcionmas = $paginas;
	}else if($paginas>=1 and $paginas<=4){
		$opcionmas = $paginas;
	}
	
	for ($x=$pagina;$x<=$opcionmas;$x++) {
		$html .= '
			                    <li class="page-item 
		';

		if ($x == $pagina){ 
			$html .= '"active"';
		}

		$html .= '">';

		$html .= '
			                        <a class="page-link" onclick="paginacion1('.($x).');" href="#"">'.$x.'</a>
			                    </li>
		';
	}

	if ($pagina < $paginas) {
		$html .= '
			                    <li class="page-item">
			                        <a class="page-link" onclick="paginacion1('.($pagina+1).');" href="#"">
			                            <span aria-hidden="true">Siguiente</span>
			                        </a>
			                    </li>
		';
	}

	$html .= '

						</ul>
					</nav>
				</div>
	        </nav>
	    </div>
	';

	$datos = [
		"estatus"	=> "ok",
		"html"	=> $html,
		"sql2"	=> $sql2,
	];
	echo json_encode($datos);
}



if($condicion=='cambio_estatus1'){
	$id = $_POST['id'];
	$estatus = $_POST['estatus'];

	$sql2 = "SELECT * FROM datos_pasantes WHERE id = ".$id." and (estatus = 2 or estatus = 3)";
	$proceso2 = mysqli_query($conexion,$sql2);
	$contador2 = mysqli_num_rows($proceso2);
	if($contador2==0){
		$sql3 = "SELECT * FROM datos_pasantes WHERE id = ".$id;
		$proceso3 = mysqli_query($conexion,$sql3);
		while($row3 = mysqli_fetch_array($proceso3)) {
			$id_usuarios = $row3["id_usuarios"];
			$sql4 = "SELECT * FROM usuarios WHERE id = ".$id_usuarios;
			$proceso4 = mysqli_query($conexion,$sql4);
			while($row4 = mysqli_fetch_array($proceso4)) {
				$correo_personal = $row4["correo_personal"];
			}
		}
		$sql1 = "UPDATE datos_pasantes SET estatus = ".$estatus." WHERE id = ".$id;
		$proceso1 = mysqli_query($conexion,$sql1);
		if($estatus==2){
			$html = '';

			/***************APARTADO DE CORREO*****************/
			$mail = new PHPMailer(true);
			try {
			    $mail->isSMTP();
			    $mail->CharSet = "UTF-8";
			    $mail->Host = 'mail.camaleonpruebas.com';
			    $mail->SMTPAuth = true;
			    $mail->Username = 'test1@camaleonpruebas.com';
			    $mail->Password = 'juanmaldonado123';
			    $mail->SMTPSecure = 'tls';
			    $mail->Port = 587;

			    $mail->setFrom('test1@camaleonpruebas.com');
			    $mail->addAddress($correo_personal);
			    $mail->AddEmbeddedImage("img/mails/mailing modelo1.png", "my-attach", "mailing modelo1.png");
			    $html = "
			        <h2 style='color:#3F568A; text-align:center; font-family: Helvetica Neue,Helvetica,Arial,sans-serif;'>
			            <p>Felicitaciones tu perfil ha sido aprobado para formar parte de la familia Camaleón!.</p>
			            <p>El siguiente paso es completar tu formulario de contacto, puedes ingresar al sistema con los siguientes datos.</p>
			            <p>Usuario: | Clave: ".$clave_generada." </p>
			            <p>En el link.. https://www.camaleonmg.com</p>
			        </h2>
			        <div style='text-align:center;'>
			        	<img alt='PHPMailer' src='cid:my-attach'>
			        </div>
			    ";

			    $mail->isHTML(true);
			    $mail->Subject = 'Aprobacion Camaleon!';
			    $mail->Body    = $html;
			    $mail->AltBody = 'Este es el contenido del mensaje en texto plano';
			 
			    $mail->send();
			} catch (Exception $e) {}
			/**************************************************/

		}
		$datos = [
			"estatus"	=> "ok",
		];
	}else{
		$datos = [
			"estatus"	=> "repetidos",
		];
	}



	echo json_encode($datos);
}

?>