<?php
/** written by Brian Martey
*/
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
include_once("adb.php");
/**
*Assignments  class
*/
class assignments extends adb{
	function assignments(){
	}
	/**
	*get assignments
	*returns a boolean true if successful, else, false
	*/

	function getassignments(){
		$strQuery="select aid,title,topic_area,grade,description from assignments";
		$result = $this->query($strQuery);
		if ($result){
			return $result;
		}else{
			return $result;
		}
	}

	/**
	*get assignments
	*@param string info  
	*returns a boolean true if successful, else, false
	*/

	function getassignment($info){
		$strQuery="select title,topic_area,grade,description from assignments where title like '%$info%' or topic_area like '%$info%'";
		$result = $this->query($strQuery);
	}

	/**
	*get assignments
	*@param string info  
	*returns a boolean true if successful, else, false
	*/

	function getassignmenttype($info){
		$strQuery="select atype from assignments where aid ='$info'";
		$result = $this->query($strQuery);
	}

	/**
	*get assignmentquestions
	*@param string info  
	*@param string grade  
	*returns a boolean true if successful, else, false
	*/
	//used
	function getassignmentlist($school,$grade,$stid){
		$strQuery="select t.tname,a.description,a.questionnos, a.aid from assignments as a inner join topic_area as t on t.tno = a.topic_area where schoolid = '$school' and grade = '$grade' and a.aid not in (SELECT aid FROM completed_assignments where stid = '$stid') and a.aid not in (SELECT aid FROM review_assignments where stid = '$stid')order by date desc";
		$result = $this->query($strQuery);
	}

	/**
	*get review assignmentquestions
	*@param string info  
	*@param string grade  
	*returns a boolean true if successful, else, false
	*/
	//used
	function getreviewassignmentlist($school,$grade,$stid){
		$strQuery="select t.tname,a.description,a.questionnos, a.aid from assignments as a inner join topic_area as t on t.tno = a.topic_area where schoolid = '$school' and grade = '$grade' and a.aid in (SELECT aid FROM review_assignments where stid = '$stid' and status = 'not') order by date desc";
		$result = $this->query($strQuery);
	}

	/**
	*get review assignmentquestions
	*@param string info  
	*@param string grade  
	*returns a boolean true if successful, else, false
	*/
	//used
	function getreviewassignmentbyid($stid){
		$strQuery="select r.aid,r.tid,t.tname,a.description,u.FNAME,u.LNAME from review_assignments as r inner join assignments as a on a.aid = r.aid inner join topic_area as t on t.tno = a.topic_area inner join users as u on u.UID = r.stid where stid = '$stid' and status = 'not' order by date_submitted desc";
		$result = $this->query($strQuery);
	}

	/**
	*get assignmentquestions
	*@param string info  
	*@param string grade  
	*returns a boolean true if successful, else, false
	*/
	//used
	function getcountofassignmentlist($school,$grade,$stid){
		$strQuery="select count(t.tname) from assignments as a inner join topic_area as t on t.tno = a.topic_area where schoolid = '$school' and grade = '$grade' and a.aid not in (SELECT aid FROM completed_assignments where stid = '$stid') order by date desc";
		$result = $this->query($strQuery);
	}

	/**
	*get assignmentquestions
	*@param string info  
	*@param string grade  
	*returns a boolean true if successful, else, false
	*/
	//used
	function getcountofreviewassignmentlist($school,$grade,$stid){
		$strQuery="select count(t.tname) from assignments as a inner join topic_area as t on t.tno = a.topic_area where schoolid = '$school' and grade = '$grade' and a.aid in (SELECT aid FROM review_assignments where stid = '$stid' and status = 'done') order by date desc";
		$result = $this->query($strQuery);
	}

	//used
	function getcountreviewedlist($stid){
		$strQuery="select count(aid) FROM review_assignments where stid = '$stid' and status = 'done'";
		$result = $this->query($strQuery);
	}

	//used
	function getcounttobereviewedlist($stid){
		$strQuery="select count(aid) FROM review_assignments where stid = '$stid' and status = 'not'";
		$result = $this->query($strQuery);
	}

	/**
	*get assignmentquestions
	*@param string info  
	*@param string grade  
	*returns a boolean true if successful, else, false
	*/

	function getcompletelist($school,$grade, $stid){
		$strQuery="select t.tname, a.description, a.questionnos, a.aid, c.percentage, c.lettergrade FROM assignments AS a INNER JOIN topic_area AS t ON t.tno = a.topic_area INNER JOIN completed_assignments AS c on c.aid = a.aid WHERE schoolid= '$school' and grade = '$grade' and c.stid = '$stid' order by c.caid desc";
		$result = $this->query($strQuery);
	}

	/**
	*get assignmentquestions
	*@param string info  
	*@param string grade  
	*returns a boolean true if successful, else, false
	*/

	function getassignmentquestions($id){
		$strQuery="select t.tname,a.description,a.questionnos,a.teacherid,a.atype from assignments as a inner join topic_area as t on t.tno = a.topic_area where aid = '$id'";
		$result = $this->query($strQuery);
	}

	/**
	*add assignment
	*@param string title
	*@param string topic_area  
	*@param int grade
	*returns a boolean true if successful, else, false
	*/

	function addassignment($title,$topic_area,$grade,$description,$questionnos,$tid,$schid,$date,$atype){
		$strQuery="insert into assignments set title='$title',topic_area='$topic_area',grade ='$grade',description = '$description',questionnos = '$questionnos', teacherid='$tid', schoolid = '$schid', date ='$date', atype = '$atype'";
		$result = $this->query($strQuery);
	}

	/**approve assignment*/
	function approveassignment($stid,$assid){
		$strQuery="update review_assignments set status = 'done' where stid = '$stid' and aid = '$assid'";
		$result = $this->query($strQuery);
	}

	//used
	function getreviewassignmentnobyclass($clss){
		$strQuery="select count(r.aid) from review_assignments as r inner join assignments as a on a.aid = r.aid where a.atype = '2' and r.status = 'not' and a.grade = '$clss'";
		$result = $this->query($strQuery);
	}

	//used
	function getreviewassignmentsbyclass($clss){
		$strQuery="select r.stid from review_assignments as r inner join assignments as a on a.aid = r.aid where a.atype = '2' and r.status = 'not' and a.grade = '$clss'";
		$result = $this->query($strQuery);
	}
			
}
?>