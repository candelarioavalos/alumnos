
	<?php
	session_start();
	session_unset();
	//Matamos la sesion
	session_destroy();
	//echo "Sesion cerrada";
	header('Location: index.html');
	exit(); 
	?>
	
	