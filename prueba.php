<?php

include("dbconfig.php");

$opcion = $_REQUEST["q"]; // opcion de consulta o accion realizada


// depurar,,, este parametro alguien lo esta enviando, detectar quien y elminar el codigo de llamada y esta variable
//$tablita = $_GET["t"]; //nombre de la tabla 

// depurar,,, este parametro alguien lo esta enviando, detectar quien y elminar el codigo de llamada y esta variable
$page  = $_REQUEST['page']; // get the requested page
$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
$sidx  = $_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord  = $_REQUEST['sord']; // get the direction

/*
// analizar.... aparentemente tiene que ver con el paginado... pero no me queda claro si funcionaba o no
$page  = 1;
$limit = 1;
$sidx  = 1;
$sord  = 1;
*/

if(!$sidx) $sidx =1;

$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
if($totalrows) {$limit = $totalrows;}

// busqueda
// IMPORTANTE!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// Refactorizar este switch, no es optimo
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$wh = "";
$searchOn = Strip($_REQUEST['_search']);
if($searchOn=='true') {
	$fld = Strip($_REQUEST['searchField']);
	if( $fld=='id' || $fld =='invdate' || $fld=='name' || $fld=='amount' || $fld=='tax' || $fld=='total' || $fld=='note' ) {
		$fldata = Strip($_REQUEST['searchString']);
		$foper = Strip($_REQUEST['searchOper']);
		// costruct where
		$wh .= " AND ".$fld;
		switch ($foper) {
			case "bw":
				$fldata .= "%";
				$wh .= " LIKE '".$fldata."'";
				break;
			case "eq":
				if(is_numeric($fldata)) {
					$wh .= " = ".$fldata;
				} else {
					$wh .= " = '".$fldata."'";
				}
				break;
			case "ne":
				if(is_numeric($fldata)) {
					$wh .= " <> ".$fldata;
				} else {
					$wh .= " <> '".$fldata."'";
				}
				break;
			case "lt":
				if(is_numeric($fldata)) {
					$wh .= " < ".$fldata;
				} else {
					$wh .= " < '".$fldata."'";
				}
				break;
			case "le":
				if(is_numeric($fldata)) {
					$wh .= " <= ".$fldata;
				} else {
					$wh .= " <= '".$fldata."'";
				}
				break;
			case "gt":
				if(is_numeric($fldata)) {
					$wh .= " > ".$fldata;
				} else {
					$wh .= " > '".$fldata."'";
				}
				break;
			case "ge":
				if(is_numeric($fldata)) {
					$wh .= " >= ".$fldata;
				} else {
					$wh .= " >= '".$fldata."'";
				}
				break;
			case "ew":
				$wh .= " LIKE '%".$fldata."'";
				break;
			case "ew":
				$wh .= " LIKE '%".$fldata."%'";
				break;
			default :
				$wh = "";
		}
	}
}
//echo $fld." : ".$wh;
// connect to the database
$link = mysqli_connect($dbhost, $dbuser, $dbpassword,$database);

if (mysqli_connect_errno()) {
printf("Error de conexion". mysqli_connect_error());
   }
//mysql_select_db($database) or die("Error conecting to db.");

switch ($opcion) {

    case 'usuarios':

		//exit();
		$query=("SELECT COUNT(*) AS count FROM  ge_users a WHERE 1= 1 ".$wh); 
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$count = $row['count'];

		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
        if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
        if ($start<0) $start = 0;
        $query1 = "SELECT a.* 
		        FROM ge_users a 
				WHERE 1=1 ".$wh." 
				ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
				//print_r($query1);
		$result = mysqli_query($link, $query1)or die("Couldìot execute query.".mysqli_error($link));
		//print_r("usuarios".$responce->page);
		//$responce->page = $page;
        //$responce->total = $total_pages;
        //$responce->records = $count;
        $i=0;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$responce->rows[$i]['id']=$row['id'];
            $responce->rows[$i]['cell']=array(	$row['id'],
												$row['user'],
												$row['pass'],
												$row['nombre']												
											 );
            $i++;
		} 
		//echo $json->encode($responce); // coment if php 5
		mysqli_free_result($result);
		mysqli_close($link);
        echo json_encode($responce);
           
        break;

	

	mysqli_free_result($result);
	mysqli_close($link);		
}

function Strip($value)
{
	if(get_magic_quotes_gpc() != 0)
  	{
    	if(is_array($value))  
			if ( array_is_associative($value) )
			{
				foreach( $value as $k=>$v)
					$tmp_val[$k] = stripslashes($v);
				$value = $tmp_val; 
			}				
			else  
				for($j = 0; $j < sizeof($value); $j++)
        			$value[$j] = stripslashes($value[$j]);
		else
			$value = stripslashes($value);
	}
	return $value;
}

function array_is_associative ($array)
{
    if ( is_array($array) && ! empty($array) )
    {
        for ( $iterator = count($array) - 1; $iterator; $iterator-- )
        {
            if ( ! array_key_exists($iterator, $array) ) { return true; }
        }
        return ! array_key_exists(0, $array);
    }
    return false;
}
?>
