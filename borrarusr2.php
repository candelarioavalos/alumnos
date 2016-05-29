
<?php
include_once('./conexion.php');
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());
	//isset---->determina si una variable ha sido declarada y su valor no es NULO. 
	if(isset($_POST['usuario'])){
		echo "<pre>";
		//muestra información sobre una variable en una forma que es legible por humanos. 
		print_r($_POST);
		//muestra una linea
		echo "<hr>";
		//var_dump — Muestra información sobre una variable
		var_dump($_POST);
		//declaracion de variables
		$sql2="DELETE FROM usuario WHERE usuario='". $_POST['usuario'] ."';";
		//muestra la variable $sql2
		echo $sql2;
		//estblece conexion con la base de datos y envia la sentencia de eliminar
		$result2 = pg_query($cnx,$sql2);
	}
	//cierra conexion con la base de datos
	pg_close($cnx); 
?>