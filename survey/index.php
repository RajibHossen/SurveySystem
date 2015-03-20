<?php 
session_start();
//$user = $_SESSION['username'];
$user = "teacher";
?>
<html>
	<head>
		<title>Survey system of University of XXXX</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<?php
		include 'functions.php' ; 
		/*
		******************
		please use this variables to change course name and ID. I use this variable to show course name and ID on the page.
		this value is manadatory to insert responses in the table
		*/
		$courseName = "Data sctructure and Algorithms";//change the name of the course
		$courseID = "CSE 2101";//change the code of the course in the string. do not delete quotation.
	?>

		<div class="container">
			<div class = "header">
	<?php
		if ($user=="teacher") {
	?>
			<h2 class="HeadTitle">Responses For Courses of University Of XXXX</h2>
			<h3 class = "subTitle">response values for differet courses</h3>
			<div class="headTable">
				<div class="row1">Dummy Text Dummy Text</div>
				<div class="row2">Dummy Text Dummy Text</div>
			</div>
		</div>
	<?php 	
			printResult($courseID,$courseName);

		}	
		elseif ($user =="student") { 
	?>
			<h2 class="HeadTitle">Post course survey of the course <?php echo $courseName;?></h2>
			<h3 class = "subTitle"><?php echo "Course Code: ".$courseID;?></h3>
			<div class="headTable">
				<div class="row1">Dummy Text Dummy Text</div>
				<div class="row2">Dummy Text Dummy Text</div>
			</div>
		</div>
	<?php
			printSurvey($courseID,$courseName);
				
		}
	?>

			<div class = "footer">
			</div>
		</div>
	</body>
</html>