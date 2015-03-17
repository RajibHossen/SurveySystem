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
$success = 1;

$sql = connectMySQL();
for ($count=$MinQId;$count<=$MaxQId;$count++) { 
	if (isset($_POST[$count])) {
		/*echo 'Response value for Question ID"'.$count.'" is:';
		echo $_POST[$count];
		echo "<br/>";
		*/
		$rating = $_POST[$count];
		$insert = mysqli_query($sql,"INSERT INTO responses (value,question_id) VALUES ('$rating','$count')") or die(mysql_error());
		if ($insert == FALSE) {
			//echo "something went wrong";
			# code...
			$success = 0;
		}
	}
	else{
		continue;
	}
}
if ($success==1) {
	echo "Thanks for your passion. you can submit a new form if you want";
}

?>