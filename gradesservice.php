<?php 
include_once("grades.php");
header('Access-Control-Allow-Origin: *');
/** written by Brian Martey*/
/** graph search service*/
$chart = $_REQUEST['chart'];  //storing (get/post) request to a variable
$requestStid = $_REQUEST['stid'];
$data = array();
$moredata = array();
$gradecounts = array();
$datearray = array();
$percentage = array();
$gradearray =["A","B","C","D","E","F"];

$grades = new grades(); //object of grades class
if (!empty($chart)) {
	switch ($chart) {
		case 'pie':
			for ($i=0; $i < count($gradearray); $i++) { 
				$gradeslist = $grades->getgrades($requestStid,$gradearray[$i]);

				while($row = $grades->fetch()){
					$gradecounts[] = $row['COUNT(lettergrade)'];
				}
			}

			for ($j=0; $j < count($gradearray); $j++) { 
				$data['name'] = $gradearray[$j];
				$data['y'] = $gradecounts[$j];
				$moredata[] = $data;
			}
				
			$json_data = $moredata;

			echo json_encode($json_data); //send data as json format
			break;
		
		case 'bar':
			for ($i=0; $i < count($gradearray); $i++) { 
				$gradeslist = $grades->getgrades($requestStid,$gradearray[$i]);

				while($row = $grades->fetch()){
					$gradecounts[] = $row['COUNT(lettergrade)'];
				}
			}

			for ($j=0; $j < count($gradearray); $j++) { 
				$data['name'] = $gradearray[$j];
				$data['y'] = $gradecounts[$j];
				$moredata[] = $data;
			}
				
			$json_data = $moredata;

			echo json_encode($json_data); //send data as json format
			break;

		case 'series':
			$gradeslist = $grades->getseriesgrades($requestStid);

			while($row = $grades->fetch()){
				$datearray["x"] = strtotime($row["date_submitted"])."000";
				$datearray["y"] = $row["percentage"]; 
				$moredata[] = $datearray;
			}

			$json_data = $moredata;

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