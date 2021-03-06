<?php session_start(); 
 if ($_SESSION['privilegios']=='ADMINISTRADOR'){
?>
<!DOCTYPE html> 
<html>
<head>
	<title>Eliminar Usuario</title>
</head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		//al momento que den click al boton eliminar entra la funcion
		$('.eliminar').on('click',function(){
			usuario = $(this).attr('data');
			//codigo para crear el efecto de eliminar 
			$(this).parent().parent().hide(500);
			//ajax==>JavaScript asíncrono, Estas aplicaciones se ejecutan en el cliente, 
			//es decir, en el navegador de los usuarios mientras se mantiene la comunicación 
			//asíncrona con el servidor en segundo plano. De esta forma es posible realizar cambios sobre 
			//las páginas sin necesidad de recargarlas, mejorando la interactividad, velocidad y usabilidad en las aplicaciones.
			$.ajax({
				//SE LLAMA A borrar2 para efectar la eliminacion del registro
				url:"borrarusr2.php",
				//se envia el paramettro id que vale lo que tenga  el id
				//nombre_de_variable_que_resive_php:recurso_javascript,
				data:{usuario:usuario},
				//se declara el tipo de envio
				type:'post',
				//funcion de control, solo se ve el resultado en consola de explorador
				success:function(data){
					console.log(data);
				}
			});
		});
	});

</script>
<body>
<div class="container well">
<center><h4>Bienvenido <?php echo $_SESSION["nombre_usuario"].' ('.$_SESSION['privilegios'].')'; ?></h4></center>
</br>
<h1>Eliminar Usuario</h1>

<?php
include_once'./conexion.php';
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());

	$sql = "select * from usuario Order By usuario";
	$result = pg_query($cnx,$sql);
	echo '<table border=0 class="table table-condensed">';
	echo "<thead><tr><th>Usuario</th><th>Privilegio</th></tr></thead>";
	while($row = pg_fetch_array($result)){
		echo "<tr>" . "\n";
		echo "<td>" . $row['usuario'] . "</td>";
		echo "<td>" . $row['privilegio'] . "</td>";
		echo '<td><button class="btn btn-default eliminar" data="' . $row['usuario'] . '"><i class="fa fa-gear"></i>Eliminar</button>' . "\n";
		echo "</tr>" . "\n";
	}
	echo "</table>";
?>
	<div class="col-md-2"><a href="insertarusr.php"  target="_self"><input type="button" value="USUARIOS" class="btn btn-primary"/></a></div>
	<div class="col-md-2"><a href="insertar.php"  target="_self"><input type="button" value="ALUMNOS" class="btn btn-primary"/></a></div>
	<div class="col-md-2"></div>
	<div class="col-md-2"></div>
	<div class="col-md-2"><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></div>

</div>
</body>
</html>

<?php 
}else{//si no es un usuario
		session_start();
		session_unset();
		//Matamos la sesion
		session_destroy();
		header('Location: index.html');
	exit();}
?>
