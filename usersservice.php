<?php 
include_once("users.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/** user service*/

$data = array();
$moredata = array();
$level = $_REQUEST['cmd'];

$user = new users(); //object of user class

if (!empty($level)) {
	switch ($level) {
		case '1':
			$lvl = $_REQUEST['lvl'];
			$fname = $_REQUEST['fname'];
			$lname = $_REQUEST['lname'];
			$school = $_REQUEST['sch'];
			$adduser = $user->adminadduser($fname, $lname, $school, $lvl);
			break;

		case '2':
			$lvl = $_REQUEST['lvl'];
			$fname = $_REQUEST['fname'];
			$lname = $_REQUEST['lname'];
			$school = $_REQUEST['sch'];
			$clss = $_REQUEST['clss'];
			$adduser = $user->adminadduser($fname, $lname, $school, $lvl, $clss);
			break;

		case '3':
			$id = $_REQUEST['id'];
			$students = $user->getchildrenno($id);
			while($row = $user->fetch()){
				$children = $row['children'];
			}
			$childrenarray = explode(",",$children);
			$sum = 0;

			for ($i=0; $i < count($childrenarray); $i++) { 	
				$sum ++;
			}
			$data['num'] = $sum;
			$json_data = $data;
			echo json_encode($json_data); //send data as json format
			
			break;

		case '4':
			$grade = $_REQUEST['grade'];
			$schid = $_REQUEST['schid'];
			$users = $user->getstudentsinfo($grade,$schid);     //query without search condition
			while($row = $user->fetch()){
				$data['name'] = $row['FNAME']." ".$row['LNAME'];
				$data['id'] = $row['UID'];
				$moredata[] = $data;
			}
			$json_data = $moredata;

			echo json_encode($json_data); //send data as json format
			break;

		case '5': 
			$students = $user->getstudentsno(); 
			while($row = $user->fetch()){
				$data['num'] = $row['count(FNAME)'];
			}
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '6': 
			$students = $user->getteachersno(); 
			while($row = $user->fetch()){
				$data['num'] = $row['count(FNAME)'];
			}
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '7': 
			$id = $_REQUEST['id'];
			$students = $user->getteacherassignments($id); 
			while($row = $user->fetch()){
				$data['num'] = $row['count(description)'];
			}
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '8': 
			$schid = $_REQUEST['schid'];
			$clss = $_REQUEST['clss'];
			$students = $user->getstudentsnoinclass($clss,$schid); 
			while($row = $user->fetch()){
				$data['num'] = $row['count(FNAME)'] - 1;
			}
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '9': 
			$schid = $_REQUEST['schid'];
			$clss = $_REQUEST['clss'];
			$students = $user->getstudentsnoinclass($clss,$schid); 
			while($row = $user->fetch()){
				$data['num'] = $row['count(FNAME)'] - 1;
			}
			$json_data = $data;

			echo json_encode($json_data); //send data as json format
			break;

		case '10': 
			$id = $_REQUEST['id'];
			$children = $_REQUEST['chi'];
			$arraylist = array();
			$parentlist = array();
			$students = $user->getchildrenno($id);
			while($row = $user->fetch()){
				$list = $row['children'];
			}
			if($list == ""){
				$arraylist = [];
			}else{
				$arraylist = explode(",",$list);
			}
			$arraylist[count($arraylist)] = $children;
			$listagain = implode(",",$arraylist);
			$students = $user->addchildren($listagain,$id); 

			$parents = $user->getparentsno($children);
			while($row = $user->fetch()){
				$plist = $row['parents'];
			}
			if($plist == ""){
				$parentlist = [];
			}else{
				$parentlist = explode(",",$plist);
			}
			$parentlist[count($parentlist)] = $id;
			$parentlistagain = implode(",",$parentlist);
			$parents = $user->addparents($parentlistagain,$children);

			$json_data = $listagain;
			echo json_encode($json_data); //send data as json format
			break;

		case '11': 
			$id = $_REQUEST['id'];
			$arraylist = array();
			$students = $user->getchildrenno($id);
			while($row = $user->fetch()){
				$list = $row['children'];
			}
			$arraylist = explode(",",$list);
			for ($i=0; $i < count($arraylist); $i++) { 
				$students = $user->getchildreninfo($arraylist[$i]);
				while ($row = $user->fetch()) {
					$data['name'] = $row['fname']." ".$row['lname'];
					$data['class'] = $row['name'];
					$data['id'] = $row['uid'];
					$moredata[] = $data;
 				}
			}
			$json_data = $moredata;

			echo json_encode($json_data); //send data as json format
			break;

		case '12': 
			$id = $_REQUEST['id'];
			$idarray = json_decode($id,true);
			for ($i=0; $i < count($idarray); $i++) { 
				$students = $user->getchildreninfo($idarray[$i]); 
				while($row = $user->fetch()){
					$data[$i] = $row['fname']." ".$row['lname'];
				}
			}
			$json_data = $data;
			echo json_encode($json_data); //send data as json format
			break;

		case '13': 
			$id = $_REQUEST['id'];
			$students = $user->getchildreninfo($id); 
			while($row = $user->fetch()){
				$data = $row['fname']." ".$row['lname'];
			}
			$json_data = $data;
			echo json_encode($json_data); //send data as json format
			break;
		
		case '14': 
			$id = $_REQUEST['id'];
			$child = $_REQUEST['chi'];
			$arraylist = array();
			$students = $user->getchildrenno($id);
			while($row = $user->fetch()){
				$list = $row['children'];
			}
			$arraylist = explode(",",$list);
			$arr = array_diff($arraylist, array($child));
			$listagain = implode(",",$arr);
			$students = $user->addchildren($listagain,$id); 
			$json_data = $listagain;
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