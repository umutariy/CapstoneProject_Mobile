<?php 
include_once("assignments.php");
include_once("questions.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** assignment search service*/
//storing (get/post) request to a variable
$requestAssignments = $_REQUEST['assignmentnum'];
$data = array();
$qArray = array();

$assignments = new assignments(); //object of assignments class
$questions = new questions(); //object of questions class

if(!empty($requestAssignments)){

    $assignmentslist = $assignments->getassignmentquestions($requestAssignments);    //query without search condition
	while($row = $assignments->fetch()){
		$data = array('tname' => $row['tname'],'description' => $row['description'], 'questionnos' => unserialize($row['questionnos']));
	}
	$json_data = $data;
	echo json_encode($json_data); //send data as json format

}else{
	$assignmentslist = $assignments->getassignments();    //query without search condition
	while($row = $assignments->fetch()){
		$data[] = $row;
	}
	$json_data = $data;

	echo json_encode($json_data); //send data as json format
}
?>