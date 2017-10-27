<?php
/** written by Brian Martey
*/
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
include_once("adb.php");
/**
*topic  class
*/
class topic extends adb{
	function topic(){
	}
	/**
	*get topic
	*returns a boolean true if successful, else, false
	*/

	function gettopics(){
		$strQuery="select tno,tname from topic_area";
		$result = $this->query($strQuery);
		if ($result){
			return $result;
		}else{
			return $result;
		}
	}

	/**
	*get topic
	*@param string info  
	*returns a boolean true if successful, else, false
	*/

	function gettopic($info){
			$strQuery="select tno,tname from topic_area where tname like '%$info%'";
			$result = $this->query($strQuery);
	}

	/**
	*add topic
	*@param string title
	*@param string content  
	*@param date date_sent
	*returns a boolean true if successful, else, false
	*/

	function addtopic($tno,$tname){
			$strQuery="insert into topic_area set tno='$tno',tname='$tname'";
			$result = $this->query($strQuery);
	}
			
}
?>