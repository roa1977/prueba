<?php

function error ($nro, $text)
{
	$ddf = fopen ('./logs/error.log','a');
	fwrite ($ddf, "[".date("r")."]Error $nro:$text"."\n");
	fclose($ddf);
}

function HTMLDateToMysqlDate($fecha)
{
    $array_fecha = preg_split("/-/", $fecha); 
    $fecha_convertida = "$array_fecha[2]-$array_fecha[1]-$array_fecha[0]";
    return $fecha_convertida;    
}

function campo_nulo($data)
{
	if($data != ''){
		return "'$data'";
	} else {
		return "NULL";
	}
}

?>