<?php

//Abandon hope all ye who enter here

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


function printSurvey($courseID,$courseName)
{
	include 'mysqlconfig.php';

	$sql = connectMySQL();
	
	//Prints head of survey
	echo '<div id="content">
	<h3 class = "TitleText">Please complete all the question</h3>
	<table class="table-main">
		<tr>
		    <th></th>
		    <th>Serial</th>
		    <th>Question ID</th>    
		    <th class="des">Description</th>   
		    <th>Very Good</th>   
		    <th>Good</th>   
		    <th>Moderate</th>
		    <th>Bad</th>   
		    <th>Too Bad</th>
		</tr>
	<form method="POST" action="processAnswers.php">';

	$test = mysqli_query($sql,"SELECT category,count(*) AS value FROM questions GROUP BY category");

	while ($row = mysqli_fetch_array($test, MYSQL_ASSOC)) {
		# code...
		$categoryNames[] = $row['category'];
		$values[] = $row['value'];
	}
	$a = 0;
	$serial = 1;
	foreach ($categoryNames as $cat) {
		
		$result = mysqli_query($sql, "SELECT question_id,question from questions WHERE category ='$cat'");

		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) 
		{
			$questionID[] =  $row['question_id'];
			$question[] = $row['question'];

		}
		$count = 0;

		foreach ($question as $key => $ques) {
			if($count==0)
			{
				echo '<tr>';
				echo '<td rowspan=$values[$a] style="border-bottom:none">'.$cat.'</td>';
				echo '<td>'.$serial.'</td>';
				echo '<td>'.$questionID[$count].'</td>';
				echo '<td>'.$ques.'</td>';
				echo '<td align="center"><input type="radio" required  name="'.$questionID[$count].'" value="5"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="4"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="3"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="2"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="1"></td>';
				echo '</tr>';
			}
			else
			{
				echo '<tr>';
				echo '<td style="border:none"></td>';
				echo '<td>'.$serial.'</td>';
				echo '<td>'.$questionID[$count].'</td>';
				echo '<td>'.$ques.'</td>';
				echo '<td align="center"><input type="radio" required name="'.$questionID[$count].'" value="5"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="4"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="3"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="2"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="1"></td>';
				echo '</tr>';

			}
			$count++;
			$serial++;
		}
		unset($question);
		unset($questionID);
		$a++;
		# code...
	}
	$serial--;
	echo '</table></div>';
	//Getting maximum question id from the database
	$maximumQId = mysqli_query($sql, "SELECT MAX(question_id) FROM questions");
	$resprow = mysqli_fetch_array($maximumQId);
	$maxqid = $resprow['MAX(question_id)'];

	//Getting minimum question ID
	$MinimumQId = mysqli_query($sql, "SELECT MIN(question_id) FROM questions");
	$resprow = mysqli_fetch_array($MinimumQId);
	$minqid = $resprow['MIN(question_id)'];

	echo '<input type = "hidden" name = "maxQId" value = '.$maxqid.'>';	
	echo '<input type = "hidden" name = "minQId" value = '.$minqid.'>';	
	echo '<input type = "hidden" name = "course_id" value = "'.$courseID.'">';	
	echo '<input type = "hidden" name = "course_name" value = "'.$courseName.'">';	
	echo '<input type="submit" name = "submit" value="Submit"></div>';	
	echo '</form>';
	echo mysqli_error($sql);
	
	mysqli_close($sql);
		
}
function printResult($courseID,$courseName){

	include 'mysqlconfig.php';
	
	$sql = connectMySQL();
	echo '<div id="content">
	<h3 class = "TitleText">Responses for different courses</h3>
	<table class="table-main">
		<tr>
		    <th>Course Code</th>  
		    <th class="des">Course Name</th>   
		    <th>Average Response Value</th>   
		    <th>Total Response</th>   
		</tr>';

		$query = mysqli_query($sql,"SELECT course_id,count(*) FROM responses GROUP BY course_id");
		while ($row = mysqli_fetch_array($query, MYSQL_ASSOC)) {
			# code...
			$courseIDs[] = $row['course_id'];
			$numberOfTimes[] = $row['count(*)'];
		}
		$k = 0;
		foreach ($courseIDs as $key => $Ccode) {
			echo '<tr>';
			echo '<td>'.$Ccode.'</td>';
			//query to database for fetching course names.
			$queryForNames = mysqli_query($sql,"SELECT course_name,AVG(value) FROM responses WHERE course_id = '$Ccode'");
			$res = mysqli_fetch_array($queryForNames);
			$course = $res['course_name'];
			$averageValue = $res['AVG(value)'];
			//end of query
			echo '<td>'.$course.'</td>';
			echo '<td>'.$averageValue.'</td>';
			echo '<td>'.$numberOfTimes[$k].'</td>';
			echo '</tr>';
			$k++;
		}
		
	


	echo '</table>
	</div>';



}


?>