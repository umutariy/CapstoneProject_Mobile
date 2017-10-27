<?php 
include_once("class.php");
include_once("users.php");
include_once("assignments.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** class search service*/
//$requestData = $_REQUEST['custname'];  //storing (get/post) request to a variable
$data = array();
$action = $_REQUEST['cmd'];

$class = new classes(); //object of class class
$users = new users();
$assignments = new assignments();

if (!empty($action)) {
	switch ($action) {
		case '1':
			$classlist = $class->getclasses();     //query without search condition
			while($row = $class->fetch()){
				$data[] = $row;
			}
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '2':
			$requestData = $_REQUEST['clssname']; 
			$classlist = $class->getclass($requestData);   //query with search condition
			while($row = $class->fetch()){
				$data[] = $row;
			}
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '3':
			$requestData = $_REQUEST['clssname']; 
			$classes = $class->getclassno();
			$row = $class->fetch();
			$requestNo = $row['count(cno)'] + 3;
			$classlist = $class->addclass($requestNo,$requestData);   //query with search condition
			break;

		case '4': 
			$id = $_REQUEST['id'];
			$schid = $_REQUEST['schid'];
			$students = $class->getteachersclass($id); 
			$row = $class->fetch();
			$grades = $row['grade'];
			$gradesarray = explode(",",$grades);

			$sum = 0;

			for ($i=0; $i < count($gradesarray); $i++) { 
				$gradeslist = $users->getstudentsinclass($gradesarray[$i],$schid,$id);  //query with search condition

				while($rows = $users->fetch()){
					$count = count(unserialize($rows['stid']));
					$sum += $count;
				}
			}

			$data['sum'] = $sum;
			
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '5': 
			$id = $_REQUEST['id'];
			$students = $class->getteachersclass($id); 
			$row = $class->fetch();
			$grades = $row['grade'];
			$gradesarray = explode(",",$grades);

			$sum = 0;

			for ($i=0; $i < count($gradesarray); $i++) { 	
				$sum = $sum +1;
			}
			$data['sum'] = $sum;
			
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '6': 
			$id = $_REQUEST['id'];
			$schoolid = $_REQUEST['schid'];
			$students = $class->getteachersclass($id); 
			$row = $class->fetch();
			$grades = $row['grade'];
			$gradesarray = explode(",",$grades);

			for ($i=0; $i < count($gradesarray); $i++) { 	
				$classname= $class->getclassname($gradesarray[$i]);
				$row = $class->fetch();
				$data['cno'] = $gradesarray[$i];
				$data['name'] = $row['cname'];
				$classnum= $class->getclassesno($gradesarray[$i],$schoolid);
				$row = $class->fetch();
				$data['num'] = $row['count(grade)'];
				$moredata[] = $data;
			}
			$json_data = $moredata;

			echo json_encode($json_data); //send data as json format
			break;

		case '7': 
			$id = $_REQUEST['id'];
			$schoolid = $_REQUEST['schid'];
			$students = $class->getteachersclass($id); 
			$row = $class->fetch();
			$grades = $row['grade'];
			$gradesarray = explode(",",$grades);

			for ($i=0; $i < count($gradesarray); $i++) { 
				$data['cno'] = $gradesarray[$i];	
				$classname= $class->getclassname($gradesarray[$i]);
				$row = $class->fetch();
				$data['name'] = $row['cname'];
				$classassignments = $assignments->getreviewassignmentnobyclass($gradesarray[$i]);
				$row = $assignments->fetch();
				$data['num'] = $row['count(r.aid)'];
				$moredata[] = $data;
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