<?php
/** written by Brian Martey
*/
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
include_once("adb.php");
/**
*Users  class
*/
class users extends adb{
	function users(){
	}
	/**
	*user log in
	*@param string username  
	*@param password login password
	*returns a boolean true if successful, else, false
	*/

	function login($username, $password){
		$strQuery="select * from users where USERNAME = '$username' && PASSWORD = MD5('$password')";
		
		$result = $this->query($strQuery);
		if ($result){
			return $this->fetch();
		}else{
			return $result;
		}
	}

	function adminlogin($username, $password){
		$strQuery="select * from users where LEVEL = '1' && USERNAME = '$username' && PASSWORD = MD5('$password')";
		
		$result = $this->query($strQuery);
		if ($result){
			return $this->fetch();
		}else{
			return $result;
		}
	}

	function adminadduser($fname, $lname, $school, $level, $class){
		$username = $fname.".".$lname;
		$strQuery="insert into users set FNAME = '$fname', LNAME = '$lname', SCHOOLID = '$school', LEVEL = '$level', USERNAME = '$username',PASSWORD = MD5(1), grade = '$class' ";
		
		$result = $this->query($strQuery);
	}

	function adduser($fname, $lname, $username, $password, $school, $level, $class, $phone, $email){
		$strQuery="insert into users set FNAME = '$fname', LNAME = '$lname', SCHOOLID = '$school', LEVEL = '$level', USERNAME = '$username',PASSWORD = MD5('$password'), grade = '$class', phone = '$phone', email = '$email' ";
		$result = $this->query($strQuery);
	}


	function adminedituser(){
		$strQuery="udpate users ";
		
		$result = $this->query($strQuery);
		if ($result){
			return $this->fetch();
		}else{
			echo $result;
			return $result;
		}
	}

	function admingetusers($level){
		$strQuery="select * from users where LEVEL = '$level'";
		
		$result = $this->query($strQuery);
		if ($result){
			return $this->fetch();
		}else{
			return $result;
		}
	}

	//used
	function getchildrenno($id){
		$strQuery="select children from users where UID = '$id'";
		$result = $this->query($strQuery);
	}

	//used
	function getparentsno($id){
		$strQuery="select parents from users where UID = '$id'";
		$result = $this->query($strQuery);
	}

	function getstudentsno(){
		$strQuery="select count(FNAME) from users where LEVEL = '2'";
		$result = $this->query($strQuery);
	}

	function getteachersno(){
		$strQuery="select count(FNAME) from users where LEVEL = '3'";
		$result = $this->query($strQuery);
	}
	
	function getteacherassignments($id){
		$strQuery="select count(description) from assignments where teacherid ='$id'";
		$result = $this->query($strQuery);
	}

	function getstudentsid($grade,$schid){
		$strQuery="select UID from users where grade ='$grade' and SCHOOLID ='$schid' and LEVEL = 2";
		$result = $this->query($strQuery);
	}

	//used
	function getstudentsinfo($grade,$schid){
		$strQuery="select UID, FNAME, LNAME from users where grade ='$grade' and SCHOOLID ='$schid' and LEVEL = 2";
		$result = $this->query($strQuery);
	}

	//used
	function getstudentsnames($grade,$schid){
		$strQuery="select FNAME, LNAME from users where grade ='$grade' and SCHOOLID ='$schid' and LEVEL = 2";
		$result = $this->query($strQuery);
	}

	//used
	function addstudentstoclass($grade,$schid,$tid,$stid){
		$strQuery="insert into schoolclasses set cno ='$grade', schid ='$schid', tid = '$tid', stid = '$stid'";
		$result = $this->query($strQuery);
	}	

	//used
	function getchildreninfo($id){
		$strQuery="select u.UID as uid, u.FNAME as fname, u.LNAME as lname, c.cname as name from users as u inner join class as c on c.cno = u.grade where UID = '$id'";
		$result = $this->query($strQuery);
	}

	//used
	function addchildren($childid,$id){
		$strQuery="update users set children ='$childid' where UID = '$id'";
		$result = $this->query($strQuery);
	}

	//used
	function addparents($pardid,$id){
		$strQuery="update users set parents ='$pardid' where UID = '$id'";
		$result = $this->query($strQuery);
	}

	//used
	function getstudentsnoinclass($grade,$schid){
		$strQuery="select count(FNAME) from users where grade ='$grade' and SCHOOLID ='$schid' and LEVEL =2";
		$result = $this->query($strQuery);
	}

	function getstudentsinclass($grade,$schid,$tid){
		$strQuery="select stid from schoolclasses where cno ='$grade' and schid ='$schid' and tid = '$tid'";
		$result = $this->query($strQuery);
	}

	function getstudentsemailsinclass($grade,$schid){
		$strQuery="select email from users where grade ='$grade' and SCHOOLID ='$schid' and LEVEL = '2'";
		$result = $this->query($strQuery);
	}

	function getemails($id){
		$strQuery="select email from users where UID = '$id'";
		$result = $this->query($strQuery);
	}

	function updatestudentsinclass($grade,$schid,$tid,$stid){
		$strQuery="update schoolclasses set cno ='$grade', schid ='$schid', tid = '$tid', stid = '$stid'";
		$result = $this->query($strQuery);
	}

	function getusers($id){
		$strQuery="select * from users where UID = '$id'";		
		$result = $this->query($strQuery);
	}
}
?>