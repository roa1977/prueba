<?php

include("dbconfig.php");

$link = mysqli_connect($dbhost, $dbuser, $dbpassword,$database);
if (mysqli_connect_errno()) {
printf("Error de conexíon". mysqli_connect_error());
    exit();
}

$operacion = $_POST['oper'];

if ($operacion=='add') {
	$sql = 
	"
		insert into ge_users
		(
			id,
			user,
			pass,			
			nombre			
		)
		values 
		(
		NULL,
		'".$_POST['user']."',
		'".base64_encode (sha1($_POST['pass']))."',		
		'".$_POST['nombre']."'
		)
	";

} elseif ($operacion=='del') {
	$sql = 
	"
		DELETE FROM ge_users
		WHERE id = '".$_POST['id']."'
	"; // respetar el campo ID que viene desde el from

} elseif ($operacion=='edit') { 
	
	if ($_POST['pass'] != '') {
		$clave_cambiada = "pass='".base64_encode (sha1($_POST['pass']))."',";
	} else {
		$clave_cambiada = "";
	}	
	
	$sql = 
	"
		UPDATE ge_users
		SET 
		user='".$_POST['user']."',
		".$clave_cambiada."		
		nombre='".$_POST['nombre']."'	
		WHERE id = '".$_POST['id']."'
	"; // respetar el campo ID que viene desde el from
} 
//echo "sentencia SQL:";
//echo $sql;

if ($result = mysqli_query($link,$sql))
{
	echo "Operacion: ".$operacion. " ejecutada exitosamente.";
}else    
{
	echo "Operacion: ".$operacion. " ejecutada CON ERROR: ";
	echo mysqli_error($link);
}

mysqli_close($link);

?>