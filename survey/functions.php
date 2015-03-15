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
		    <th class="des">Description</th>   
		    <th>Very Good</th>   
		    <th>Good</th>   
		    <th>Moderate</th>
		    <th>Bad</th>   
		    <th>Too Bad</th>
		</tr>
	<form method="POST" action="">
	<input type="hidden" name="sid" value="">
	<input type="hidden" name="action" value="0">';

	$test = mysqli_query($sql,"SELECT category,count(*) AS value FROM question GROUP BY category");

	while ($row = mysqli_fetch_array($test, MYSQL_ASSOC)) {
		# code...
		$categoryNames[] = $row['category'];
		$values[] = $row['value'];
	}
	$a = 0;
	$i = 1;
	foreach ($categoryNames as $cat) {

		$result = mysqli_query($sql, "SELECT question_id,question from question WHERE category ='$cat'");

		while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) 
		{
			$questionID[] =  $row['question_id'];
			$question[] = $row['question'];

		}
		$count = 0;
		$increment = 0;
		for($increment = 0;$increment < $values[$a];$increment++) {
			if($count==0)
			{
				echo '<tr>';
				echo '<td rowspan=$values[$a] style="border-bottom:none">'.$cat.'</td>';
				echo '<td>'.$i.'</td>';
				echo '<td>'.$question[$count].'</td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="5"></td>';
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
				echo '<td>'.$i.'</td>';
				echo '<td>'.$question[$count].'</td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="5"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="4"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="3"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="2"></td>';
				echo '<td align="center"><input type="radio" name="'.$questionID[$count].'" value="1"></td>';
				echo '</tr>';

			}
			$count++;
			$i++;
			}
		$a++;
		# code...
	}
	
	echo '</form></table></div>';
	echo '<div id="submit"><input type="submit" value="Submit"></div>';	
	echo mysqli_error($sql);
	
	mysqli_close($sql);
		
}
?>