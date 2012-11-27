<?php include('_php/functions.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>The Guru Coder - Tutorial 2 How to code a PHP notification function</title>
	<link rel="stylesheet" href="_style/main.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script src="_scripts/functions.js"></script>
</head>	
<body>

	<div id="container">
	
		<?php notification(); ?>
	
		<h1>The Guru Coder</h1>
		<h2>Tutorial 2 - Code a PHP Notification function</h2>
		
		<form action="<?php submitForm(); ?>" method="post">
		
			<label for="name">Name</label>
			<input type="text" name="name" id="name" />
			
			<input type="submit" name="submit" id="submit" value="Send" />
		
		</form>
		
	</div>
	
</body>
</html>