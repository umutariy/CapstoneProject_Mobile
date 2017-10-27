<?php 
include_once("answers.php");
include_once("questions.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** question search service*/
$requestNumber = $_REQUEST['number'];  //storing (get/post) request to a variable

$data = array();
$newdata = array();

$answers = new answers(); //object of answers class
$questions = new questions();
if (!empty($requestNumber)) {
	$numbers = json_decode($requestNumber);
	$requestAssid = $_REQUEST['assid'];
	$requestStid = $_REQUEST['stid'];

	for ($i=0; $i < count($numbers); $i++) { 
		$answerslist = $answers->getanswers($requestAssid, $requestStid, $numbers[$i]);  //query with search condition

		while($row1 = $answers->fetch()){
			$data["solution"] = $row1["solution"];
		}

		$questionslist = $questions->getquestionstoanswer($numbers[$i]);

		

		while($row2 = $questions->fetch()){
			$data['qcontent'] = $row2['qcontent'];
			$data['qid'] = $row2['qid'];
			$data['answer'] = $row2['answer'];
			$newdata[] = $data;
		}

	}
	$json_data = $newdata;

	echo json_encode($json_data); //send data as json format
}
?>