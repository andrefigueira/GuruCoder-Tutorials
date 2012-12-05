<!DOCTYPE html>
<html>
<head>
	<title>HTML5 data-attributes</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script>
		
		$(document).ready(function(){
		
			var data = '';
			
			$('.product').each(function(){
			
				var productID = $(this).data('product-id');
				
			});
			
		});
		
	</script>
</head>
<body>

<div class="product" data-product-id="1" data-product-price="1500">
	iMac
</div>

<div class="product" data-product-id="2" data-product-price="500">
	iPad
</div>

<div class="product" data-product-id="3" data-product-price="1800">
	Macbook
</div>

</body>
</html>