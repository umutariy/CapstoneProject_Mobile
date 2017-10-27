<?php 
include_once("messages.php");
include_once("email.php");
include_once("users.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
/** written by Brian Martey*/
/**class message service*/
$level = $_REQUEST['cmd'];  //storing (get/post) request to a variable
$receivers = array();

$messages = new messages();
$email = new emailclass();
$user = new users();

if (!empty($level)) {
	switch ($level) {
		case '1': //not used
			$title = $_REQUEST['title'];
			$content = $_REQUEST['content'];
			$tid = $_REQUEST['tid'];
			$class = $_REQUEST['clss'];
			$sch = $_REQUEST['schid'];

			$userinfo = $user ->getusers($tid);
			while($row = $user -> fetch()){
				$sender = $row["FNAME"]." ".$row["LNAME"];
			}

			date_default_timezone_set("Europe/London");
		    $datesubmitted = date("Y-m-d");

			$send = $messages->addmessage($title,$content,$datesubmitted,$sender,$class,$sch);   
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