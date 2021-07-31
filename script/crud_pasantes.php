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
$fecha_creacion = date('Y-m-d');
$fecha_modificacion = date('Y-m-d');

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

	$sql1 = "SELECT 
		us.id as usuario_id,
		dpa.id as pasante_id,
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
		dpa.fecha_creacion as fecha_creacion,
		us.id_empresa as usuario_empresa
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
	";

	$sql2 = "SELECT 
		us.id as usuario_id,
		dpa.id as pasante_id,
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
		dpa.estatus as pasantes_estatus,
		pa.nombre as pais,
		pa.codigo as pais_codigo,
		se.nombre as sede,
		se.id as id_sede,
		dpa.fecha_creacion as fecha_creacion,
		us.id_empresa as usuario_empresa
		FROM usuarios us
		INNER JOIN datos_pasantes dpa
		ON us.id = dpa.id_usuarios 
		INNER JOIN documento_tipo dti
		ON us.documento_tipo = dti.id
		INNER JOIN genero ge
		ON us.genero = ge.id
		INNER JOIN sedes se
		ON dpa.sede = se.id 
		INNER JOIN empresas em
		ON us.id_empresa = em.id 
		INNER JOIN paises pa
		ON pa.id = us.id_pais
		WHERE us.id != 0 
		".$filtrado." 
		".$sede." 
		ORDER BY dpa.fecha_creacion DESC LIMIT ".$limit." OFFSET ".$offset."
	";

	$proceso1 = mysqli_query($conexion,$sql1);
	$proceso2 = mysqli_query($conexion,$sql2);
	$conteo1 = mysqli_num_rows($proceso1);
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
			if($row2["pasantes_estatus"]==1){
				$pasante_estatus = "Proceso";
			}else if($row2["pasantes_estatus"]==2){
				$pasante_estatus = "Aceptado";
			}else if($row2["pasantes_estatus"]==3){
				$pasante_estatus = "Rechazado";
			}
			$html .= '
		                <tr id="tr_'.$row2["pasante_id"].'">
		                    <td style="text-align:center;">'.$row2["documento_tipo"].'</td>
		                    <td style="text-align:center;">'.$row2["documento_numero"].'</td>
		                    <td>'.$row2["nombre1"]." ".$row2["nombre2"]." ".$row2["apellido1"]." ".$row2["apellido2"].'</td>
		                    <td style="text-align:center;">'.$row2["genero"].'</td>
		                    <td style="text-align:center;">'.$row2["correo"].'</td>
		                    <td style="text-align:center;">'.$row2["telefono"].'</td>
		                    <td  style="text-align:center;">'.$pasante_estatus.'</td>
		                    <td style="text-align:center;">'.$row2["sede"].'</td>
		                    <td nowrap="nowrap">'.$row2["fecha_creacion"].'</td>
		    ';
		    if($row2["pasantes_estatus"]==1){
		    	$html .= '
		    				<td class="text-center" nowrap="nowrap">
					    		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#aceptar_pasante1_modal1" onclick="aceptar_pasante1_modal1('.$row2["pasante_id"].','.$row2["usuario_id"].');">A</button>
					    		<button type="button" class="btn btn-danger" onclick="rechazar_pasante1('.$row2["pasante_id"].','.$row2["usuario_id"].');">R</button>
		    		 		</td>
		    	';
		    }else if($row2["pasantes_estatus"]==2){
		    	$html .= '
		    				<td class="text-center" nowrap="nowrap">
					    		<button type="button" class="btn btn-danger" onclick="rechazar_pasante1('.$row2["pasante_id"].','.$row2["usuario_id"].');">R</button>
		    		 		</td>
		    	';
		    }else if($row2["pasantes_estatus"]==3){
		    	$html .= '
		    				<td class="text-center" nowrap="nowrap">
					    		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#aceptar_pasante1_modal1" onclick="aceptar_pasante1_modal1('.$row2["pasante_id"].','.$row2["usuario_id"].');">A</button>
		    		 		</td>
		    	';
		    }
		    
		    $html .= '
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

if($condicion=='aceptar_pasante1'){
	$turno = $_POST["turno"];
	$sede = $_POST["sede"];
	$usuario_id = $_POST["usuario_id"];
	$pasante_id = $_POST["pasante_id"];

	/**********CREACION DE LA FUNCION PARA WHATSAPP**********/
	function sendMessage($to,$msg){
		$data = [
			'phone' => $to,
			'body' => $msg,
		];

		include('conexion.php');

		$sql9 = "SELECT * FROM apiwhatsapp";
		$proceso9 = mysqli_query($conexion,$sql9);
		while($row9 = mysqli_fetch_array($proceso9)) {
			$CHAT_URL = $row9["url"];
			$CHAT_TOKEN = $row9["token"];
		}

		$json = json_encode($data);
		$url = 'https://api.chat-api.com/'.$CHAT_URL.'/sendMessage?token='.$CHAT_TOKEN;
		$options = stream_context_create(['http' => [
				'method' => 'POST',
				'header' => 'Content-type: application/json',
				'content' => $json
			]
		]);

		$result = file_get_contents($url, false, $options);
		if($result) return json_decode($result);

		return false;
	}
	/***********************************************************/

	$sql1 = "SELECT * FROM usuarios WHERE id = ".$usuario_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$estatus_pasantes = $row1["estatus_pasantes"];
		$usuario_estatus_modelo = $row1["estatus_modelo"];
		$correo = $row1["correo_personal"];
		$telefono = $row1["telefono"];
		$id_pais = $row1["id_pais"];

		if($usuario_estatus_modelo>=1){

			$datos = [
				"estatus"	=> "error",
				"msg"	=> "Ya tiene un perfil de Modelo Creado!",
			];
		
			echo json_encode($datos);
			exit;

		}else if($usuario_estatus_modelo==0){
			$sql2 = "SELECT * FROM datos_modelos WHERE id_usuarios = ".$usuario_id;
			$proceso2 = mysqli_query($conexion,$sql2);
			$conteo2 = mysqli_num_rows($proceso2);

			if($conteo2>=1){
				$datos = [
					"estatus"	=> "error",
					"msg"	=> "Ya tiene un perfil de Modelo Creado!",
				];
				echo json_encode($datos);
				exit;
			}else if($conteo2==0){
				$sql3 = "INSERT INTO datos_modelos (id_usuarios,turno,sede,estatus,fecha_creacion) VALUES (".$usuario_id.",".$turno.",".$sede.",2,'".$fecha_creacion."')";
				$proceso3 = mysqli_query($conexion,$sql3);
				$sql4 = "UPDATE usuarios SET estatus_pasantes = 1, estatus_modelo = 1, fecha_modificacion = '".$fecha_modificacion."' WHERE id = ".$usuario_id;
				$proceso4 = mysqli_query($conexion,$sql4);
				$sql5 = "UPDATE datos_pasantes SET estatus = 2, fecha_modificacion = '".$fecha_modificacion."' WHERE id = ".$pasante_id;
				$proceso5 = mysqli_query($conexion,$sql5);

				$sql6 = "SELECT * FROM paises WHERE id = ".$id_pais;
				$proceso6 = mysqli_query($conexion,$sql6);
				while($row6 = mysqli_fetch_array($proceso6)) {
					$codigo_pais = $row6["codigo"];
				}

				/*****************APARTADO DE WHATSAPP************/
				$msg = "Felicitaciones tu perfil ha sido aprobado para formar parte de la familia Camaleón!
				El siguiente paso es completar tu formulario de contacto, puedes ingresar al sistema en el siguiente link https://www.camaleonmg.com";
				$phone = $codigo_pais.$telefono;
				$result = sendMessage($phone,$msg);
				if($result !== false){
					if($result->sent == 1){}else{}
				}else{
					var_dump($result);
				}
				/***************************************************/

				/***************APARTADO DE CORREO*****************/
				$mail = new PHPMailer(true);
				try {
				    $mail->isSMTP();
				    $mail->CharSet = "UTF-8";
				    $mail->Host = 'mail.camaleonmg.com';
				    $mail->SMTPAuth = true;
				    $mail->Username = 'noreply@camaleonmg.com';
				    $mail->Password = 'juanmaldonado123';
				    $mail->SMTPSecure = 'tls';
				    $mail->Port = 587;

				    $mail->setFrom('noreply@camaleonmg.com');
				    $mail->addAddress($correo);
				    $html = "
				        <h2 style='color:#3F568A; text-align:center; font-family: Helvetica Neue,Helvetica,Arial,sans-serif;'>
				            Felicitaciones tu perfil ha sido aprobado para iniciar como modelo.
				            El siguiente paso es completar tu formulario de contacto, puedes ingresar al sistema en el siguiente link https://www.camaleonmg.com
				        </h2>
				    ";

				    $mail->isHTML(true);
				    $mail->Subject = 'Aprobacion Camaleon!';
				    $mail->Body    = $html;
				    $mail->AltBody = 'Este es el contenido del mensaje en texto plano';
				 
				    $mail->send();
				} catch (Exception $e) {}
				/**************************************************/

				$datos = [
					"estatus"	=> "ok",
					"msg"	=> "Estatus Cambiado!",
				];
				echo json_encode($datos);
				exit;
			}
		}
	}
}

if($condicion=='rechazar_pasante1'){
	$usuario_id = $_POST["usuario_id"];
	$pasante_id = $_POST["pasante_id"];

	$sql1 = "SELECT * FROM usuarios WHERE id = ".$usuario_id;
	$proceso1 = mysqli_query($conexion,$sql1);
	while($row1 = mysqli_fetch_array($proceso1)) {
		$estatus_pasantes = $row1["estatus_pasantes"];
		$usuario_estatus_modelo = $row1["estatus_modelo"];

		if($usuario_estatus_modelo>=1){

			$datos = [
				"estatus"	=> "error",
				"msg"	=> "Ya tiene un perfil de Modelo Creado!",
			];
		
			echo json_encode($datos);
			exit;

		}else if($usuario_estatus_modelo==0){
			$sql2 = "SELECT * FROM datos_modelos WHERE id_usuarios = ".$usuario_id;
			$proceso2 = mysqli_query($conexion,$sql2);
			$conteo2 = mysqli_num_rows($proceso2);

			if($conteo2>=1){
				$datos = [
					"estatus"	=> "error",
					"msg"	=> "Ya tiene un perfil de Modelo Creado!",
				];
				echo json_encode($datos);
				exit;
			}else if($conteo2==0){
				$sql5 = "UPDATE datos_pasantes SET estatus = 3 WHERE id = ".$pasante_id;
				$proceso5 = mysqli_query($conexion,$sql5);
				$datos = [
					"estatus"	=> "ok",
					"msg"	=> "Estatus Cambiado!",
				];
				echo json_encode($datos);
				exit;
			}
		}
	}
}

?>