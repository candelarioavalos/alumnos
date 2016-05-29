<?php session_start(); 
 if ($_SESSION['privilegios']=='ADMINISTRADOR'){
?>
<html> 
<head>
	<meta charset="UTF-8">
	<title>Actualizar Usuario</title>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			//script para los botones "editar"
			$('.update').on('click',function(){
				console.log($(this).attr('datanombre'));
				//se obtienen los valores del registro a editar
				usr = $(this).attr('datausr');
				pvg = $(this).attr('datapvg');
				//se vacian a los input text y se abilitan los text usurio, contraseña y privilegio
				$('[name=usr]').val(usr);
				$('[name=usr]').attr('disabled',true);
				$('[name=pvg]').val(pvg);
				$('[name=pvg]').attr('disabled',false);
				$('[name=btnact]').attr('disabled',false);
			});		
			//script para el boton "actualizar
			$('.actualizar').on('click',function(){
				usr = $('[name=usr]').val();
				pvg = $('[name=pvg]').val();
				$('[name=usr]').attr('disabled',true);
				$('[name=pvg]').attr('disabled',true);
				//se envian a admusuarios2.php para el proceso de actualizacion con ayuda de ajax
				$.ajax({
					url:"admusuarios2.php",
					data:{
						//nombre de variable que vas a enviar : nombre de la variable que esta almacenada la información
						usuario:usr,
						privilegio:pvg
					},
					type:'post',
					success:function(data){
					    console.log(data);
					    location.reload(true);
					},
				});
			});
		});
	</script>
</head>
<body>
<div class="container well">
	<center><h4>Bienvenido <?php echo $_SESSION["nombre_usuario"].' ('.$_SESSION['privilegios'].')'; ?></h4></center>
</br>
<h1>Editar Usuario</h1>

<?php
	include_once'./conexion.php';
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());
?>

<table>
	<tr>
		<label>Usuario</label>
		<input type="text" disabled="true" name="usr" value="" class="form-control" maxlength="30"/>
	</tr>
	<tr>
		<label>Privilegio</label>
		<select class="form-control" disabled="true" name="pvg" value="">
  			<option>ADMINISTRADOR</option>
  			<option>CONSULTOR</option>
  			<option>EDITOR</option>
		</select>
	</tr>
	<br/>
		<div class="col-md-2">
			<button disabled="true" name="btnact"  class="btn btn-primary btn-block actualizar">Actualizar</button>
		</div>
	<br />
	<br />
</table>

<?php
	$sql = "select * from usuario Order By usuario";
	$result = pg_query($cnx,$sql);
	echo '<table border=0 class="table table-condensed">';
	echo "<thead><tr><th>Usuario</th><th>Privilegio</th></tr></thead>";
	while($row = pg_fetch_array($result)){
		echo "<tr>";
		echo "<td>" . $row['usuario'] . "</td>";
		echo "<td>" . $row['privilegio'] . "</td>";
		echo '<td><button class="btn btn-default update" datausr="' . $row['usuario'] . '" 
		datapvg="' . $row['privilegio'] . '"><i class="fa fa-gear"></i>Editar</button>' . "\n";
		echo "</tr>" . "\n";
	}
	echo "</table>";

	pg_close($cnx);

	if($_SESSION['privilegios']=='ADMINISTRADOR'){
	echo '<br />';
	echo '<div class="col-md-2"><a href="borrarusr.php"  target="_self"><input type="button" class="btn btn-danger" value="Eliminar Usuario" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="insertarusr.php"  target="_self"><input type="button" value="Nuevo Usuario" class="btn btn-primary"/></a></div>';
	echo '<div class="col-md-2"><a href="pdfusuarios.php"  target="_self"><input type="button" class="btn btn-danger" value="Generar Reporte" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="insertar.php"  target="_self"><input type="button" class="btn btn-danger" value="ALUMNOS" class="btn"/></a></div>';
	echo '<div class="col-md-2"></div>';
	echo '<div class="col-md-2"><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></div>';
	}
?>
    
</div>
</body>
</html>
<?PHP 
}else{//si no es un usuario
		session_start();
		session_unset();
		//Matamos la sesion
		session_destroy();
		header('Location: index.html');
	exit();}
?>

