<?php 
    session_start();
   
	include_once'./conexion.php';
	$cnx=pg_connect($strConexion) or die("ERROR DE CONEXION".pg_last_error());
	
	if (isset($_POST)) {
		
		$nombre = $_POST['name'];
		$psw = $_POST['contra'];
		//trim=elimina espacios en blanco de la cadena
		if(trim($nombre) != "" && trim($psw) != ""){

			$sql = "select * from usuario where usuario='".$nombre."' and contrasena='".$psw."';";
			$result = pg_query($cnx, $sql);
			if(pg_affected_rows($result)){
				$row = pg_fetch_array($result);
				header('Location: insertar.php');
				$_SESSION["nombre_usuario"] = $row['usuario'];
				$_SESSION['privilegios'] = $row['privilegio'];				
			}else{  
				echo 'datos incorrectos';
				//header('Location: login.html');	
			}
		}else{
			echo 'insertar nombre y/o contraseña';
		} 
	}
?>
