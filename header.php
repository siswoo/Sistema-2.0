<?php
$sql1 = "SELECT mo.nombre as modulo_nombre, mosub.url as modulo_sub_url, mosub.nombre as modulo_sub_nombre FROM modulos mo 
INNER JOIN modulos_sub mosub 
ON mo.id = mosub.id_modulos 
INNER JOIN modulos_empresas moem 
ON mo.id = moem.id_modulos 
INNER JOIN funciones_usuarios fuus 
ON mo.id = fuus.id_modulos 
INNER JOIN modulos_sub_usuarios mosuus 
ON mosub.id = mosuus.id_modulos_sub 
WHERE mo.estatus = 1 and mosub.estatus = 1 and moem.id_empresas = ".$_SESSION['camaleonapp_empresa']." and moem.estatus = 1 and fuus.id_usuarios = ".$_SESSION['camaleonapp_id']." and fuus.id_usuario_rol = '".$_SESSION['camaleonapp_estatus']."' and fuus.id_empresa = ".$_SESSION['camaleonapp_empresa']." and mosuus.id_usuarios = ".$_SESSION['camaleonapp_id'];
$proceso1 = mysqli_query($conexion,$sql1);
$navbar1 = '';
$modulo_repetido = '';
$sub_modulo_repetido = '';
$navbar_contador1 = 0;
$navbar_contador2 = 0;

while($row1 = mysqli_fetch_array($proceso1)) {
	$modulo_nombre = $row1["modulo_nombre"];
	$modulo_sub_url = $row1["modulo_sub_url"];
	$modulo_sub_nombre = $row1["modulo_sub_nombre"];

	if($modulo_repetido!=$modulo_nombre){

		if($navbar_contador1>=1){
			$navbar1 .= '</div></li>';
		}

		$modulo_repetido = $modulo_nombre;
		$navbar_contador1 = $navbar_contador1+1;
		$navbar1 .= '
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.mb_strtoupper($modulo_nombre).'</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="../'.$modulo_nombre."/".$modulo_sub_url.'">'.$modulo_sub_nombre.'</a>
		';
	}else if($sub_modulo_repetido!=$modulo_sub_url){
		$sub_modulo_repetido = $modulo_sub_url;
		$navbar1 .= '
				<a class="dropdown-item" href="../'.$modulo_nombre."/".$modulo_sub_url.'">'.$modulo_sub_nombre.'</a>
		';
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
    	</ul>
  	</div>
</nav>