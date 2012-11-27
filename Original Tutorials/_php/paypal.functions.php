<?php

/**PHP/MYSQL PayPal Shopping Cart
Created by: André Figueira
Website: www.andrefigueira.com
Created date: 07/08/2011
**/

function getProducts()
{

	//Function to display the products on the front end
	
	//Create the MYSQL db connection
	$db = new Connection(DB_HOST, DB_USER, DB_PASS, T4_DB_NAME);
	
	//Query the DB for all the products
	$result = $db->query('SELECT * FROM products');
	
	//Set the items variable so that you can add to it in the loop below
	$items = '';
	
	//Loop through the mysql results
	while($row = mysql_fetch_assoc($result))
	{
	
		$items .= '
		<div class="product">
			<h3>'.stripslashes($row['productName']).'</h3>
			<div class="info">
				<img src="'.stripslashes($row['thumbnail']).'" width="auto" height="100" />
				<p>'.stripslashes($row['description']).'</p>
				<div class="price">&euro;'.number_format($row['price'], 2).'</div>
				<a href="addToCart.php?ID='.$row['ID'].'">Add to cart</a>
			</div>
		</div>
		';
	
	}
	
	echo $items;

}

function cartExists()
{

	//Function returns a bool depending wheather the paypal cart is set or not

	if(isset($_SESSION['paypalCart']))
	{
	
		//Exists
		return true;
	
	}
	else
	{
		
		//Doesn't exist
		return false;
	
	}

}

function createCart()
{

	//Create a new cart as a session variable with the value being an array
	$_SESSION['paypalCart'] = array();

}

function insertToCart($productID, $productName, $price, $qty = 1)
{

	//Function is run when a user presses an add to cart button

	//Check if the product ID exists in the paypal cart array
	if(array_key_exists($productID, $_SESSION['paypalCart']))
	{
		
		//Calculate new total based on current quantity
		$newTotal = $_SESSION['paypalCart'][$productID]['qty'] + $qty;
		
		//Update the product quantity with the new total of products
		$_SESSION['paypalCart'][$productID]['qty'] = $newTotal;
	
	}
	else
	{

		//If the product doesn't exist in the cart array then add the product
		$_SESSION['paypalCart'][$productID]['ID'] = $productID;
		$_SESSION['paypalCart'][$productID]['name'] = $productName;
		$_SESSION['paypalCart'][$productID]['price'] = $price;
		$_SESSION['paypalCart'][$productID]['qty'] = $qty;
	
	}

}

function addToCart()
{

	//Function for adding a product to the cart based on that products ID.
	//Create the MYSQL db connection
	$db = new Connection(DB_HOST, DB_USER, DB_PASS, T4_DB_NAME);

	//Check if the ID variable is set
	if(isset($_GET['ID']))
	{
	
		//Escape the string from the URL
		$ID = mysql_real_escape_string($_GET['ID']);
	
		//Check if the ID passed exists within the database
		$result = $db->query('SELECT * FROM products WHERE ID = "'.$ID.'" LIMIT 1');
		
		//Get the total results of if any product matched the query
		$totalRows = mysql_num_rows($result);
		
		//If the product ID exists in the database then insert it to the cart
		if($totalRows > 0)
		{
		
			while($row = mysql_fetch_assoc($result))
			{
			
				//Check if the cart exists
				if(cartExists())
				{
					
					//The cart exists so just add it to the cart
					insertToCart($ID, $row['productName'], $row['price']);
				
				}
				else
				{
				
					//The cart doesn't exist so create the cart
					createCart();
					
					//The cart is now created so add the product to the cart
					insertToCart($ID, $row['productName'], $row['price']);
				
				}
			
			}
		
		}
		else
		{
			
			//No products were found in the database so notify the user, redirect him and stop the code from continuing
			notify('Sorry but there is no product with that ID.', 0);
			header('Location: tutorial-4.php');
			break;
		
		}
	
		//The product was successfully added so set the notification and redirect to the cart page
		notify('Product added to the cart.', 1);
		header('Location: cart.php');
	
	}
	else
	{
		
		//No Product with that ID redirect and display message
		notify('Sorry but there is no product with that ID.', 0);
		header('Location: tutorial-4.php');
	
	}

}

function removeFromCart()
{

	//Runs when the user presses the remove from cart button

	if(isset($_GET['ID']))
	{
	
		$productID = $_GET['ID'];

		//Check if the product exists within the cart if so follow on
		if(array_key_exists($productID, $_SESSION['paypalCart']))
		{
		
			//Remove one from the total quantity of products set in the cart
			$newQty = $_SESSION['paypalCart'][$productID]['qty'] - 1;
			
			//Update the cart quantity
			$_SESSION['paypalCart'][$productID]['qty'] = $newQty;
			
			//If there are less than 1 in the qty subkey then remove the product from the cart
			if($newQty < 1)
			{
				
				//Remove the product from the cart
				unset($_SESSION['paypalCart'][$productID]);
			
			}
			
			//No Product with that ID redirect and display message
			notify('Removed 1 item from the cart.', 1);
			header('Location: cart.php');
		
		}
		else
		{
		
			//No Product with that ID redirect and display message
			notify('Sorry but there is no product with that ID.', 0);
			header('Location: tutorial-4.php');
		
		}
	
	}
	else
	{
		
		//No Product with that ID redirect and display message
		notify('Sorry but there is no product with that ID.', 0);
		header('Location: tutorial-4.php');
	
	}

}

function getShoppingCart()
{
	
	//Function creates the display for the cart

	//If the cart exists then follow on
	if(cartExists())
	{
		
		//Check if there are any products in the cart by counting the array keys
		if(count($_SESSION['paypalCart']) > 0)
		{
			
			//The table header html
			$html = '
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<th>Product</th>
					<th>Price</th>
					<th>Qty</th>
					<th></th>
				</tr>
			';
			
			$count = 1;
			
			//Loop through the items in the paypal cart
			foreach($_SESSION['paypalCart'] as $product)
			{
			
				$html .= '
				<tr>
					<td>'.$product['name'].'</td>
					<td>&euro;'.number_format($product['price'], 2).'</td>
					<td>'.$product['qty'].'</td>
					<td><a href="addToCart.php?ID='.$product['ID'].'">Add</a><a href="removeFromCart.php?ID='.$product['ID'].'">Remove</a></td>
					<input type="hidden" name="amount_'.$count.'" value="'.$product['price'].'" />
					<input type="hidden" name="quantity_'.$count.'" value="'.$product['qty'].'" />
					<input type="hidden" name="tax_rate_'.$count.'" value="'.TAX.'" />
					<input type="hidden" name="item_name_'.$count.'" value="'.stripslashes($product['name']).'" />
					<input type="hidden" name="item_number_'.$count.'" value="'.$product['ID'].'" />
				</tr>
				';
				
				$count++;
			
			}
			
			//HTML for the subrows such as the subtotal, tax and total
			$html .= '
				<tr class="empty">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td class="bold">Subtotal</td>
					<td>'.calculateSubtotal().'</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td class="bold">TAX @ '.TAX.'%</td>
					<td>'.calculateTax().'</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td class="bold">Total</td>
					<td>'.calculateTotal().'</td>
				</tr>
			
			</table>
			
			<input type="submit" name="submit" id="submit" value="Checkout with PayPal" />
			
			';
			
			echo $html;
		
		}
		else
		{
		
			//If there are no products then print out a message saying there are no products
			echo '<p>There are currently no products in your cart.</p>';
		
		}
	
	}
	else
	{
		
		//If there are no products then print out a message saying there are no products
		echo '<p>There are currently no products in your cart.</p>';
	
	}

}

function calculateSubtotal()
{

	//Set the base variable for the subtotal
	$subtotal = 0;

	//Loop through the products in the cart
	foreach($_SESSION['paypalCart'] as $product)
	{
		
		//Get the total amount of the current product iteration
		$qty = $product['qty'];
		
		//Get the price of the current product iteration
		$price = $product['price'];
		
		//Calculate the subtotal
		$subtotal = $subtotal + ($price * $qty);
	
	}
	
	//Create the formatted result for the subtotal
	$result = '&euro;'.number_format($subtotal, 2);
	
	return $result;

}

function calculateTotal()
{

	//Set the base variable for the total
	$total = 0;
	
	//Loop through the products in the cart
	foreach($_SESSION['paypalCart'] as $product)
	{
	
		//Get the total amount of the current product iteration
		$qty = $product['qty'];
		
		//Get the price of the current product iteration
		$price = $product['price'];
		
		//Calculate the total
		$total = $total + ($price * $qty);
	
	}
	
	//Calculate the tax based on the tax variable
	$tax = ($total * TAX) / 100;
	
	//Set the total price including tax
	$total = $total + $tax;
	
	//Create the formatted result for the total
	$result = '&euro;'.number_format($total, 2);
	
	return $result;

}

function calculateTax()
{

	//Set the base variable for the total
	$total = 0;

	//Loop through the products in the cart
	foreach($_SESSION['paypalCart'] as $product)
	{
	
		//Get the total amount of the current product iteration
		$qty = $product['qty'];
		
		//Get the price of the current product iteration
		$price = $product['price'];
		
		//Calculate the total
		$total = $total + ($price * $qty);
	
	}
	
	//Calculate the total tax
	$tax = ($total * TAX) / 100;
	
	//Create the formatted result for the total
	$result = '&euro;'.number_format($tax, 2);
	
	return $result;

}

?>