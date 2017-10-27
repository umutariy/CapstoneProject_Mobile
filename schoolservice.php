<?php 
include_once("school.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** school search service*/

$data = array();
$action = $_REQUEST['cmd'];

$school = new school(); //object of school school

if (!empty($action)) {
	switch ($action) {
		case '1':
			$schoolslist = $school->getschools();    //query without search condition
			while($row = $school->fetch()){
				$data[] = $row;
			}
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '2':
			$requestData = $_REQUEST['schname']; 
			$schoolslist = $school->getschool($requestData);   //query with search condition
			while($row = $school->fetch()){
				$data[] = $row;
			}
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '3':
			$requestData = $_REQUEST['schname']; 
			$schoolslist = $school->addschool($requestData);   //query with search condition
			break;

		case '4': 
			$schoolslist = $school->getschoolno();   //query with search condition
			while($row = $school->fetch()){
				$data['number'] = $row['count(SCHOOL_NAME)'];
			}
			$json_data = $data;

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