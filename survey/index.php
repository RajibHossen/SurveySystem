<html>
	<head>
		<title>This is a test page</title>
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
		$courseName = "Data Mining";//change the name of the course
		$courseID = "CSE 4211";//change the code of the course in the string. do not delete quotation.
		//
		//

		?>
		<div class="container">
			<div class = "header">
				<h3 class="HeadTitle">Post course survey of the course <?php echo $courseName;?></h1>
				<h3 class = "subTitle"><?php echo "Course Code: ".$courseID;?></h2>
				<div class="headTable">
					<div class="row1">Dummy Text Dummy Text</div>
					<div class="row2">Dummy Text Dummy Text</div>
				</div>
			</div>
			<?php 

				//printSurvey($courseID,$courseName); //call to printSurvey method of functions page. printing all the question is his responsibility

				printResult($courseID,$courseName);
			?>
			<div class = "footer">
			</div>
		</div>
	</body>
</html>