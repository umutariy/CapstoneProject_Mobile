<?php 
include_once("class.php");
include_once("users.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** teachers service*/
//$requestData = $_REQUEST['custname'];  //storing (get/post) request to a variable
$data = array();
$action = $_REQUEST['cmd'];

$users = new users(); //object of class class
$class = new classes();
if (!empty($action)) {
	switch ($action) {
		case '1': 
			$id = $_REQUEST['id'];
			$schid = $_REQUEST['schid'];
			$students = $class->getteachersclass($id); 
			$row = $class->fetch();
			$grades = $row['grade'];
			$gradesarray = explode(",",$grades);

			for ($i=0; $i < count($gradesarray); $i++) { 
				$infolist = $users->getstudentsid($gradesarray[$i],$schid);  //query with search condition

				while($rows = $users->fetch()){
					$data[] = $rows['UID'];
				}
				$serializedInfo = serialize($data);
				$adding = $users->addstudentstoclass($gradesarray[$i],$schid,$id,$serializedInfo);
				$data = array();
			}

			break;

		case '2': 
			$id = $_REQUEST['id'];
			$schid = $_REQUEST['schid'];
			$students = $class->getteachersclass($id); 
			$row = $class->fetch();
			$grades = $row['grade'];
			$gradesarray = explode(",",$grades);
			$array = array();

			for ($i=0; $i < count($gradesarray); $i++) { 
				echo $gradesarray[$i]." ";
				$studlist = $users->getstudentsinclass($gradesarray[$i],$schid,$id);
				while ($rows = $users->fetch()) {
					$array = unserialize($rows['stid']);
				}

				$array[count($array)] = "6";
				$serializedInfo = serialize($array);
				$adding = $users->updatestudentsinclass($gradesarray[$i],$schid,$id,$serializedInfo);
			}

			break;

		case '3': 
			$json_data = array();
			$schid = $_REQUEST['schid'];
			$class = $_REQUEST['class'];

			$infolist = $users->getstudentsnames($class,$schid);  //query with search condition

			while($rows = $users->fetch()){
				$data['name'] = $rows['FNAME']." ".$rows['LNAME'];
				$json_data[] = $data;
			}

			echo json_encode($json_data);

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