<?php
$sqlh1 = "SELECT * FROM funciones_usuarios WHERE id_usuarios = ".$_SESSION["camaleonapp_id"]." and id_usuario_rol = '".$_SESSION['camaleonapp_estatus']."' ORDER BY id_modulos ASC";
$procesoh1 = mysqli_query($conexion,$sqlh1);
$navbar1 = '';
while($row1 = mysqli_fetch_array($procesoh1)) {
	$id_modulos = $row1["id_modulos"];
	$sqlh2 = "SELECT * FROM modulos WHERE id = $id_modulos";
	$procesoh2 = mysqli_query($conexion,$sqlh2);
	while($row2 = mysqli_fetch_array($procesoh2)) {
		$modulos_nombre = $row2["nombre"];
		switch ($modulos_nombre) {
			case 'pasantes':
				if($ubicacion==$modulos_nombre){
					$navbar1 .= '
						<li class="nav-item active">
							<a class="nav-link" href="../pasantes/index.php">PASANTES</a>
						</li>
					';
				}else{
					$navbar1 .= '
						<li class="nav-item">
							<a class="nav-link" href="../pasantes/index.php">PASANTES</a>
						</li>
					';
				}
			break;

			case 'modelos':
				$sqlh3 = "SELECT * FROM modulos_sub_usuarios WHERE id_usuarios = ".$_SESSION["camaleonapp_id"];
				$procesoh3 = mysqli_query($conexion,$sqlh3);
				$contadorh3 = mysqli_num_rows($procesoh3);
				if($contadorh3>=1){
					if($ubicacion==$modulos_nombre){
						$navbar1 .= '
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle
						'; 
						if($ubicacion==$modulos_nombre){$navbar1 .= ' active ';}
						$navbar1 .= '" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MODELOS
								</a>
						';
					}
						
					$navbar1 .= '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
						
					while($row3 = mysqli_fetch_array($procesoh3)) {	
						$id_modulos_sub = $row3["id_modulos_sub"];
						echo $sqlh4 = "SELECT * FROM modulos_sub WHERE id = ".$id_modulos_sub;
						exit;
						$procesoh4 = mysqli_query($conexion,$sqlh4);
						while($row4 = mysqli_fetch_array($procesoh4)) {
							$modulos_sub_url = $row4["url"];
							$modulos_sub_nombre = $row4["nombre"];
							$navbar1 .= '<a class="dropdown-item" href="'.$modulos_sub_url.'">'.$modulos_sub_nombre.'</a>';
						}
					}
						
					$navbar1 .= '</div>';
					$navbar1 .= '</li>';
						
				}

			break;

			case 'paginas':
				if($ubicacion==$modulos_nombre){
					$navbar1 .= '
						<li class="nav-item active">
							<a class="nav-link" href="../paginas/index.php">PAGINAS</a>
						</li>
					';
				}else{
					$navbar1 .= '
						<li class="nav-item">
							<a class="nav-link" href="../paginas/index.php">PAGINAS</a>
						</li>
					';
				}
			break;

			case 'presabanas':
				if($ubicacion==$modulos_nombre){
					$navbar1 .= '
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								PRESABANAS
							</a>
					';
					$sqlh3 = "SELECT * FROM modulos_sub_usuarios WHERE id_usuarios = ".$_SESSION["camaleonapp_id"];
					$procesoh3 = mysqli_query($conexion,$sqlh3);
					$contadorh3 = mysqli_num_rows($procesoh3);
					if($contadorh3>=1){
						$navbar1 .= '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
						while($row3 = mysqli_fetch_array($procesoh3)) {	
							$id_modulos_sub = $row3["id_modulos_sub"];
							$sqlh4 = "SELECT * FROM modulos_sub WHERE id = ".$id_modulos_sub;
							$procesoh4 = mysqli_query($conexion,$sqlh4);
							while($row4 = mysqli_fetch_array($procesoh4)) {
								$modulos_sub_url = $row4["url"];
								$modulos_sub_nombre = $row4["nombre"];
								$navbar1 .= '<a class="dropdown-item" href="'.$modulos_sub_url.'">'.$modulos_sub_nombre.'</a>';
							}
						}
						$navbar1 .= '</div>';
					}
					$navbar1 .= '</li>';
				}else{
					$navbar1 .= '
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								PRESABANAS
							</a>
					';
					$sqlh3 = "SELECT * FROM modulos_sub_usuarios WHERE id_usuarios = ".$_SESSION["camaleonapp_id"];
					$procesoh3 = mysqli_query($conexion,$sqlh3);
					$contadorh3 = mysqli_num_rows($procesoh3);
					if($contadorh3>=1){
						$navbar1 .= '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
						while($row3 = mysqli_fetch_array($procesoh3)) {	
							$id_modulos_sub = $row3["id_modulos_sub"];
							$sqlh4 = "SELECT * FROM modulos_sub WHERE id = ".$id_modulos_sub;
							$procesoh4 = mysqli_query($conexion,$sqlh4);
							while($row4 = mysqli_fetch_array($procesoh4)) {
								$modulos_sub_url = $row4["url"];
								$modulos_sub_nombre = $row4["nombre"];
								$navbar1 .= '<a class="dropdown-item" href="../modelos/'.$modulos_sub_url.'">'.$modulos_sub_nombre.'</a>';
							}
						}
						$navbar1 .= '</div>';
					}
					$navbar1 .= '</li>';
				}
			break;
			
			default:
				# code...
				break;
		}
	}
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="../welcome/index.php">
		<img src="../img/logos/LOGOREDONDO-01.png" style="width: 70px;" class="img-fluid">
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<?php
			if($ubicacion=="Inicio"){
				echo '
					<li class="nav-item active">
						<a class="nav-link" href="../welcome/index.php">INICIO</a>
					</li>
				';
			}else{
				echo '
					<li class="nav-item">
						<a class="nav-link" href="../welcome/index.php">INICIO</a>
					</li>
				';
			}
			echo $navbar1;
			?>
			<!--
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Dropdown
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Action</a>
         			<a class="dropdown-item" href="#">Another action</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
      		</li>
      		-->
    	</ul>
  	</div>
</nav>