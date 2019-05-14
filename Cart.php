<?php
	session_start();
	$product_ids = array();
	
	
	
	if (filter_input(INPUT_POST, 'add_to_cart')){
		if(isset($_SESSION['shopping_cart'])){
			
			$count = count($_SESSION['shopping_cart']);
			
			
			$product_ids = array_column($_SESSION['shopping_cart'],'id');
			if (!in_array(filter_input(INPUT_GET,'id'),$product_ids)){
					$_SESSION['shopping_cart'][$count] = array
					(
						'id' => filter_input(INPUT_GET,'id'),
						'name' => filter_input(INPUT_POST,'name'),
						'price' => filter_input(INPUT_POST, 'price'),
						'quantity' => filter_input(INPUT_POST,'quantity')
					);
			}
			
			else { 
				for ($i=0;$i<count($product_ids);$i++) {
					if ($product_ids[$i] == filter_input(INPUT_GET, 'id')) {
						
						$_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST,'quantity');
					}
				}
			}
		}
		else { 
				$_SESSION['shopping_cart'][0] = array
					(
						'id' => filter_input(INPUT_GET,'id'),
						'name' => filter_input(INPUT_POST,'name'),
						'price' => filter_input(INPUT_POST, 'price'),
						'quantity' => filter_input(INPUT_POST,'quantity')
					);
			
		}
	}
	
	if (filter_input(INPUT_GET,'action') == 'delete') {
		
		foreach($_SESSION['shopping_cart'] as $key => $product) {
			if ($product['id'] == filter_input(INPUT_GET,'id')){
				
				unset($_SESSION['shopping_cart'][$key]);
			}
		}
		
		$_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
	}
	
	
	function pre_r($array){
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
?>

<!DOCTYPE html>
<html>
	<head> 
		<title> Cos de cumparaturi </title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<link rel="stylesheet" href="Cart.css" />
	</head>
	<body>
		<div class="container">
		<?php


		$connect = mysqli_connect('localhost','root','','Cart');
		$query = 'SELECT * FROM products ORDER BY id ASC';
		$result = mysqli_query($connect,$query);
		
		if ($result) {
			if (mysqli_num_rows($result)>0){
				while ($product = mysqli_fetch_assoc($result)){
					
		?>
		<div class="col-sm-4 col-md-3">
			<form method="post" action="Cart.php?action=add&id=<?php echo $product['id']; ?>">
				<div class="products">
					<img src="<?php echo $product['image']; ?>" class="img-responsive" />
					<h4 class="text-danger"> <?php echo $product['name']; ?></h4>
					<h4>$ <?php echo $product['price']; ?></h4>
					<input type="text" name="quantity" class="form-control" value="1" />
					<input type="hidden" name="name" value="<?php echo $product['name']; ?>" />
					<input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
					<input type="submit" name="add_to_cart" style="margin-top:8px;" class="btn btn-info" value="Add to Cart" />
				</div>
			</form>
		</div>
		<?php
				}
			}
			
		}
		?>
		<div style="clear:both"></div>
		<br />
		<div class="table-responsive">
		<table class="table">
			<tr><th colspan="5"><h3>Detalii Comanda</h3></th></tr>
			<tr>
				<th width="40%"> Nume Produs </th>
				<th width="10%"> Cantitate </th>
				<th width="20%"> Pret </th>
				<th width="15%"> Total </th>
				<th width="5%" > Actiune </th>
			</tr>
		<?php 
			if (!empty($_SESSION['shopping_cart'])):
			
				$total=0;
				foreach($_SESSION['shopping_cart'] as $key => $product):
		?>
		<tr> 
			<td> <?php echo $product['name']; ?> </td>
			<td> <?php echo $product['quantity']; ?> </td>
			<td> <?php echo $product['price']; ?> </td>
			<td> <?php echo number_format($product['quantity'] *$product['price']);?>$ </td>
			<td>
				<a href="cart.php?action=delete&id=<?php echo $product['id'] ?>">
					<div class="btn-danger"> REMOVE </div>
			</td>
		</tr>
		<?php 
				$total = $total + ($product['quantity'] * $product['price']);
				endforeach;
		?>
		<tr> 
			<td colspan="3" align="right"> Total </td>
			<td align="right"> $ <?php echo number_format($total,2); ?> </td>
			<td></td>
		</tr>
		<tr> 
            
			<td colspan="5">
			<?php 
				if (isset($_SESSION['shopping_cart'])):
				if(count($_SESSION['shopping_cart'])>0):
			?>
				<a href="#" class="button"> Checkout </a>
				
			<?php endif; endif; ?>
			</td>
			<td colspan="5" > 
			<a href="miercuri.php" class="button"> Miercuri </>
			
			
		</tr>
		<?php
			endif;
		?>
		</table>
		</div>
		</div>
	</body>
</html>
