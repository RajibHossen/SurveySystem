<html>
	<head>
		<title>This is a test page</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<?php
		include 'functions.php' ; ?>
		<div class="container">
			<div class = "header">
				<h3 class="HeadTitle">Post course survey of the course XX</h1>
				<h3 class = "subTitle">101 XXXX</h2>
				<div class="headTable">
					<div class="row1">cbcvb</div>
					<div class="row2">vbcxvxc</div>
				</div>
				<h3 class = "TitleText">Please complete all the question</h2>
			</div>
			<?php printSurvey(); //call to printSurvey method of functions page. printing all the question is his responsibility?>
			<div class = "footer">
			</div>
		</div>
	</body>
</html>