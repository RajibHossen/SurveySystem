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


function printSurvey()
{
	include 'mysqlconfig.php';
	
	//Prints a survey with id $sid
	//Returned bool determines success
	
	$sql = connectMySQL();
	
	//Prints head of survey
	echo '<div id="content">
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
	echo '<input type="submit" name = "submit" value="Submit"></div>';	
	echo '</form>';
	echo mysqli_error($sql);
	
	mysqli_close($sql);
		
}


?>