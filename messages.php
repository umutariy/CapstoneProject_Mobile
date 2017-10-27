<?php
/** written by Brian Martey
*/
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
include_once("adb.php");
/**
*Messages  class
*/
class messages extends adb{
	function messages(){
	}
	/**
	*get messages
	*returns a boolean true if successful, else, false
	*/

	function getmessages(){
		$strQuery="select mid,title,content,date_sent,sender from messages";
		$result = $this->query($strQuery);
		if ($result){
			return $result;
		}else{
			return $result;
		}
	}

	/**
	*get messages
	*@param string info  
	*returns a boolean true if successful, else, false
	*/

	function getmessage($info){
			$strQuery="select title,content,date_sent,sender from messages where title like '%$info%' or content like '%$info%'";
			$result = $this->query($strQuery);
	}

	/**
	*add message
	*@param string title
	*@param string content  
	*@param date date_sent
	*returns a boolean true if successful, else, false
	*/

	function addmessage($title,$content,$date_sent,$sender,$class,$sch){
			$strQuery="insert into messages set title='$title',content='$content',date_sent ='$date_sent', sender='$sender', class='$class', sch='$sch'";
			$result = $this->query($strQuery);
	}
			
}
?>