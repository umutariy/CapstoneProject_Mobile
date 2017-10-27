<?php 
include_once("assignments.php");
include_once("questions.php");
include_once("email.php");
include_once("users.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** assignment search service*/
//storing (get/post) request to a variable

//$requestNewQuestion = $_REQUEST['newquestion'];
//$requestOldQuestion = $_REQUEST['oldquestion'];
$data = array();
$qArray = array();
$dataUpdated = array();
$level = $_REQUEST['cmd'];

$assignments = new assignments(); //object of assignments class
$questions = new questions();
$email = new emailclass();
$user = new users();

if (!empty($level)) {
	switch ($level) {
		case '1':
			$grade = $_REQUEST['clss'];
			$schid = $_REQUEST['schid'];
			$stid = $_REQUEST['stid'];

		    $assignmentslist = $assignments->getcountofassignmentlist($schid,$grade,$stid);    //query without search condition
			while($row = $assignments->fetch()){
				$data['num'] = $row['count(t.tname)'];
			}
			$json_data = $data;
			echo json_encode($json_data); //send data as json format
			break;
		
		case '2':
			$grade = $_REQUEST['class'];
			$schid = $_REQUEST['schid'];
			$stid = $_REQUEST['stid'];

		    $assignmentslist = $assignments->getassignmentlist($schid,$grade,$stid);    //query without search condition
			while($row = $assignments->fetch()){
				$data = array('tname' => $row['tname'],'description' => $row['description'],'aid' => $row['aid'], 'questionnos' => unserialize($row['questionnos']));
				$dataUpdated[] = $data;
			}
			$json_data = $dataUpdated;
			echo json_encode($json_data); //send data as json format

			break;

		case '3':
			$requestAssignments = $_REQUEST['assignmentnum'];
			$assignmentslist = $assignments->getassignmentquestions($requestAssignments);    //query without search condition
			while($row = $assignments->fetch()){
				$data = array('tname' => $row['tname'],'description' => $row['description'],'tid' => $row['teacherid'],'atype' => $row['atype'], 'questionnos' => unserialize($row['questionnos']));
			}
			$json_data = $data;
			echo json_encode($json_data); //send data as json format

			break;

		case '4':
			$grade = $_REQUEST['class'];
			$schid = $_REQUEST['schid'];
			$stid = $_REQUEST['stid'];

		    $assignmentslist = $assignments->getcompletelist($schid,$grade,$stid);    //query without search condition
			while($row = $assignments->fetch()){
				$data = array('tname' => $row['tname'],'description' => $row['description'],'aid' => $row['aid'],'percentage' => $row['percentage'],'lettergrade' => $row['lettergrade'],'questionnos' => unserialize($row['questionnos']));
				$dataUpdated[] = $data;
			}
			$json_data = $dataUpdated;
			echo json_encode($json_data); //send data as json format

			break;

		case '5':
			$title = "";
			$noq = $_REQUEST['noq'];
			$topic_area = $_REQUEST['topic'];
			$grade = $_REQUEST['class'];
			$qs = $_REQUEST['questions'];
			$as = $_REQUEST['answers'];
			$tid = $_REQUEST['tid'];
			$schid = $_REQUEST['schid'];
			$atype = $_REQUEST['atype'];
		    $description = $_REQUEST['desc'];
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
		    $assignmentslist = $assignments->addassignment($title,$topic_area,$grade,$description,$serializedQuestions,$tid,$schid,$date,$atype);

		    $teachername = $user -> getusers($tid);
		    while ($row = $user -> fetch()) {
		    	$teacher = $row['FNAME']." ".$row['LNAME'];
		    }

		    $studentemails = $user -> getstudentsemailsinclass($grade,$schid);
		    while ($row = $user -> fetch()) {
		    	$send = $email-> sendinfo($teacher,$row['email']);
		    }

		    echo "success";

			break;

		case '6':
			$title = "";
			$noq = $_REQUEST['noq'];
			$topic_area = $_REQUEST['topic'];
			$grade = $_REQUEST['class'];
			$qs = $_REQUEST['questions'];
			$tid = $_REQUEST['tid'];
			$schid = $_REQUEST['schid'];
			$atype = $_REQUEST['atype'];
		    $description = $_REQUEST['desc'];
		    date_default_timezone_set("Europe/London");
		    $date = date("Y-m-d h:i:s");

		    $questionss = json_decode($qs, true);
		    $serializedQuestions = serialize($questionss);

		    $assignmentslist = $assignments->addassignment($title,$topic_area,$grade,$description,$serializedQuestions,$tid,$schid,$date,$atype);

		    $teachername = $user -> getusers($tid);
		    while ($row = $user -> fetch()) {
		    	$teacher = $row['FNAME']." ".$row['LNAME'];
		    }

		    $studentemails = $user -> getstudentsemailsinclass($grade,$schid);
		    while ($row = $user -> fetch()) {
		    	$send = $email-> sendinfo($teacher,$row['email']);
		    }

		    echo "success";

			break;	

		case '7':
			$grade = $_REQUEST['class'];
			$schid = $_REQUEST['schid'];
			$stid = $_REQUEST['stid'];

		    $assignmentslist = $assignments->getreviewassignmentlist($schid,$grade,$stid);    //query without search condition
			while($row = $assignments->fetch()){
				$data = array('tname' => $row['tname'],'description' => $row['description'],'aid' => $row['aid'], 'questionnos' => unserialize($row['questionnos']));
				$dataUpdated[] = $data;
			}
			$json_data = $dataUpdated;
			echo json_encode($json_data); //send data as json format

			break;

		case '8':
			$grade = $_REQUEST['clss'];
			$schid = $_REQUEST['schid'];
			$stid = $_REQUEST['stid'];

		    $assignmentslist = $assignments->getcountofreviewassignmentlist($schid,$grade,$stid);    //query without search condition
			while($row = $assignments->fetch()){
				$data['num'] = $row['count(t.tname)'];
			}
			$json_data = $data;
			echo json_encode($json_data); //send data as json format
			break;

		case '9':
			$stid = $_REQUEST['stid'];
		    $assignmentslist = $assignments->getreviewassignmentbyid($stid);    //query without search condition
			while($row = $assignments->fetch()){
				$data[] = array('tname' => $row['tname'],'description' => $row['description'],'aid' => $row['aid'],'sname' => $row['FNAME']." ".$row["LNAME"], 'stid' => $stid);
			}
			$json_data = $data;
			echo json_encode($json_data); //send data as json format
			break;

		case '10':
			$stid = $_REQUEST['stid'];
		    $assignmentslist = $assignments->getreviewassignmentbyid($stid);    //query without search condition
			while($row = $assignments->fetch()){
				$data['name'] = $row['FNAME']." ".$row["LNAME"];
				$data['info'] = array($row['tname'],$row['description'],$row['aid'],$stid);
				$dataUpdated[] = $data;
			}
			$json_data = $dataUpdated;
			echo json_encode($json_data); //send data as json format
			break;

		case '11':
			$stid = $_REQUEST['stid'];

			$arraylist = explode(",",$stid);
			$sum=0;
			for ($i=0; $i < count($arraylist); $i++) { 
				$assignmentslist = $assignments->getcountreviewedlist($arraylist[$i]);
				while ($row = $assignments -> fetch()) {
					$sum += $row['count(aid)'];
				}
			}
			$data['num'] = $sum;

			$json_data = $data;
			echo json_encode($json_data); //send data as json format*/
			break;

		case '12':
			$stid = $_REQUEST['stid'];

			$arraylist = explode(",",$stid);
			$sum=0;
			for ($i=0; $i < count($arraylist); $i++) { 
				$assignmentslist = $assignments->getcounttobereviewedlist($arraylist[$i]);
				while ($row = $assignments -> fetch()) {
					$sum += $row['count(aid)'];
				}
			}
			$data['num'] = $sum;

			$json_data = $data;
			echo json_encode($json_data); //send data as json format*/
			break;

		case '13':
			$clssid = $_REQUEST['clssid'];
			$assignmentslist = $assignments->getreviewassignmentsbyclass($clssid);
			while ($listrow = $assignments->fetch()) {
			 $students[] = $listrow['stid'];
			}
			for ($i=0; $i < count($students); $i++) { 
				$assignmentslist = $assignments->getreviewassignmentbyid($students[$i]);    //query without search condition
				while($row = $assignments->fetch()){
					$data['name'] = $row['FNAME']." ".$row["LNAME"];
					$data['info'] = array($row['tname'],$row['description'],$row['aid'],$students[$i]);
					$dataUpdated[] = $data;
				}
			}
			$json_data = $dataUpdated;
			echo json_encode($json_data); //send data as json format
			break;
		

		default:
			echo "error";
			break;
	}
}else{
	$data["status"] = "empty";

	echo json_encode($data);
}
?>