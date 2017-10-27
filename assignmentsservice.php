<?php 
include_once("assignments.php");
include_once("questions.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** assignment search service*/
//storing (get/post) request to a variable
$value1 = isset($_REQUEST['newquestion']) ? $_REQUEST['newquestion'] : '';

$requestNewQuestion = $_REQUEST['newquestion'];
$requestOldQuestion = $_REQUEST['oldquestion'];
$data = array();
$qArray = array();

$assignments = new assignments(); //object of assignments class
$questions = new questions(); //object of questions class

if (!empty($requestNewQuestion)) {  //creating and sending newly created questions as assignments
	$title = "";
	$noq = $_REQUEST['noq'];
	$topic_area = $_REQUEST['topic'];
	$grade = $_REQUEST['class'];
	$qs = $_REQUEST['questions'];
	$as = $_REQUEST['answers'];
	$tid = $_REQUEST['tid'];
	$schid = $_REQUEST['schid'];
    $description = $requestNewQuestion;
    date_default_timezone_set("Europe/London");
    $date = date("Y-m-d h:i:s");

    $questionss = json_decode($qs, true);
    $answerss = json_decode($as, true);

    for ($i=0; $i < $noq; $i++) { 
    	$questionslist = $questions->addquestion($questionss[$i], $answerss[$i], $topic_area, $date);
    }

    sleep(1);

    $getquestionslist = $questions->getquestionlist($questionss[$i], $answerss[$i], $topic_area, $date);
    while($row = $questions->fetch()){
		$data[] = $row["qid"];
	}

    $serializedQuestions = serialize($data);
    $assignmentslist = $assignments->addassignment($title,$topic_area,$grade,$description,$serializedQuestions,$tid,$schid,$date);
    echo "success";

}else if(!empty($requestOldQuestion)){//sending questions as assignments
	$title = "";
	$noq = $_REQUEST['noq'];
	$topic_area = $_REQUEST['topic'];
	$grade = $_REQUEST['class'];
	$qs = $_REQUEST['questions'];
	$tid = $_REQUEST['tid'];
	$schid = $_REQUEST['schid'];
    $description = $requestOldQuestion;
    date_default_timezone_set("Europe/London");
    $date = date("Y-m-d h:i:s");

    $questionss = json_decode($qs, true);
    $serializedQuestions = serialize($questionss);

    $assignmentslist = $assignments->addassignment($title,$topic_area,$grade,$description,$serializedQuestions,$tid,$schid,$date);
    echo "success";

}else{
	$assignmentslist = $assignments->getassignments();    //query without search condition
	while($row = $assignments->fetch()){
		$data[] = $row;
	}
	$json_data = $data;

	echo json_encode($json_data); //send data as json format
}
?>