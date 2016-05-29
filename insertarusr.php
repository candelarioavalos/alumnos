<?php session_start(); 
 if ($_SESSION['privilegios']=='ADMINISTRADOR'){
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Insertar a tabla</title>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container well">
<center><h4>Bienvenido <?php echo $_SESSION["nombre_usuario"].' ('.$_SESSION['privilegios'].')'; ?></h4></center>
</br>
<h1>Registrar Usuario</h1>
<?php
	include_once'./conexion.php';
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());

	##ejecutamos la consulta
	if($_POST){
		if (isset($_POST)){
		$sql = "INSERT INTO usuario (usuario,contrasena,privilegio) VALUES ('".pg_escape_string($_POST['usuario'])
							."','".pg_escape_string($_POST['contrasena'])."','".($_POST['privilegio'])."');";
		$result=pg_query($cnx, $sql);
			if(!$result){
				echo "Query: Un error a ocurrido.\n";
				exit;
			}
	}
	if ($_POST) { 
		echo "<div class=\"info\">Registro insertado
		<a href=\"./insertar.php\">volver</a></div>";
	}
}
?>

<form action="" method="post">
<table>
	<tr>
	<label>Nombre de Usuario</label>
	<input type="text" name="usuario" value="" class="form-control" maxlength="30" required/>
	</tr>
	<tr>
	<label>Contraseña</label>
	<input type="text" name="contrasena" value="" class="form-control" maxlength="30" required/>
	</tr>
	<tr>
	<label>Privilegio</label>
	<select class="form-control" name="privilegio" value="" required>
			<option></option>
  			<option>ADMINISTRADOR</option>
  			<option>CONSULTOR</option>
  			<option>EDITOR</option>
		</select>
	</tr>
	<br />
	<div class="col-md-2"><input type="submit" value="Guardar" class="btn btn-primary btn-block"/></div>
	<br />
	<br />
</table>
</form>

<?php
	$sql = "select * from usuario Order By usuario";
	$result = pg_query($cnx,$sql);
	
	echo '<table border=0 class="table table-striped">';
	echo "<thead><tr><th>Usuario</th><th>Privilegio</th></tr></thead>";
	while($row = pg_fetch_array($result)){
		echo "<tr>";
		echo "<td>" . $row['usuario'] . "</td>";
		echo "<td>" . $row['privilegio'] . "</td>";
	}
	echo "</table>";
     
	pg_close($cnx);
	
	echo '<div class="col-md-2"><a href="borrarusr.php"  target="_self"><input type="button" class="btn btn-danger" value="Eliminar Usuario" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="admusuarios.php"  target="_self"><input type="button" class="btn btn-danger" value="Editar Usuario" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="pdfusuarios.php"  target="_self"><input type="button" class="btn btn-danger" value="Generar Reporte" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="insertar.php"  target="_self"><input type="button" class="btn btn-danger" value="ALUMNOS" class="btn"/></a></div>';
	echo '<div class="col-md-2"></div>';
	echo '<div class="col-md-2"><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></div>';
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

