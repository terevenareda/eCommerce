<?php
require_once('../controllers/DBController.php');
$query_cat = "select * from category";
$categories = $connection->query($query_cat);
function getProductsIndex()
{
	global $connection;
	if (!isset($_GET['category'])) {
		$select_query = "SELECT product.*, product_images.image1 FROM product JOIN product_images ON product.id = product_images.product_id order by rand() limit 0,6;";
		$result_query = mysqli_query($connection, $select_query);
		//$row=mysqli_fetch_assoc($result_query);
		//echo $row['title'];
		while ($row = mysqli_fetch_assoc($result_query)) {
			$product_id = $row['id'];
			$product_title = $row['title'];
			$product_desc = $row['description'];
			$product_price = $row['price'];
			$product_category_id = $row['category_id'];
			$product_bar = $row['barcode'];
			$product_sale = $row['sale'];
			$product_details = $row['details'];
			$product_image = $row['image1'];
			echo "
						<div class='col-md-4 mb-2'>
						<div class='product-item'>
							<div class='product-thumb'>
							<form action='cart.php' method='GET'>
								<img class='img-responsive img-square' style='height: 300px; width: 300px;' src='./product_images/$product_image' alt='$product_title'/>
								<div class='preview-meta'>
									<ul>
										<li>
											<span data-toggle='modal' data-target='#product-modal'>
												<i class='tf-ion-ios-search-strong'></i>
											</span>
										</li>
										<li>
											<a href='#'><i class='tf-ion-ios-heart'></i></a>
										</li>
										<li>
											<input hidden name='product_id' value=''>
											<button type='submit' style='height:53px; width:50px; color: black;'
												name='add_to_cart' class='tf-ion-android-cart'></button>
										</li>
									</ul>
								</div>
							</div>
							<div class='product-content'>
								<h4><a href='product-single.html'>
									$product_title</a></h4>
								<p class='price'>$ $product_price
								</p>
							</div>
							</div>
					</form>
					</div>
";
		}
	}
}

function getProductsShop()
{
	global $connection;
	if (!isset($_GET['category'])) {
		$select_query = "SELECT product.*, product_images.image1 FROM product JOIN product_images ON product.id = product_images.product_id order by rand();";
		$result_query = mysqli_query($connection, $select_query);
		//$row=mysqli_fetch_assoc($result_query);
		//echo $row['title'];
		while ($row = mysqli_fetch_assoc($result_query)) {
			$product_id = $row['id'];
			$product_title = $row['title'];
			$product_desc = $row['description'];
			$product_price = $row['price'];
			$product_category_id = $row['category_id'];
			$product_bar = $row['barcode'];
			$product_sale = $row['sale'];
			$product_details = $row['details'];
			$product_image = $row['image1'];
			$product_final_price=$row['final_price'];
			
			echo "
						<div class='col-md-4 mb-2'>
						<div class='product-item'>
							<div class='product-thumb'>
							<form action='cart.php' method='GET'>";
							if ($product_sale != 0) {
								$product_price = $product_final_price;
								echo "<style>
								.sale-sign {
									position: absolute;
									top: 10px;
									left: 10px;
									background-color: red;
									color: white;
									font-size: 16px;
									padding: 5px;
									border-radius: 5px;
								}
							</style>";
								echo "<div class='sale-sign text-danger'>Sale</div>";
							}
							echo "
								<img class='img-responsive img-square' style='height: 300px; width: 300px;' src='./product_images/$product_image' alt='$product_title'/>
								
								<div class='preview-meta'>
									<ul>
										<li>
											<span data-toggle='modal' data-target='#product-modal'>
												<i class='tf-ion-ios-search-strong'></i>
											</span>
										</li>
										<li>
											<a href='#'><i class='tf-ion-ios-heart'></i></a>
										</li>
										<li>
											<input hidden name='product_id' value=''>
											<button type='submit' style='height:53px; width:50px; color: black;'
												name='add_to_cart' class='tf-ion-android-cart'></button>
										</li>
									</ul>
								</div>
							</div>
							<div class='product-content'>
								<h4><a href='product-single.html'>
									$product_title</a></h4>
								<p class='price'>$ $product_price
								</p>
							</div>
							</div>
					</form>
					</div>
";
		}
	}
}


function getCategory()
{
	global $connection;

	if (isset($_GET['category'])) {
		$category_id = $_GET['category'];
		$select_query = "SELECT * FROM product JOIN product_images ON product.id = product_images.product_id WHERE category_id = $category_id";
		$result_query = mysqli_query($connection, $select_query);
		$num_of_rows= mysqli_num_rows($result_query);
		if($num_of_rows==0){
			echo "<h2 class='text-center'>No products in this category</h2>";
		}
		else{
		//$row=mysqli_fetch_assoc($result_query);
		//echo $row['title'];
		while ($row = mysqli_fetch_assoc($result_query)) {
			$product_id = $row['id'];
			$product_title = $row['title'];
			$product_desc = $row['description'];
			$product_price = $row['final_price'];
			$product_category_id = $row['category_id'];
			$product_bar = $row['barcode'];
			$product_sale = $row['sale'];
			$product_details = $row['details'];
			$product_image = $row['image1'];
			$product_final_price=$row['final_price'];
			echo "
						<div class='col-md-4 mb-2'>
						<div class='product-item'>
							<div class='product-thumb'>
							<form action='cart.php' method='GET'>";
							if ($product_sale != 0) {
								$product_price = $product_final_price;
								echo "<style>
								.sale-sign {
									position: absolute;
									top: 10px;
									left: 10px;
									background-color: red;
									color: white;
									font-size: 16px;
									padding: 5px;
									border-radius: 5px;
								}
							</style>";
								echo "<div class='sale-sign text-danger'>Sale</div>";
							}
							echo"
								<img class='img-responsive img-square' style='height: 300px; width: 300px;' src='./product_images/$product_image' alt='$product_title'/>
								<div class='preview-meta'>
									<ul>
										<li>
											<span data-toggle='modal' data-target='#product-modal'>
												<i class='tf-ion-ios-search-strong'></i>
											</span>
										</li>
										<li>
											<a href='#'><i class='tf-ion-ios-heart'></i></a>
										</li>
										<li>
											<input hidden name='product_id' value=''>
											<button type='submit' style='height:53px; width:50px; color: black;'
												name='add_to_cart' class='tf-ion-android-cart'></button>
										</li>
									</ul>
								</div>
							</div>
							<div class='product-content'>
								<h4><a href='product-single.html'>
									$product_title</a></h4>
								<p class='price'>$ $product_price
								</p>
							</div>
							</div>
					</form>
					</div>
";
		}
	}
}
}



?>