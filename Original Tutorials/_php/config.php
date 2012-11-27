<?php

error_reporting(E_ALL);

ini_set('display_errors', 1);

//Base URL of the server links
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/');

//Database connection details for the local website
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');

//Tutorial Database names
define('DB_NAME', 'thegurucoder');
define('T4_DB_NAME', 'paypalShoppingCart');

//Paypal shopping cart settings
define('TAX', '20');

//PayPal Submission URL
define('PPCART_URL', 'https://www.paypal.co.uk/cgi-bin/webscr');

//PayPal Account (email you registered with PayPal!)
define('PPCART_ACCOUNT', 'thegurucoder@andrefigueira.com');

//Currency Code for PayPal Check here for codes if you need to change it: 
define('PPCART_CURRENCY', 'EUR');

//Country Code for PayPal Check here for codes if you need to change it: 
define('PPCART_COUNTRY', 'UK');

//Return PayPal URL (Page that the user will see when they complete a payment)
define('PPCART_RETURN_URL', 'http://localhost:8888/TheGuruCoder/tutorial-4/paymentSuccess.php');

?>