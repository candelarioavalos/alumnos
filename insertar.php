<?php session_start(); 
 if (($_SESSION["nombre_usuario"]!="") && (($_SESSION['privilegios']=='ADMINISTRADOR') || ($_SESSION['privilegios']=='EDITOR'))){
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Registrar Alumno</title>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container well">
<center><h4>Bienvenido <?php echo $_SESSION["nombre_usuario"].' ('.$_SESSION['privilegios'].')'; ?></h4></center>
</br>
<h1>Registrar Alumno</h1>
<?php
	include_once'./conexion.php';
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());

	##ejecutamos la consulta
	if($_POST){

		$sql = "INSERT INTO alumno (apaterno,amaterno,nombre,telefono,ciudad,plantelprocedencia) 
		VALUES ('".pg_escape_string($_POST['apaterno'])."','".pg_escape_string($_POST['amaterno'])."',
			'".pg_escape_string($_POST['nombre'])."','".pg_escape_string($_POST['telefono'])."',
			'".pg_escape_string($_POST['ciudad'])."', '".pg_escape_string($_POST['plantelprocedencia'])."');";

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
?>

<form action="" method="post">
<table>
	<tr>
	<label>Apellido Paterno</label>
	<input type="text" name="apaterno" value="" class="form-control" maxlength="30" required/>
	</tr>
	<tr>
	<label>Apellido Materno</label>
	<input type="text" name="amaterno" value="" class="form-control" maxlength="30"/>
	</tr>
	<tr>
	<label>Nombre</label>
	<input type="text" name="nombre" value="" class="form-control" maxlength="30" required/>
	</tr>
	<tr>
	<label>Teléfono</label>
	<input type="text" name="telefono" value="" class="form-control" maxlength="10" />
	</tr>
	<tr>
	<label>Ciudad</label>
	<input type="text" name="ciudad" value="" class="form-control" maxlength="20" required/>
	</tr>
	<tr>
	<label>Plantel de Procedencia</label>
	<input type="text" name="plantelprocedencia" value="" class="form-control" maxlength="60" required/>
	</tr>
	<br />
	<div class="col-md-2"><input type="submit" value="Guardar" class="btn btn-primary btn-block"/></div>
	<br />
	<br />
</table>
</form>

<?php
	$sql = "select * from alumno Order By apaterno, amaterno, nombre";
	$result = pg_query($cnx,$sql);
	echo '<table border=0 class="table table-condensed">';
	echo "<thead><tr><th>Apellido Paterno</th><th>Apellido Materno</th><th>Nombre</th>
	<th>Teléfono</th><th>Ciudad</th><th>Plantel de Procedencia</th></tr></thead>";
	while($row = pg_fetch_array($result)){
		echo "<tr>";
		//echo "<td>" . $row['id'] . "</td>";
		echo "<td>" . $row['apaterno'] . "</td>";
		echo "<td>" . $row['amaterno'] . "</td>";
		echo "<td>" . $row['nombre'] . "</td>";
		echo "<td>" . $row['telefono'] . "</td>";
		echo "<td>" . $row['ciudad'] . "</td>";
		echo "<td>" . $row['plantelprocedencia'] . "</td>";
		
		echo "</tr>" . "\n";
	}
	echo "</table>";
     
	pg_close($cnx);

	if($_SESSION['privilegios']=='ADMINISTRADOR'){
	echo '<div class="col-md-2"><a href="borrar.php"  target="_self"><input type="button" class="btn btn-danger" value="Eliminar Registro" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="actualizar.php"  target="_self"><input type="button" class="btn btn-danger" value="Actualizar Registro" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="pdf.php"  target="_self"><input type="button" class="btn btn-danger" value="Generar Reporte" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="insertarusr.php"  target="_self"><input type="button" class="btn btn-danger" value="USUARIOS" class="btn"/></a></div>';
	echo '<div class="col-md-2"></div>';
	echo '<div class="col-md-2"><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></div>';
	}
	if($_SESSION['privilegios']=='EDITOR'){
	echo '<div class="col-md-2"><a href="borrar.php"  target="_self"><input type="button" class="btn btn-danger" value="Eliminar Registro" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="actualizar.php"  target="_self"><input type="button" class="btn btn-danger" value="Actualizar Registro" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="pdf.php"  target="_self"><input type="button" class="btn btn-danger" value="Generar Reporte" class="btn"/></a></div>';
	echo '<div class="col-md-2"></div>';
	echo '<div class="col-md-2"><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></div>';
	}
?>

</div>
</body>
</html>
<?PHP
}else
if (($_SESSION["nombre_usuario"]!="") && ($_SESSION['privilegios']=='CONSULTOR')){
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Registrar Alumno</title>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container well">
<center><h4>Bienvenido <?php echo $_SESSION["nombre_usuario"].' ('.$_SESSION['privilegios'].')'; ?></h4></center>
</br>
<h1>Registrar Alumno</h1>


<?php

	include_once'./conexion.php';
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());


	$sql = "select * from alumno Order By apaterno, amaterno, nombre";
	$result = pg_query($cnx,$sql);
	echo '<table border=0 class="table table-condensed">';
	echo "<thead><tr><th>Apellido Paterno</th><th>Apellido Materno</th><th>Nombre</th>
	<th>Teléfono</th><th>Ciudad</th><th>Plantel de Procedencia</th></tr></thead>";
	while($row = pg_fetch_array($result)){
		echo "<tr>";
		echo "<td>" . $row['apaterno'] . "</td>";
		echo "<td>" . $row['amaterno'] . "</td>";
		echo "<td>" . $row['nombre'] . "</td>";
		echo "<td>" . $row['telefono'] . "</td>";
		echo "<td>" . $row['ciudad'] . "</td>";
		echo "<td>" . $row['plantelprocedencia'] . "</td>";
		
		echo "</tr>" . "\n";
	}//while
	echo "</table>";
     
	pg_close($cnx);

	echo '<div class="col-md-2"><a href="pdf.php"  target="_self"><input type="button" class="btn btn-danger" value="Generar Reporte" class="btn"/></a></div>';
	echo '<div class="col-md-6"></div>';
	echo '<div class="col-md-2"></div>';
	echo '<div class="col-md-2"><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></div>';
	
	}//if consultor

else{//si no es un usuario
		session_start();
		session_unset();
		//Matamos la sesion
		session_destroy();
		header('Location: index.html');
	exit();}
?>
</div>
</body>
</html>

