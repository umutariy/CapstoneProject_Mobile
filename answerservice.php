<?php 
include_once("answers.php");
include_once("assignments.php");
include_once("email.php");
include_once("users.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/**class answer service*/
$level = $_REQUEST['cmd'];  //storing (get/post) request to a variable
$data = array();
$marks = array();
$totalmarks = "";
$lettergrade ="";


$answer = new answers(); //object of answer class
$assignments = new assignments();
$email = new emailclass();
$user = new users();

if (!empty($level)) {
	switch ($level) {
		case '1': //not used
			$requestSolution = $_REQUEST['solution'];
			$requestCorrectAns = $_REQUEST['correctans'];
			$requestQuid = $_REQUEST['quid'];
			$requestStid = $_REQUEST['stid'];
			$requestAssid = $_REQUEST['assid'];
			$tid = $_REQUEST['tid'];

			$solution = json_decode($requestSolution);
			$correctans = json_decode($requestCorrectAns);
			$quid = json_decode($requestQuid);

			for ($i=0; $i < count($correctans); $i++) { 
				$strlength = strlen($correctans[$i]);
				$compare = strncasecmp($solution[$i],$correctans[$i],$strlength);

				if ($compare == 0) {
					$mark = 1;
				}else{
					$mark = 0;
				}

				$marks[] = $mark;

				$answers = $answer->submitanswer($requestAssid,$solution[$i],$correctans[$i],$quid[$i],$requestStid, $mark);
			}

			for ($j=0; $j < count($marks); $j++) { 
				$totalmarks += $marks[$j];
			}

			$percent = $totalmarks / count($marks);
			$percentage = number_format( $percent * 100, 2 );

			if ($percentage >= 80) {
				$lettergrade = "A";
			}elseif ($percentage >= 70){
				$lettergrade = "B";
			}elseif ($percentage >= 65){
				$lettergrade = "C";
			}elseif ($percentage >= 60) {
				$lettergrade = "D";
			}elseif ($percentage >= 50){
				$lettergrade = "E";
			}elseif ($percentage < 50) {
				$lettergrade = "F";
			}else{
				$lettergrade = "Null";
			}

			date_default_timezone_set("Europe/London");
		    $datesubmitted = date("Y-m-d h:i:s");

			$complete = $answer->completestatus($requestAssid,$requestStid,$totalmarks,$percentage, $lettergrade, $datesubmitted, $tid);   
			break;

		case '2':
			$requestSolution = $_REQUEST['solution'];
			$requestCorrectAns = $_REQUEST['correctans'];
			$requestQuid = $_REQUEST['quid'];
			$requestStid = $_REQUEST['stid'];
			$requestAssid = $_REQUEST['assid'];
			$tid = $_REQUEST['tid'];
			$pid = $_REQUEST['pid'];

			$solution = json_decode($requestSolution);
			$correctans = json_decode($requestCorrectAns);
			$quid = json_decode($requestQuid);

			for ($i=0; $i < count($correctans); $i++) { 
				$strlength = strlen($correctans[$i]);
				$compare = strncasecmp($solution[$i],$correctans[$i],$strlength);

				if ($compare == 0) {
					$mark = 1;
				}else{
					$mark = 0;
				}
				echo $requestAssid." ".$solution[$i]." ".$correctans[$i]." ".$quid[$i]." ".$requestStid." ".$tid." ".$mark."<br>";

				$marks[] = $mark;

				$answers = $answer->submitanswer($requestAssid,$solution[$i],$correctans[$i],$quid[$i],$requestStid, $mark);
			}

			date_default_timezone_set("Europe/London");
		    $datesubmitted = date("Y-m-d h:i:s");

			$complete = $answer->reviewstatus($requestAssid,$requestStid,$datesubmitted,$tid,$pid);

			$studentname = $user -> getusers($requestStid);
		    while ($row = $user -> fetch()) {
		    	$student = $row['FNAME']." ".$row['LNAME'];
		    }

		    $arraylist = explode(",",$pid);
			for ($i=0; $i < count($arraylist); $i++) { 
				$students = $user->getemails($arraylist[$i]);
				while ($row = $user->fetch()) {
		    		$send = $email-> resendinfo($student,$row['email']);
 				}
			}

			break;

		case '3':
			$requestSolution = $_REQUEST['solution'];
			$requestCorrectAns = $_REQUEST['correctans'];
			$requestQuid = $_REQUEST['quid'];
			$requestStid = $_REQUEST['stid'];
			$requestAssid = $_REQUEST['assid'];
			$tid = $_REQUEST['tid'];
			$pid = $_REQUEST['pid'];

			$solution = json_decode($requestSolution);
			$correctans = json_decode($requestCorrectAns);
			$quid = json_decode($requestQuid);

			for ($i=0; $i < count($correctans); $i++) { 
				$strlength = strlen($correctans[$i]);
				$compare = strncasecmp($solution[$i],$correctans[$i],$strlength);

				if ($compare == 0) {
					$mark = 1;
				}else{
					$mark = 0;
				}

				$marks[] = $mark;

				$answers = $answer->updateanswer($requestAssid,$solution[$i],$correctans[$i],$quid[$i],$requestStid, $mark);
			}

			date_default_timezone_set("Europe/London");
		    $datesubmitted = date("Y-m-d h:i:s");
		    $date = date("Y-m-d");

			$complete = $answer->updatereviewstatus($requestAssid,$requestStid,$datesubmitted,$tid,$pid);

			$studentname = $user -> getusers($requestStid);
		    while ($row = $user -> fetch()) {
		    	$student = $row['FNAME']." ".$row['LNAME'];
		    }

		    $assignmentstitle = $assignments->getassignmentquestions($requestAssid);
		    while ($row = $assignments -> fetch()) {
		    	$title = $row['tname'];
		    }

		    $arraylist = explode(",",$pid);
			for ($i=0; $i < count($arraylist); $i++) { 
				$students = $user->getemails($arraylist[$i]);
				while ($row = $user->fetch()) {
					echo $row['email'];
		    		$send = $email-> updateinfo($student,$title,$date,$row['email']);
 				}
			}
			break;

		case '4': //used by parent to approve assignments
			$stid = $_REQUEST['stid'];
			$aid = $_REQUEST['assid'];
			$tid = $_REQUEST['tid'];
		    $assignmentslist = $assignments->approveassignment($stid,$aid);    //query without search condition
		    $assignmentstype = $assignments->getassignmenttype($aid);
		    while ($row = $assignments->fetch()) {
		    	$request = "Approved";
		    	$type = $row['atype'];
		    	if ($type == 1) {
		    		$answers = $answer->getanswersinfo($aid,$stid);
		    		while ($row = $answer->fetch()) {
		    			$marks[] = $row['mark'];
		    		}
		    		for ($j=0; $j < count($marks); $j++) { 
						$totalmarks += $marks[$j];
					}

					$percent = $totalmarks / count($marks);
					$percentage = number_format( $percent * 100, 2 );

					if ($percentage >= 80) {
						$lettergrade = "A";
					}elseif ($percentage >= 70){
						$lettergrade = "B";
					}elseif ($percentage >= 65){
						$lettergrade = "C";
					}elseif ($percentage >= 60) {
						$lettergrade = "D";
					}elseif ($percentage >= 50){
						$lettergrade = "E";
					}elseif ($percentage < 50) {
						$lettergrade = "F";
					}else{
						$lettergrade = "Null";
					}

					date_default_timezone_set("Europe/London");
				    $datesubmitted = date("Y-m-d h:i:s");
				    $date = date("Y-m-d");

					$complete = $answer->completestatus($aid,$stid,$totalmarks,$percentage, $lettergrade, $datesubmitted, $date, $tid); 

		    	}elseif ($type == 2) {
		    		$data = "Approved and waiting for marking";
		    		$json_data = $data;
					echo json_encode($json_data);
		    	}

		    	date_default_timezone_set("Europe/London");
			    $datesubmitted = date("Y-m-d h:i:s");
			    $date = date("Y-m-d");

		    	$studentname = $user -> getusers($stid);
			    while ($row = $user -> fetch()) {
			    	$student = $row['FNAME']." ".$row['LNAME'];
			    }

			    $assignmentstitle = $assignments->getassignmentquestions($aid);
			    while ($row = $assignments -> fetch()) {
			    	$title = $row['tname'];
			    }

				$students = $user->getemails($stid);
				while ($row = $user->fetch()) {				
		    		$send = $email-> recieveinfo($request,$title,$date,$row['email']);
 				}
		    }
			break;

		case '5': //used by parent to approve assignments
			$stid = $_REQUEST['stid'];
			$aid = $_REQUEST['assid'];
	    	$request = "Not Approved";

	    	date_default_timezone_set("Europe/London");
		    $datesubmitted = date("Y-m-d h:i:s");
		    $date = date("Y-m-d");

	    	$studentname = $user -> getusers($stid);
		    while ($row = $user -> fetch()) {
		    	$student = $row['FNAME']." ".$row['LNAME'];
		    }

		    $assignmentstitle = $assignments->getassignmentquestions($aid);
		    while ($row = $assignments -> fetch()) {
		    	$title = $row['tname'];
		    }

			$students = $user->getemails($stid);
			while ($row = $user->fetch()) {			
	    		$send = $email-> recieveinfo($request,$title,$date,$row['email']);
			}
			echo $request;
			echo $title;
			echo $date;
			break;

		case '6': //teachers mark assignment
			$requestQuid = $_REQUEST['quid'];
			$requestStid = $_REQUEST['stid'];
			$requestAssid = $_REQUEST['assid'];
			$tid = $_REQUEST['tid'];
			$marks = $_REQUEST['marks'];

			$quid = json_decode($requestQuid);
			$marklist = json_decode($marks);

			for ($i=0; $i < count($marklist); $i++) { 
				//echo $marklist[$i];
				$marksarray[] = $marklist[$i];
				$answers = $answer->updatemark($requestAssid,$quid[$i],$requestStid, $marklist[$i]);
			}

			for ($j=0; $j < count($marklist); $j++) { 
				$totalmarks += $marksarray[$j];
			}
			//echo $totalmarks;

			$percent = $totalmarks / count($marksarray);
			$percentage = number_format( $percent * 100, 2 );

			//echo $percentage;

			if ($percentage >= 80) {
				$lettergrade = "A";
			}elseif ($percentage >= 70){
				$lettergrade = "B";
			}elseif ($percentage >= 65){
				$lettergrade = "C";
			}elseif ($percentage >= 60) {
				$lettergrade = "D";
			}elseif ($percentage >= 50){
				$lettergrade = "E";
			}elseif ($percentage < 50) {
				$lettergrade = "F";
			}else{
				$lettergrade = "Null";
			}

			date_default_timezone_set("Europe/London");
		    $datesubmitted = date("Y-m-d h:i:s");
		    $date = date("Y-m-d");

			$complete = $answer->completestatus($requestAssid,$requestStid,$totalmarks,$percentage, $lettergrade, $datesubmitted,$date, $tid);   
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