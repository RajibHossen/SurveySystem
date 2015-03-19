<?php 

include 'mysqlconfig.php';

function connectMySQL()
{
	include 'mysqlconfig.php';
	//Attempts to set up a connection to the MySQL server defined in settings.php
	//Returns mysql connection handler if successful, an error string otherwise
	
	
	$sql = mysqli_connect($server, $un, $pw);
	if (!$sql)
		{
		return mysqli_error($sql);
		}
	$temp = mysqli_select_db($sql, $db);
	if (!$temp)
		{
		return mysqli_error($sql);
		}
	return $sql;
}

$MaxQId = $_POST["maxQId"];
$MinQId = $_POST["minQId"];
$courseID = $_POST["course_id"];
$courseName = $_POST["course_name"];
$success = 1;

$sql = connectMySQL();
echo $courseID;
for ($count=$MinQId;$count<=$MaxQId;$count++) { 
	if (isset($_POST[$count])) {
		/*echo 'Response value for Question ID"'.$count.'" is:';
		echo $_POST[$count];
		echo "<br/>";
		*/
		$rating = $_POST[$count];
		$insert = mysqli_query($sql,"INSERT INTO responses (course_id,course_name,value,question_id) VALUES ('$courseID','$courseName','$rating','$count')") or die(mysql_error());
		if ($insert == FALSE) {
			$success = 0;
			exit();
		}
	}
	else{
		continue;
	}
}
if ($success==1) {
	echo "Thanks for your passion. you can submit a new form if you want";
}
else
	echo "something went wrong";

?>