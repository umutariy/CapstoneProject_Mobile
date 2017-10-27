<?php
/** written by Brian Martey
*/
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
include_once("adb.php");
/**
*school  class
*/
class school extends adb{
	function school(){
	}
	/**
	*get school
	*returns a boolean true if successful, else, false
	*/

	function getschools(){
		$strQuery="select SID,SCHOOL_NAME from school";
		$result = $this->query($strQuery);
		if ($result){
			return $result;
		}else{
			return $result;
		}
	}

	/**
	*get school count
	*returns a boolean true if successful, else, false
	*/

	function getschoolno(){
		$strQuery="select count(SCHOOL_NAME) from school";
		$result = $this->query($strQuery);
	}

	/**
	*get school
	*@param string info  
	*returns a boolean true if successful, else, false
	*/

	function getschool($info){
			$strQuery="select SCHOOL_NAME from school where SID = '$info'";
			$result = $this->query($strQuery);
	}

	/**
	*add school
	*@param string title
	*@param string content  
	*@param date date_sent
	*returns a boolean true if successful, else, false
	*/

	function addschool($schname){
			$strQuery="insert into school set SCHOOL_NAME='$schname'";
			$result = $this->query($strQuery);
	}
			
}
?>