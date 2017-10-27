<?php 
include_once("questions.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** question search service*/
$requestNumber = $_REQUEST['number'];  //storing (get/post) request to a variable

$data = array();
$newdata = array();

$questions = new questions(); //object of questions class
if (!empty($requestNumber)) {
	$numbers = json_decode($requestNumber);

	for ($i=0; $i < count($numbers); $i++) { 
		$questionslist = $questions->getquestionstoanswer($numbers[$i]);  //query with search condition

		while($row = $questions->fetch()){
			$data['qcontent'] = $row['qcontent'];
			$data['qid'] = $row['qid'];
			$data['answer'] = $row['answer'];
			$newdata[] = $data;
		}
	}
	
	$json_data = $newdata;

	echo json_encode($json_data); //send data as json format
}
?>