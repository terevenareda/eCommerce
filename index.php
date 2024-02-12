<?php
require_once '../Controllers/DBController.php';

session_start();

if (isset($_SESSION['userID'])){
	
	$user_id = $_SESSION['userID'];
}


$query_cat = "select * from category";
$db = new DBController;
$db->openConnection();
$result_cat = $db->runQuery($query_cat);


// Redirect back to the previous page
if (isset($_POST['add_to_cart'])) {

	if (isset($_SESSION['userID'])){
		$user_id = $_SESSION['userID'];
	}

	else {
		$user_id = 7;
	}

	$product_id = $_POST['product_id'];
	// $product_title = $_POST['title'];
	// $product_final_price = $_POST['final_price'];
	$product_quantity = $_POST['quantity'] ?? 1;
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
		$stmt_cart = "INSERT INTO cart_item (product_id, user_id, title, price, quantity) SELECT id,'$user_id', title, final_price, 1 FROM product WHERE id =  $product_id";

	}

	$db->runQuery($stmt_cart);

	// Display an alert message to confirm that the item was added to the cart and redirect to the cart page
	echo "<script>
	alert('item added to cart');
	window.location.href='cart.php?user=$user_id&product=$product_id';
	</script>
";
}


if (isset($_POST['add_to_wishlist'])) {
	if (isset($_SESSION['userID'])){
		$user_id = $_SESSION['userID'];
	}

	else {
		$user_id = 7;
	}
	$product_id = $_POST['product_id'];
	$db = new DBController();
	$db->openConnection();
	$sql = "INSERT INTO wish_list (`user_id`, `product_id`,`date`) VALUES ('$user_id', '$product_id',now())";
	try {
		$result = $db->insert($sql);
		if ($result) {
			echo "<script>
			alert('item added to wishlist');
			window.location.href='wish_list.php?user_id=$user_id&product=$product_id';
			</script>
";
		}
	} catch (mysqli_sql_exception $e) {
		if ($e->getCode() == 1062) { // Duplicate entry error code
			echo "<script>
			alert('item already exists in wishlist');
			window.location.href='wish_list.php?user_id=$user_id&product=$product_id';
			</script>";
		} else {
			echo "<script>
			alert('error adding item to wishlist');
			window.location.href='index.php';
			</script>";
		}
	}
}

?>
<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en">

<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>Aviato | E-commerce template</title>

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Construction Html5 Template">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
	<meta name="author" content="Themefisher">
	<meta name="generator" content="Themefisher Constra HTML Template v1.0">

	<!-- theme meta -->
	<meta name="theme-name" content="aviato" />

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

								else {
									$user_id = 7;
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
													<h4 class="media-heading"><a href="product-single.html">
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
									<li><a href="cart.php?user=<?php echo $user_id ?>&product=<?php echo $product_id ?>"
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

						<!-- Languages -->
						<li class="commonSelect">
							<select class="form-control">
								<option>EN</option>
								<option>DE</option>
								<option>FR</option>
								<option>ES</option>
							</select>
						</li><!-- / Languages -->

					</ul><!-- / .nav .navbar-nav .navbar-right -->
				</div>
			</div>
			<div>

			</div>

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
		
	</section><!-- End Top Header Bar -->


	<!-- Main Menu Section -->
	<section class="menu">
		<nav class="navbar navigation">
			<div class="container">
				<div class="navbar-header">
					<h2 class="menu-title">Main Menu</h2>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
						aria-expanded="false" aria-controls="navbar">
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
						
						<li class="dropdown ">
							<a href="shop-sidebar.php">shop</a>
						</li><!-- / Home -->


						<!-- Pages -->
						<li class="dropdown full-width dropdown-slide">
							<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
								data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Pages <span
									class="tf-ion-ios-arrow-down"></span></a>
							<div class="dropdown-menu">
								<div class="row">
									<!-- Contact -->
									<div class="col-sm-3 col-xs-12">
										<ul>

											<li><a href="order.php">Orders</a></li>

										</ul>
									</div>
								</div><!-- / .row -->
							</div><!-- / .dropdown-menu -->
						</li><!-- / Pages -->



						

				</div>
				<!--/.navbar-collapse -->
			</div><!-- / .container -->
		</nav>
	</section>

	<div class="hero-slider">
		<div class="slider-item th-fullpage hero-area" style="background-image: url(images/slider/slider-1.jpg);">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 text-center">
						<p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
						<h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature
							<br> is hidden in details.
						</h1>
						<a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn"
							href="shop-sidebar.php">Shop Now</a>
					</div>
				</div>
			</div>
		</div>
		<div class="slider-item th-fullpage hero-area" style="background-image: url(images/slider/slider-3.jpg);">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 text-left">
						<p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
						<h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature
							<br> is hidden in details.
						</h1>
						<a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn"
							href="shop-sidebar.php">Shop Now</a>
					</div>
				</div>
			</div>
		</div>
		<div class="slider-item th-fullpage hero-area" style="background-image: url(images/slider/slider-2.jpg);">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 text-right">
						<p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
						<h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">The beauty of nature
							<br> is hidden in details.
						</h1>
						<a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn"
							href="shop-sidebar.php">Shop Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="product-category section">
		<form method="post">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="title text-center">
							<h2>Product Category</h2>
						</div>
					</div>
					<?php
					while ($row = mysqli_fetch_assoc($result_cat)) {
						$image_filename = $row["image"];
						$image_path = './categoryImages/' . $image_filename;
						?>
						<div class="col-md-6">
							<div class="category-box">
								<a href="shop-sidebar.php?category=<?php echo $row["id"]; ?>">
									<img src="<?php print($image_path) ?>" alt="Not working" />
									<div value="<?php echo $row["id"]; ?>" class="content">
										<h3>
											<?php echo $row["title"]; ?>
										</h3>
									</div>
								</a>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</form>
	</section>
	<section class="products section bg-gray">
		<div class="container">
			<div class="row">
				<div class="title text-center">
					<h2>Trendy Products</h2>
				</div>

				<?php
				$db = new DBController;
				$db->openConnection();
				$select_query = "SELECT product.*, product_images.image1 FROM product JOIN product_images ON product.id = product_images.product_id order by rand() limit 0,6;";
				$db->select($select_query);
				$result_pro = $db->runQuery($select_query);
				//$row=mysqli_fetch_assoc($result_query);
				//echo $row['title'];
				while ($row = mysqli_fetch_assoc($result_pro)) {
					$product_id = $row['id'];
					$product_title = $row['title'];
					$product_desc = $row['description'];
					$product_price = $row['price'];
					$product_category_id = $row['category_id'];
					$product_bar = $row['barcode'];
					$product_sale = $row['sale'];
					$product_amount = $row['amount'];
					$product_details = $row['details'];
					$product_image = $row['image1'];
					$product_final_price = $row['final_price'];

					echo "
									<div class='col-md-4 mb-2'>
									<div class='product-item'>
										<div class='product-thumb'>
										<form action='' method='post'>";
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
														
														
														<a href='product-single.php?product=$product_id'><i class='tf-ion-ios-search-strong'></i></a>
														
													</li>
													<li>
													
													<input type='hidden' name='product_id' value='$product_id'>
													
													<button style='height:53px; width:50px; color: black;' name='add_to_wishlist' >
													   <i class='tf-ion-ios-heart'></i></button>
													</li>
													<li>
														<button type='submit' style='height:53px; width:50px; color: black;'
															name='add_to_cart' class='tf-ion-android-cart'></button>
													</li>
													
												</ul>
											</div>
										</div>
										<div class='product-content'>
										
											<h4 name='title'><a href='product-single.php?product=$product_id'>
												$product_title</a></h4>
											<p name='final_price' class='price'>$ $product_final_price
											</p>
										</div>
										</div>
								</form>
								</div>
			";
				}
				?>

			</div>


			<!-- Modal -->

		</div>
		</div>
	</section>


	<!--
Start Call To Action
==================================== -->
	<section class="call-to-action bg-gray section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="title">
						<h2>SUBSCRIBE TO NEWSLETTER</h2>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat, <br> facilis numquam
							impedit ut sequi. Minus facilis vitae excepturi sit laboriosam.</p>
					</div>
					<div class="col-lg-6 col-md-offset-3">
						<div class="input-group subscription-form">
							<input type="text" class="form-control" placeholder="Enter Your Email Address">
							<span class="input-group-btn">
								<button class="btn btn-main" type="button">Subscribe Now!</button>
							</span>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->

				</div>
			</div> <!-- End row -->
		</div> <!-- End container -->
	</section> <!-- End section -->

	<section class="section instagram-feed">
		<div class="container">
			<div class="row">
				<div class="title">
					<h2>View us on instagram</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="instagram-slider" id="instafeed"
						data-accessToken="IGQVJYeUk4YWNIY1h4OWZANeS1wRHZARdjJ5QmdueXN2RFR6NF9iYUtfcGp1NmpxZA3RTbnU1MXpDNVBHTzZAMOFlxcGlkVHBKdjhqSnUybERhNWdQSE5hVmtXT013MEhOQVJJRGJBRURn">
					</div>
				</div>
			</div>
		</div>
	</section>


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
							<a href="contact.html">CONTACT</a>
						</li>
						<li>
							<a href="shop.html">SHOP</a>
						</li>
						<li>
							<a href="pricing.html">Pricing</a>
						</li>
						<li>
							<a href="contact.html">PRIVACY POLICY</a>
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

</html>