<?php session_start();  
 if (($_SESSION["nombre_usuario"]!="") && (($_SESSION['privilegios']=='ADMINISTRADOR') || ($_SESSION['privilegios']=='EDITOR'))){
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Actualizar Alumno</title>
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			//script para los botones "editar"
			$('.update').on('click',function(){
				console.log($(this).attr('datanombre'));
				//se obtienen los valores del registro a editar
				id = $(this).attr('dataid');
				apaterno = $(this).attr('dataapaterno');
				amaterno = $(this).attr('dataamaterno');
				nombre = $(this).attr('datanombre');
				telefono = $(this).attr('datatelefono');
				ciudad = $(this).attr('dataciudad');
				plantelprocedencia = $(this).attr('dataplantelprocedencia');

				//se vacian a los input text y se abilitan los text nombre, apellido y telefono
				$('[name=id]').val(id);
				$('[name=id]').attr('disabled',true);
				$('[name=apaterno]').val(apaterno);
				$('[name=apaterno]').attr('disabled',false);
				$('[name=amaterno]').val(amaterno);
				$('[name=amaterno]').attr('disabled',false);
				$('[name=nombre]').val(nombre);
				$('[name=nombre]').attr('disabled',false);
				$('[name=telefono]').val(telefono);
				$('[name=telefono]').attr('disabled',false);
				$('[name=ciudad]').val(ciudad);
				$('[name=ciudad]').attr('disabled',false);
				$('[name=plantelprocedencia]').val(plantelprocedencia);
				$('[name=plantelprocedencia]').attr('disabled',true);
				$('[name=btnact]').attr('disabled',false);
			});		
			//script para el boton "actualizar
			$('.actualizar').on('click',function(){

				id = $('[name=id]').val();
				apaterno = $('[name=apaterno]').val();
				amaterno = $('[name=amaterno]').val();
				nombre = $('[name=nombre]').val();
				telefono = $('[name=telefono]').val();
				ciudad = $('[name=ciudad]').val();
				plantelProcedencia = $('[name=plantelprocedencia]').val();
				$('[name=id]').attr('disabled',true);
				$('[name=apaterno]').attr('disabled',true);
				$('[name=amaterno]').attr('disabled',true);
				$('[name=nombre]').attr('disabled',true);
				$('[name=telefono]').attr('disabled',true);
				$('[name=ciudad]').attr('disabled',true);
				$('[name=plantelprocedencia]').attr('disabled',true);
				//se envian a actulizar2.php para el proceso de actualizacion con ayuda de ajax
				$.ajax({
					url:"actualizar2.php",
					data:{
						id:id,
						apaterno:apaterno,
						amaterno:amaterno,
						nombre:nombre,
						telefono:telefono,
						ciudad:ciudad,
						plantelprocedencia:plantelprocedencia
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
<h1>Editar Alumno</h1>

<?php
	include_once'./conexion.php';
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());
?>
	<table>
		<tr>
			<!--<label>Id</label>-->
			<input type="hidden" disabled="true" name="id" value="" class="form-control" maxlength="10"/>
		</tr>
		<tr>
			<label>Apellido Paterno</label>
			<input type="text" disabled="true" name="apaterno" value="" class="form-control" maxlength="30" required/>
		</tr>
		<tr>
			<label>Apellido Materno</label>
			<input type="text" disabled="true" name="amaterno" value="" class="form-control" maxlength="30"/>
		</tr>
		<tr>
			<label>Nombre</label>
			<input type="text" disabled="true" name="nombre" value="" class="form-control" maxlength="30" required/>
		</tr>
		<tr>
			<label>Teléfono</label>
			<input type="text" disabled="true" name="telefono" value="" class="form-control" maxlength="10" />
		</tr>
		<tr>
			<label>Ciudad</label>
			<input type="text" disabled="true" name="ciudad" value="" class="form-control" maxlength="20" required/>
		</tr>
		<tr>
			<label>Plantel de Procedencia</label>
			<input type="text" disabled="true" name="plantelprocedencia" value="" class="form-control" maxlength="60" required/>
		</tr>
		<br />
			<div class="col-md-2">
				<button disabled="true" name="btnact"  class="btn btn-primary btn-block actualizar">Actualizar</button>
			</div>
		<br />
		<br />
	</table>
<?php
	$sql = "select * from alumno Order By apaterno, amaterno, nombre";
	$result = pg_query($cnx,$sql);
	echo '<table border=0 class="table table-condensed">';
	echo "<thead><tr><th>Apellido Paterno</th><th>Apellido Materno</th><th>Nombre</th><th>Teléfono</th><th>Ciudad</th>
	<th>Plantel de Procedencia</th></tr></thead>";

	while($row = pg_fetch_array($result)){
		echo "<tr>";
		echo "<td>" . $row['apaterno'] . "</td>";
		echo "<td>" . $row['amaterno'] . "</td>";
		echo "<td>" . $row['nombre'] . "</td>";
		echo "<td>" . $row['telefono'] . "</td>";
		echo "<td>" . $row['ciudad'] . "</td>";
		echo "<td>" . $row['plantelprocedencia'] . "</td>";
		echo '<td><button class="btn btn-default update" dataid="' . $row['id'] . '" dataapaterno="' . $row['apaterno'] . '" 
		dataamaterno="' . $row['amaterno'] . '" datanombre="' . $row['nombre'] . '"  
		datatelefono="' . $row['telefono'] . '" dataciudad="' . $row['ciudad'] . '" 
		dataplantelprocedencia="' . $row['plantelprocedencia'] . '"><i class="fa fa-gear"></i>Editar</button>' . "</td>" . "\n";
		
		echo "</tr>" . "\n";
	}
	echo "</table>";

	pg_close($cnx);
	
	if($_SESSION['privilegios']=='ADMINISTRADOR'){
	echo '<div class="col-md-2"><a href="borrar.php"  target="_self"><input type="button" class="btn btn-danger" value="Eliminar Registro" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="insertar.php"  target="_self"><input type="button" value="Insertar Registro" class="btn btn-primary"/></a></div>';
	echo '<div class="col-md-2"><a href="pdf.php"  target="_self"><input type="button" class="btn btn-danger" value="Generar Reporte" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="admusuarios.php"  target="_self"><input type="button" class="btn btn-danger" value="USUARIOS" class="btn"/></a></div>';
	echo '<div class="col-md-2"></div>';
	echo '<div class="col-md-2"><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></div>';
	}else if($_SESSION['privilegios']=='EDITOR'){
	echo '<div class="col-md-2"><a href="borrar.php"  target="_self"><input type="button" class="btn btn-danger" value="Eliminar Registro" class="btn"/></a></div>';
	echo '<div class="col-md-2"><a href="insertar.php"  target="_self"><input type="button" value="Insertar Registro" class="btn btn-primary"/></a></div>';
	echo '<div class="col-md-2"><a href="pdf.php"  target="_self"><input type="button" class="btn btn-danger" value="Generar Reporte" class="btn"/></a></div>';
	echo '<div class="col-md-2"></div>';
	echo '<div class="col-md-2"><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></div>';
	}
?>

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
