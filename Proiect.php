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
		</div>
		</body>
		</html>