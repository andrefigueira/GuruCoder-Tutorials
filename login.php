<?php

error_reporting(1);
ini_set('display_errors', 1);

ob_start();

function login()
{

	if(isset($_POST['username']))
	{
		
		$db = new mysqli('localhost', 'root', 'root', 'gurucodertutorial_login');
		
		$username = $db->real_escape_string($_POST['username']);
		$password = $db->real_escape_string($_POST['password']);
		
		if(userExists($username))
		{
			
			if(verifyPassword($username, $password))
			{
		
				header('Location: /GuruCoder-Tutorials/login.php?message=Successfully logged in');
				
			}
			else
			{
		
				header('Location: /GuruCoder-Tutorials/login.php?message=Incorrect password');
				
			}
			
		}
		else
		{
		
			header('Location: /GuruCoder-Tutorials/login.php?message=No user exists');
			
		}
		
	}

}

function verifyPassword($username, $password)
{
		
	$db = new mysqli('localhost', 'root', 'root', 'gurucodertutorial_login');
	
	$result = $db->query('
	SELECT password
	FROM users
	WHERE username = "'.$username.'"
	LIMIT 1
	');
	
	while($row = $result->fetch_object())
	{		
	
		if(crypt($password, $row->password) == $row->password)
		{
			
			return true;
			
		}
		else
		{
		
			return false;
			
		}
		
	}

}

function userExists($username)
{
		
	$db = new mysqli('localhost', 'root', 'root', 'gurucodertutorial_login');
	
	$result = $db->query('
	SELECT username
	FROM users
	WHERE username = "'.$username.'"
	LIMIT 1
	');
	
	if(!$result)
	{
		
		echo $db->error;
		
	}
	
	return (bool)$result->num_rows;

}

ob_flush();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="css/login.css" />
</head>
<body>

	<?php if(isset($_GET['message'])){ echo $_GET['message'];} ?>

	<div class="container">
		
		<form action="<?php login(); ?>" method="post">
			
			<input type="text" id="username" name="username" placeholder="Username..." autocomplete="off" />
			<input type="password" id="password" name="password" placeholder="Password..." autocomplete="off" />
			
			<input type="submit" name="login" value="Login" />
			
		</form>
		
	</div>

</body>
</html>