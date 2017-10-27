<?php 
include_once("class.php");
include_once("grades.php");
include_once("messages.php");
include_once("questions.php");
include_once("school.php");
include_once("topic.php");
include_once("users.php");
header('Access-Control-Allow-Origin: *');
/** written by Brian Martey*/
/** test class*/

/**
* 
*/
class testclass extends PHPUnit_Framework_Testcase
{

	function testgetClassInfo()
	{
		$class = new classes();
		$this -> AssertTrue($class -> getclasses());
	}

	function testgetGrades()
	{
		$id = 1;
		$letter = B; 
		$grades = new grades();
		$this -> AssertTrue($grades -> getgrades($id, $letter));
	}

	function testgetClassGrades()
	{
		$grade = 4;
		$letter = F; 
		$grades = new grades();
		$this -> AssertTrue($grades -> getclassgrades($grade, $letter));
	}

	function testgetMessages()
	{
		$messages = new messages();
		$this -> AssertTrue($messages -> getmessages());
	}

	function testgetQuestions()
	{
		$questions = new questions();
		$this -> AssertTrue($questions -> getquestions());
	}

	function testgetSchools()
	{
		$schools = new school();
		$this -> AssertTrue($schools -> getschools());
	}
	
	function testgetTopic()
	{
		$topics = new topic();
		$this -> AssertTrue($topics -> gettopics());
	}

	/*function testgetChildrenInfo()
	{
		$id = "";
		$user = new users();
		$this -> AssertTrue($user -> getchildreninfo($id));
	}*/
}

?>