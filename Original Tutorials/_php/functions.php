<?php

/**PHP functions file
Created by: André Figueira
Created date: 05/08/2011
**/

//Configurations and Initializations
require_once('init.php');
require_once('config.php');

//Functions
require_once('paypal.functions.php');

//Classes
require_once('classes/connection.class.php');

function submitForm()
{

	if(isset($_POST['submit']))
	{
	
		notify('Hello I am '.$_POST['name'], 'positive');
	
	}

}

function notify($message, $karma = 2)
{
	
	//Function used to create a notification that lasts for one page refresh
	if($karma == 1)
	{
		
		$class = "positive-notification";
		
	}
	elseif($karma == 0)
	{
		
		$class = "negative-notification";
		
	}
	elseif($karma == 2)
	{
		
		$class = "neutral-notification";
		
	}
	
	$notification = array('message' => $message, 'class' => $class);
	
	$_SESSION['notification'] = serialize($notification);
	
}

function notification()
{
	
	//Prints the notification set with notify() then deletes it from session
	if(isset($_SESSION['notification']))
	{
		
		$notification = unserialize($_SESSION['notification']);
		extract($notification);
		
		$notification = '<div class="notify '.$class.'">'.$message.'</div>';
		
		echo $notification;
		
		unset($_SESSION['notification']);
		
	}
		
}

function getUsers()
{

	$db = new Connection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$result = $db->query('SELECT name FROM users');
	
	while($row = mysql_fetch_assoc($result))
	{
	
		echo $row['name'].'<br>';
	
	}

}

?>