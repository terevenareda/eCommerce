<!DOCTYPE php>
<?php
include("../controllers/DBController.php");
session_start();
//if ($_SERVER ["REQUEST_METHOD"] == "POST"){
	if (isset($_POST['add_to_cart'])) {
		if (isset($_SESSION['userID'])){
			$user_id = $_SESSION['userID'];
		}
		else {
			header('location: login.php');
		}
		$product_id = $_GET['product'];
		// $product_title = $_POST['title'];
		// $product_final_price = $_POST['final_price'];
		$product_quantity = $_POST['amount'] ?? 1;
		$db = new DBController();
		$db->openConnection();
		$stmt_pro = $db->connection->prepare("SELECT * FROM product WHERE id = ?");
		$stmt_pro->bind_param('i', $product_id);
		$stmt_pro->execute();
		$result_pro = $stmt_pro->get_result();
	
		$stmt = $db->connection->prepare("SELECT * FROM cart_item WHERE user_id = ? AND product_id = ?");
		$stmt->bind_param('ii', $user_id, $product_id);
		$stmt->execute();
		$result = $stmt->get_result();
	
		if ($result->num_rows > 0) {
			// Update the quantity of the existing cart item
			$row = $result->fetch_assoc();
			$quantity = $row['quantity'] + $product_quantity;
			$cart_id = $row['id'];
			// Prepare an UPDATE statement to update the cart item quantity
			$stmt_cart = "UPDATE cart_item SET quantity = $quantity WHERE id = $cart_id";
	
		}
		if ($result->num_rows == 0) {
			$row = $result_pro->fetch_assoc();
			$product_title = $row['title'];
			$product_final_price = $row['final_price'];
			// Insert a new cart item with the specified quantity
			if (isset($_SESSION['userID'])){
				$user_id = $_SESSION['userID'];
			}
			else{
				$user_id =7;
			}
			$stmt_cart = "INSERT INTO cart_item (product_id, user_id, title, price, quantity) SELECT id,'$user_id', title, final_price,$product_quantity  FROM product WHERE id =  $product_id";
	
		}
	
		$db->runQuery($stmt_cart);
		if (isset($_SESSION['userID'])){
			$user_id = $_SESSION['userID'];
		}
		else{
			$user_id =7;
		}
		// Display an alert message to confirm that the item was added to the cart and redirect to the cart page
		echo "<script>
		alert('item added to cart');
		window.location.href='cart.php?user='$user_id'&product=$product_id';
		</script>
	";
	}
if (isset($_POST['add_to_wishlist'])) {
	if (isset($_SESSION['userID'])){
		$user_id = $_SESSION['userID'];
	}
	else {
		header('location: login.php');
	}
		$product_id = $_GET['product'];
		$db = new DBController();
		$db->openConnection();
		
		$sql = "INSERT INTO wish_list (`user_id`, `product_id`,`date`) VALUES ('$user_id', '$product_id',now())";
		try {
			$result = $db->insert($sql);
			if (isset($_SESSION['userID'])){
				$user_id = $_SESSION['userID'];
			}
			else{
				$user_id =7;
			}
			if ($result) {
				echo "<script>
				alert('item added to wishlist');
				window.location.href='wish_list.php?user_id='$user_id'&product=$product_id';
				</script>
	";
			}
		} catch (mysqli_sql_exception $e) {
			if (isset($_SESSION['userID'])){
				$user_id = $_SESSION['userID'];
			}
			else{
				$user_id =7;
			}
			if ($e->getCode() == 1062) { // Duplicate entry error code
				echo "<script>
				alert('item already exists in wishlist');
				window.location.href='wish_list.php?user_id='$user_id'&product=$product_id';
				</script>";
			} else {
				echo "<script>
				alert('error adding item to wishlist');
				window.location.href='index.php';
				</script>";
			}
		}
	}

$product_id = $_GET['product'];
$db = new DBController;
$db->openConnection();
$sql_query = "SELECT * FROM product INNER JOIN product_images ON product.id = product_images.product_id where product_id='$product_id';";
$db->select($sql_query);
$result_pro = $db->runQuery($sql_query);
if ($result_pro->num_rows > 0) {
	while ($row = $result_pro->fetch_assoc()) {
		$product_id = $row["id"];
		$title = $row["title"];
		$price = $row["price"];
		$description = $row["description"];
		$amount = $row["amount"];
		$barcode = $row["barcode"];
		$category_id = $row["category_id"];
		$details = $row["details"];
		$sale = $row['sale'];
		$final_price = $row['final_price'];

		$image1 = $row["image1"];
		$image2 = $row["image2"];
		$image3 = $row["image3"];
	}
}







?>


<php lang="en">

	<head>

		<!-- Basic Page Needs
  ================================================== -->
		<meta charset="utf-8">
		<title>Aviato | E-commerce template</title>

		<!-- Mobile Specific Metas
  ================================================== -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Construction php5 Template">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
		<meta name="author" content="Themefisher">
		<meta name="generator" content="Themefisher Constra php Template v1.0">

		<!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

		<!-- Themefisher Icon font -->
		<link rel="stylesheet" href="plugins/themefisher-font/style.css">
		<!-- bootstrap.min css -->
		<link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">

		<!-- Animate css -->
		<link rel="stylesheet" href="plugins/animate/animate.css">
		<!-- Slick Carousel -->
		<link rel="stylesheet" href="plugins/slick/slick.css">
		<link rel="stylesheet" href="plugins/slick/slick-theme.css">

		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="css/style.css">

	</head>

	<body id="body">
		<!-- Start Top Header Bar -->
		<section class="top-header">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-xs-12 col-sm-4">
						<div class="contact-number">
							<i class="tf-ion-ios-telephone"></i>
							<span>0129- 12323-123123</span>
							<br>
							<div>
			<?php
				if (isset($_SESSION['userID'])){
					?> <a href="logout.php" class="btn btn-main btn-medium btn-round">Logout</a> <?php
				}
				else {
					?> <a href="login.php" class="btn btn-main btn-medium btn-round">Login</a> <?php
				}
			?>
			</div>
						</div>
					</div>
					
					<div class="col-md-4 col-xs-12 col-sm-4">
						<!-- Site Logo -->
						<div class="logo text-center">
							<a href="index.php">
								<!-- replace logo here -->
								<svg width="135px" height="29px" viewBox="0 0 155 29" version="1.1"
									xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
									<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
										font-size="40" font-family="AustinBold, Austin" font-weight="bold">
										<g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
											<text id="AVIATO">
												<tspan x="108.94" y="325">AVIATO</tspan>
											</text>
										</g>
									</g>
								</svg>
							</a>
						</div>
					</div>
					
					<div class="col-md-4 col-xs-12 col-sm-4">
						<!-- Cart -->
					<ul class="top-menu text-right list-inline">
						<li class="dropdown cart-nav dropdown-slide">
							<a href="add-product.php" class="dropdown-toggle">Sell</a>
						</li>
						<li class="dropdown cart-nav dropdown-slide">
							<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i
									class="tf-ion-android-cart"></i>Cart</a>
							<div class="dropdown-menu cart-dropdown">
								<!-- Cart Item -->
								<?php
								$total = 0;
								$db = new DBController;
								$db->openConnection();
								if (isset($_SESSION['userID'])){
									$user_id = $_SESSION['userID'];
								}
								else{
									$user_id =7;
								}
								$select_query = "SELECT product_id FROM cart_item WHERE user_id = $user_id";
								$db->select($select_query);
								$result_cart = $db->runQuery($select_query);
								while ($result_cart_row = mysqli_fetch_assoc($result_cart)) {
									$product_id = $result_cart_row['product_id'];
									$select_query = "SELECT product.*, cart_item.quantity,product_images.image1 from product left join cart_item on product.id = cart_item.product_id and cart_item.user_id = $user_id left join product_images on product.id = product_images.product_id where product.id = $product_id";
									$db->select($select_query);
									$result_pro = $db->runQuery($select_query);
									while ($row = mysqli_fetch_assoc($result_pro)) {
										$product_quantity = $row['quantity'];
										$product_image = $row['image1'];
										$product_id = $row['id'];
										$product_title = $row['title'];
										$product_desc = $row['description'];

										$product_category_id = $row['category_id'];
										$product_bar = $row['barcode'];
										$product_sale = $row['sale'];
										$product_details = $row['details'];
										// $product_image = $row['image1'];
										$product_final_price = $row['final_price'];
										$total = $total + ($product_final_price * $product_quantity);
										?>
										<div class="media">
											<form action="cart.php" method="POST">
												<a class="pull-left" href="#!">
													<img style="height: 40px; width: 40px;"
														src="./product_images/<?php echo "$product_image" ?> " alt="image" />
												</a>
												<div class="media-body">
													<h4 class="media-heading"><a href='product-single.php?product=<?php echo $product_id ?> '>
															<?php echo "$product_title" ?>
														</a></h4>

													<div class="cart-price">
														<p class="price">
															<?php echo "$product_final_price" ?> $
														</p>
														<p class="price">
															<?php echo " quantity : $product_quantity" ?>


														</p>
													</div>
												</div>

												</button>
											</form>
										</div>
										<?php
									}
								}
								?>

								<div class="cart-summary">
									<span>Total</span>
									<span class="total-price">
										<?php echo $total ?> $
									</span>
								</div>
								
								<ul class="text-center cart-buttons">
									<?php 
									if (isset($_SESSION['userID'])){
										$user_id = $_SESSION['userID'];
									}
									else{
										$user_id =7;
									}
									?>
									<li><a href="cart.php?user=<?php echo "$user_id"?>&product=<?php echo $product_id ?>"
											class="btn btn-small">View Cart</a></li>
								</ul>
							</div>

						</li><!-- / Cart -->



								<!-- Search -->
						<li class="dropdown search dropdown-slide">
							<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i
									class="tf-ion-ios-search-strong"></i> Search</a>
							<ul class="dropdown-menu search-dropdown">
								<li>
									<form action="search.php" method="get">
										<input type="text" name="search_query">
										<input type="submit" value="Search">
									</form>
								</li>
							</ul>
						</li><!-- / Search -->



						</ul><!-- / .nav .navbar-nav .navbar-right -->
					</div>
				</div>
			</div>
		</section><!-- End Top Header Bar -->


		<!-- Main Menu Section -->
		<section class="menu">
			<nav class="navbar navigation">
				<div class="container">
					<div class="navbar-header">
						<h2 class="menu-title">Main Menu</h2>
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
							data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

					</div><!-- / .navbar-header -->

					<!-- Navbar Links -->
					<div id="navbar" class="navbar-collapse collapse text-center">
						<ul class="nav navbar-nav">

							<!-- Home -->
							<li class="dropdown ">
								<a href="index.php">Home</a>
							</li><!-- / Home -->


							<!-- Elements -->
							<li class="dropdown dropdown-slide">
								<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
									data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Shop <span
										class="tf-ion-ios-arrow-down"></span></a>
								<div class="dropdown-menu">
									<div class="row">

										<!-- Basic -->
										<div class="col-lg-12 col-md-12 mb-sm-3">
											<ul>
												<li role="separator" class="divider"></li>
												<li><a href="cart.php">Cart</a></li>
												<?php 
												if (isset($_SESSION['userID'])){
													$user_id = $_SESSION['userID'];
												}
												else{
													$user_id =7;
												}
												?>
												<li><a href="wish_list.php?user_id=<?php echo "$user_id"?>&product=<?php echo $product_id ?>">Wish
														List</a></li>
												<li><a href="watch_list.php">Watch List</a></li>

											</ul>
										</div>

									</div><!-- / .row -->
								</div><!-- / .dropdown-menu -->
							</li><!-- / Elements -->



						</ul><!-- / .nav .navbar-nav -->

					</div>
					<!--/.navbar-collapse -->
				</div><!-- / .container -->
			</nav>
		</section>
		<section class="single-product">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<ol class="breadcrumb">
							<li><a href="index.php">Home</a></li>
							<li><a href="shop.php">Shop</a></li>
							<li class="active">Single Product</li>
						</ol>
					</div>
					<div class="col-md-6">
						<!-- <ol class="product-pagination text-right">
							<li><a href="blog-left-sidebar.php"><i class="tf-ion-ios-arrow-left"></i> Next </a></li>
							<li><a href="blog-left-sidebar.php">Preview <i class="tf-ion-ios-arrow-right"></i></a></li>
						</ol> -->
					</div>
				</div>
				<div class="row mt-20">
					<div class="col-md-5">
						<div class="single-product-slider">
							<div id='carousel-custom' class='carousel slide' data-ride='carousel'>
								<div class='carousel-outer'>
									<!-- me art lab slider -->
									<div class='carousel-inner '>
										<div class='item active'>
											<img src='./product_images/<?php echo $image1; ?>' alt='test'
												data-zoom-image="images/shop/single-products/product-1.jpg" />
										</div>
										<div class='item'>
											<img src='./product_images/<?php echo $image2; ?>' alt=''
												data-zoom-image="images/shop/single-products/product-2.jpg" />
										</div>

										<div class='item'>
											<img src='./product_images/<?php echo $image3; ?>' alt=''
												data-zoom-image="images/shop/single-products/product-3.jpg" />
										</div>


									</div>

									<!-- sag sol -->
									<a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
										<i class="tf-ion-ios-arrow-left"></i>
									</a>
									<a class='right carousel-control' href='#carousel-custom' data-slide='next'>
										<i class="tf-ion-ios-arrow-right"></i>
									</a>
								</div>

								<!-- thumb -->
								<ol class='carousel-indicators mCustomScrollbar meartlab'>
									<li data-target='#carousel-custom' data-slide-to='0' class='active'>
										<img src='./product_images/<?php echo $image1; ?>' alt='' />
									</li>
									<li data-target='#carousel-custom' data-slide-to='1'>
										<img src='./product_images/<?php echo $image2; ?>' alt='' />
									</li>
									<li data-target='#carousel-custom' data-slide-to='2'>
										<img src='./product_images/<?php echo $image3; ?>' alt='' />
									</li>

								</ol>
							</div>
						</div>
					</div>

					<div class="col-md-7">
						<div class="single-product-details">
							<h2>
								<?php

								echo $title;
								?>

							</h2>
							<p class="product-price">$
								<?php
								echo $final_price;
								?>
							</p>
							<p class="product-price" style="color:red; text-decoration:line-through;">
								<?php
								if ($price !== $final_price) {
									echo '$' . $price;
								}
								?>
							</p>

							<p class="product-description mt-20">
								<?php
								echo $description;
								?>
							</p>
							<?php
							if ($category_id == 1) {
								echo '<div class="product-size">
								<span>Size:</span>
								<select class="form-control">
								<option>S</option>
								<option>M</option>
								<option>L</option>
								<option>XL</option>
								</select>
							</div>';
							} ?>
							<!-- <div class="product-quantity">
								<span>Quantity:</span>
								<div class="product-quantity-slider">
									<input type="number" class="form-control" id="user_post_code" name="amount" value="<?php echo $quantity; ?>"
										min="0" max="<?php echo $amount; ?>">
								</div> 


							</div>-->
							<div class="product-category">
								<span>Left:</span>
								<ul>
									<li>
										<?php
										echo $amount;
										?>
										</p>
									</li>
								</ul>
							</div>
							<div class="product-category">
								<span>Categories:</span>


								<ul>
									<?php

									$db = new DBController;
									$db->openConnection();
									$sql_query_cat = "SELECT * FROM category WHERE id=$category_id";
									$db->select($sql_query_cat);
									$resultcat = $db->runQuery($sql_query_cat);

									if ($resultcat->num_rows > 0) {
										while ($row = $resultcat->fetch_assoc()) {

											?>
											<li><a href="shop-sidebar.php?category=<?php echo $category_id; ?>">
													<?php
													echo $row["title"];
										}
									}
									?>
										</a></li>
								</ul>
							</div>
							<div class="product-category">
								<span>Barcode:</span>
								<ul>
									<li>
										<?php

										echo $barcode;
										?>
										</p>
									</li>
								</ul>
							</div>
							<?php
							echo "
<form method='post' action=''>
<button type='submit' style='height:53px; width:150px; color: white; background-color: black; border: none; float: left;' name='add_to_cart' class='btn btn-main mt-20''>Add To Cart</button>


    <button style='height:53px; width:150px; color: white; background-color: black; border: none; display: flex; justify-content: center; align-items: center; float: left; margin-left: 10px;' name='add_to_wishlist' class='btn btn-main mt-20 data-product-id=$product_id'>
	Add to wishlist
	</button>
	
</form>
";
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="tabCommon mt-20">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#details"
											aria-expanded="true">Details</a></li>
									<li class=""><a data-toggle="tab" href="#reviews" aria-expanded="false">Reviews
											</a></li>
								</ul>
								<div class="tab-content patternbg">
									<div id="details" class="tab-pane fade active in">
										<h4>Product Description</h4>
										<?php
										echo $details;

										?>
									</div>
									<div id="reviews" class="tab-pane fade">
										<?php
										// Set the product ID to search for 
										//$product_id = $_POST['product_id'];
										$db=new DBController;
										$db->openConnection();
										$sql_query = "SELECT feedback.*, user.first_name, user.last_name  
              FROM feedback  
              INNER JOIN user ON feedback.user_id = user.id  
              WHERE feedback.product_id = ?";
										$stmt = $db->connection->prepare($sql_query);
										$stmt->bind_param("i", $product_id);
										$stmt->execute();
										$result = $stmt->get_result();

										// Loop through the result set and output the feedback data 
										if ($result->num_rows > 0) {
											while ($row = $result->fetch_assoc()) {
												?>
												<div class="post-comments">
													<ul class="media-list comments-list m-bot-50 clearlist">
														<!-- Comment Item start-->
														<li class="media">
															<div class="media-body">
																<div class="comment-info">
																	<h4 class="comment-author">
																		<a>
																			<?php echo $row["first_name"] . " " . $row["last_name"]; ?>
																		</a>
																	</h4>
																	<time datetime="<?php echo $row["date"]; ?>">
																		<?php echo $row["date"]; ?>
																	</time>
																</div>
																<p>
																	<?php echo $row["feedback"]; ?>
																</p>
															</div>
														</li>
													</ul>

												<?php
											}
										} else {
											echo "No feedback found for this product ID ";
										}


										?>en
										</div>
										<style>
											.feedback-form {
												max-width: 500px;
												margin: 0 auto;
												padding: 20px;
												border: 2px solid #ddd;
												border-radius: 5px;
											}

											.input-container {
												position: relative;
												margin-bottom: 10px;
											}

											.input-container input[type="text"] {
												width: 100%;
												padding: 10px;
												border: 1px solid #ddd;
												border-radius: 20px;
												font-size: 16px;
											}

											.input-container label {
												position: absolute;
												top: 10px;
												left: 20px;
												font-size: 16px;
												color: #999;
												transition: all 0.3s ease;
												pointer-events: none;
											}

											.input-container input[type="text"]:focus+label,
											.input-container input[type="text"]:valid+label {
												top: -10px;
												left: 10px;
												font-size: 12px;
												color: #444;
											}

											.btn-main {
												background-color: black;
												color: white;
												border: none;
												border-radius: 3px;
												padding: 10px 20px;
												font-size: 16px;
												cursor: pointer;
												float: left;
												transition: background-color 0.3s ease;
											}

											.btn-main:hover {
												background-color: #333;
											}
										</style>
										<?php
										if (isset($_POST['submit_feedback'])) {
											// Get the form data 
											$db=new DBController;
											$db->openConnection();
											$user_id = $_POST['user_id'];
											$product_id = $_POST['product_id'];
											$comments = $_POST['comments'];
											$date = date('Y-m-d H:i:s');
											if (isset($_SESSION['userID'])){
												$user_id = $_SESSION['userID'];
											}
											else {
												header('location: login.php');
											}
											// Insert the feedback into the database 
											// Insert the feedback into the database 
											$stmt = $db->connection->prepare("INSERT INTO feedback (user_id, product_id, date, feedback) VALUES ('$user_id', ?,now(), ?)");
											$stmt->bind_param("is", $product_id, $comments);
											$stmt->execute();

											// Reload the current page to show the updated feedback data 
											echo "<meta http-equiv='refresh' content='0'>";

											// Redirect to the current page to prevent resubmission on refresh 
											header("Location: " . $_SERVER['REQUEST_URI']);
											exit();
										}
										?>
										<li>
											<div class="feedback-form">
												<form method="post">
													<div class="input-container">
														<input type="text" id="comments" name="comments" required>
														<label for="comments">Comments</label>
													</div>
													<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
													<input type="hidden" name="product_id"
														value="<?php echo $product_id; ?>">
													<button type="submit" name="submit_feedback"
														class="btn btn-main mt-20">Submit Feedback</button>
												</form>
											</div>
										</li>
									</div>
									</ul>
								</div>


							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</section>




		<!-- Modal -->
		<div class="modal product-modal fade" id="product-modal">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i class="tf-ion-close"></i>
			</button>
			<div class="modal-dialog " role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-8">
								<div class="modal-image">
									<img class="img-responsive" src="images/shop/products/modal-product.jpg" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="product-short-details">
									<h2 class="product-title">GM Pendant, Basalt Grey</h2>
									<p class="product-price">$200</p>
									<p class="product-short-description">
										Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem iusto nihil cum.
										Illo laborum numquam rem aut officia dicta cumque.
									</p>
									<a href="#!" class="btn btn-main">Add To Cart</a>
									<a href="#!" class="btn btn-transparent">View Product Details</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="footer section text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<ul class="social-media">
							<li>
								<a href="https://www.facebook.com/themefisher">
									<i class="tf-ion-social-facebook"></i>
								</a>
							</li>
							<li>
								<a href="https://www.instagram.com/themefisher">
									<i class="tf-ion-social-instagram"></i>
								</a>
							</li>
							<li>
								<a href="https://www.twitter.com/themefisher">
									<i class="tf-ion-social-twitter"></i>
								</a>
							</li>
							<li>
								<a href="https://www.pinterest.com/themefisher/">
									<i class="tf-ion-social-pinterest"></i>
								</a>
							</li>
						</ul>
						<ul class="footer-menu text-uppercase">
							<li>
								<a href="contact.php">CONTACT</a>
							</li>
							<li>
								<a href="shop.php">SHOP</a>
							</li>
							<li>
								<a href="pricing.php">Pricing</a>
							</li>
							<li>
								<a href="contact.php">PRIVACY POLICY</a>
							</li>
						</ul>
						<p class="copyright-text">Copyright &copy;2021, Designed &amp; Developed by <a
								href="https://themefisher.com/">Themefisher</a></p>
					</div>
				</div>
			</div>
		</footer>
		<!-- 
	Essential Scripts
	=====================================-->

		<!-- Main jQuery -->
		<script src="plugins/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.1 -->
		<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
		<!-- Bootstrap Touchpin -->
		<script src="plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
		<!-- Instagram Feed Js -->
		<script src="plugins/instafeed/instafeed.min.js"></script>
		<!-- Video Lightbox Plugin -->
		<script src="plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
		<!-- Count Down Js -->
		<script src="plugins/syo-timer/build/jquery.syotimer.min.js"></script>

		<!-- slick Carousel -->
		<script src="plugins/slick/slick.min.js"></script>
		<script src="plugins/slick/slick-animation.min.js"></script>

		<!-- Google Mapl -->
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
		<script type="text/javascript" src="plugins/google-map/gmap.js"></script>

		<!-- Main Js File -->
		<script src="js/script.js"></script>



	</body>
</php>