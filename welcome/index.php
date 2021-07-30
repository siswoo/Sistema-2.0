<?php
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Camaleon Sistem</title>
  </head>
<body>

<?php
$ubicacion='Inicio';
include("../script/conexion.php");
include("../permisologia.php");
include("../header.php");
?>

</body>
</html>

<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>

	$('#myModal').on('shown.bs.modal', function () {
	  	$('#myInput').trigger('focus')
	});

	$("#formulario1").on("submit", function(e){
		e.preventDefault();
		var f = $(this);
		var usuario = $('#usuario').val();
		var clave = $('#clave').val();
		var estatus = $('#estatus').val();
		$.ajax({
	        url: 'script/crud_usuarios.php',
	        type: 'POST',
	        dataType: "JSON",
	        data: {
				"usuario": usuario,
				"clave": clave,
				"estatus": estatus,
				"condicion": "login1",
			},

	        beforeSend: function (){},

	        success: function(respuesta){
	        	console.log(respuesta);
	        	if(respuesta["estatus"]=="sin resultados"){
	        		Swal.fire({
						title: 'Error',
						text: "Datos Incorrectos!",
						icon: 'error',
						position: 'center',
						showConfirmButton: false,
						timer: 2000
					});	
	        	}else{
	        		$('#usuario_id').val(respuesta["usuario_id"]);
	        		$('#usuario_estatus').val(respuesta["estatus"]);
	        		$('#formulario2').submit();
	        	}
	        },

	        error: function(respuesta){
	           	console.log(respuesta['responseText']);
	        }
	    });
	});

	$("#form_modal_recuperar1").on("submit", function(e){
		e.preventDefault();
		var f = $(this);
		var recovery_correo = $('#recovery_correo').val();
		var recovery_estatus = $('#recovery_estatus').val();
		$.ajax({
	        url: '../script/crud_usuarios.php',
	        type: 'POST',
	        data: {
				"recovery_correo": recovery_correo,
				"recovery_estatus": recovery_estatus,
				"condicion": "recuperar_contraseña1",
			},

	        beforeSend: function (){},

	        success: function(response){
	        	console.log(response);
	        	Swal.fire({
					title: 'Correcto!',
					text: "Correo enviado satisfactoriamente",
					icon: 'success',
					position: 'center',
					showConfirmButton: false,
					timer: 2000
				});

				$("#exampleModal1").modal('hide');
				$('#exampleModal1').removeClass('modal-open');
				$('.modal-backdrop').remove();
	        },

	        error: function(response){
	           	console.log(response['responseText']);
	        }
	    });
	});

</script>