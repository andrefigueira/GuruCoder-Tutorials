<?php

$name = 'TheGuruCoder';

echo 'this is an echo<br>';
echo "My alias is $name<br>";

print 'this is a print<br>';
print 'My alias is '.$name.'<br>';

var_dump($_GET);
var_dump($_POST);

echo $_POST['postvar'];
echo $_GET['getvar'];

?>

<form action="" method="post">

	<input name="postvar" value="thisisapostvar" />
	
	<input type="submit" />

</form>