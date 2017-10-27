<?php
/** written by Brian Martey
*/
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
include_once("adb.php");
/**
*grades  class
*/
class grades extends adb{
	function grades(){
	}
	/**
	*get class
	*returns a boolean true if successful, else, false
	*/

	function getgrades($stid, $letter){
		$strQuery="select COUNT(lettergrade) from completed_assignments where stid ='$stid' and lettergrade ='$letter'";
		$result = $this->query($strQuery);
		if ($result){
			return $result;
		}else{
			return $result;
		}
	}
	//used
	function getclassgrades($grade, $letter){
		$strQuery="select COUNT(lettergrade) from completed_assignments as c inner join users as u on u.UID = c.stid where u.grade ='$grade' and lettergrade ='$letter'";
		$result = $this->query($strQuery);
		if ($result){
			return $result;
		}else{
			return $result;
		}
	}

	/**
	*get class
	*returns a boolean true if successful, else, false
	*/

	function getseriesgrades($stid){
		$strQuery="select date_submitted,percentage from completed_assignments where stid ='$stid'";
		$result = $this->query($strQuery);
		if ($result){
			return $result;
		}else{
			return $result;
		}
	}

	/**
	*get class
	*returns a boolean true if successful, else, false
	*/

	function getseriesno($stid){
		$strQuery="select sdate,count(percentage) from completed_assignments where stid ='$stid' group by sdate";
		$result = $this->query($strQuery);
		if ($result){
			return $result;
		}else{
			return $result;
		}
	}
			
}
?>