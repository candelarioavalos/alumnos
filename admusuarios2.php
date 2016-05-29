<?php
include_once('./conexion.php');
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());
	//isset---->determina si una variable ha sido declarada y su valor no es NULO. 
	if(isset($_POST['usuario'])){
		//pasar lineas a nuevo documento
		//utilizar ajax para hacer una petición asíncrona al servidor
		echo "<pre>";
		print_r($_POST); 
		echo "<hr>";
		var_dump($_POST);
		
		$sql = "UPDATE usuario SET privilegio='".($_POST['privilegio'])."' WHERE usuario='".($_POST['usuario'])."';";
		echo $sql;
		$result=pg_query($cnx, $sql);
		if(!$result){
			echo "Query: Un error a ocurrido.\n";
			exit;
		}
		pg_close($cnx);
	}
?>