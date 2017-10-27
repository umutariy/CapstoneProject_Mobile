<?php 
include_once("questions.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** question search service*/
$x = 4;
$y = 15; 

$percent = $x/$y;
$percent_friendly = number_format( $percent * 100, 2 ) . '%'; 

//echo $percent;
echo $percent_friendly;

?>