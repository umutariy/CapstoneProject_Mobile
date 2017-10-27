<?php 
include_once("topic.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** topic search service*/
//$requestData = $_REQUEST['custname'];  //storing (get/post) request to a variable
$data = array();

$topic = new topic(); //object of topic topic
if (!empty($requestData)) {  
	$topicslist = $topic->gettopic($requestData);   //query with search condition
}else{
	$topicslist = $topic->gettopics();    //query without search condition
}
while($row = $topic->fetch()){
	$data[] = $row;
}
$json_data = $data;

echo json_encode($json_data); //send data as json format
?>