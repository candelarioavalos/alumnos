
<?php 
include_once('./conexion.php');
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());
	//isset---->determina si una variable ha sido declarada y su valor no es NULO. 
	if(isset($_POST['id'])){
		//pasar lineas a nuevo documento
		//utilizar ajax para hacer una petición asíncrona al servidor
		echo "<pre>";
		print_r($_POST);
		echo "<hr>";
		var_dump($_POST);

		$sql = "UPDATE alumno SET apaterno='".pg_escape_string($_POST['apaterno'])."', 
		amaterno='".pg_escape_string($_POST['amaterno'])."', 
		nombre='".pg_escape_string($_POST['nombre'])."', 
		telefono='".pg_escape_string($_POST['telefono'])."', 
		ciudad='".pg_escape_string($_POST['ciudad'])."', 
		plantelprocedencia='".pg_escape_string($_POST['plantelprocedencia'])."' WHERE id='".((int)$_POST['id'])."';";

		echo $sql;
		$result=pg_query($cnx, $sql);
		if(!$result){
			echo "Query: Un error a ocurrido.\n";
			exit;
		}
		pg_close($cnx);
	}

?>