<?php include('../_php/functions.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>The Guru Coder - Tutorial 4 Code a PayPal Shopping Cart</title>
	<link rel="stylesheet" href="../_style/main.css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script src="../_scripts/functions.js"></script>
</head>	
<body>

	<div id="container">
	
		<?php notification(); ?>
	
		<h1>The Guru Coder</h1>
		<h2>Tutorial 4 - Code a PayPal Shopping Cart</h2>
		
		<h3>Basket</h3>
		
		<a href="tutorial-4.php">Back to Products</a>
		
		<form name="paypalCheckout" action="<?php echo PPCART_URL; ?>" method="post">
		
	        <input type="HIDDEN" name="business" value="<?php echo PPCART_ACCOUNT; ?>">
	        <input type="HIDDEN" name="cmd" value="_cart">
	        <input type="HIDDEN" name="upload" value="1">
	        <input type="hidden" name="currency_code" value="<?php echo PPCART_CURRENCY; ?>">
	        <input type="hidden" name="lc" value="<?php echo PPCART_COUNTRY; ?>">
	        <input type="hidden" name="return" value="<?php echo PPCART_RETURN_URL; ?>">   
		
			<?php getShoppingCart(); ?>
		
		</form>
    
    </form>
		
	</div>
	
</body>
</html>