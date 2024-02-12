<?php
require_once '../controllers/DBController.php';
$db = new DBController;
$db->openConnection();
session_start();
$product_id = $_GET['product'];
if (isset($_SESSION['userID'])){
	$user_id = $_SESSION['userID'];
}
else {
	header('location: login.php');
}

$sql_query = "SELECT * FROM cart_item WHERE user_id = $user_id AND product_id = $product_id ";
$stmt = $db->connection->prepare($sql_query);
$stmt->execute();
$result = $stmt->get_result();
if (isset($_POST['remove'])) {
	if (isset($_SESSION['userID'])){
		$user_id = $_SESSION['userID'];
	
	}
else {
		header('location: login.php');
	}
	$product_id = $_POST['product_id'];
	$delete_query = "DELETE FROM cart_item WHERE user_id = $user_id AND product_id = $product_id ";
	$result=$db->delete($delete_query);

	// Update the website to remove the deleted product
	echo "<script>
		alert('item removed from cart');
		
		</script>
";
	echo "
    <script>
        var product = document.getElementById('product-$product_id');
        if (product) {
            product.parentNode.removeChild(product);
        }
        console.log('Product $product_id deleted from cart');
    </script>
";
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
					<a href="index.html">
						<!-- replace logo here -->
						<svg width="135px" height="29px" viewBox="0 0 155 29" version="1.1" xmlns="http://www.w3.org/2000/svg"
							xmlns:xlink="http://www.w3.org/1999/xlink">
							<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" font-size="40"
								font-family="AustinBold, Austin" font-weight="bold">
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
						  $product_price = $row['price'];
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
												<img style="height: 40px; width: 40px;" class="media-object" src="./product_images/<?php echo "$product_image" ?>" alt="image" />
											</a>
											<div class="media-body">
												<h4 class="media-heading"><a href="product-single.html">
														<?php echo "$product_title" ?>
													</a></h4>

												<div class="cart-price">
													<p class="price">
														<?php echo "$product_price" ?> $
													</p>
												</div>
											</div>
											<!-- <input type='hidden' name='product_id' value='$product_id'>
											<button name='remove'style=' margin-left : 200px' class='tf-ion-close'></button> -->
											<!--<a href="#!" name = "remove" class="remove"><i class="tf-ion-close"></i></a> 
											<button name='remove' style=' margin-left : 200px' class='tf-ion-close'>-->
											</button>
										</form>
									</div>
									<?php
								}}
								?>

							<div class="cart-summary">
									<span>Total</span>
									<span class="total-price">
									 <?php echo $total ?> $ 
									</span>
								</div>
							<ul class="text-center cart-buttons">
								<li><a href="cart.php?user=<?php echo $user_id ?>&product=<?php echo $product_id ?>" class="btn btn-small">View Cart</a></li>
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

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Cart</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">cart</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>



<div class="page-wrapper">
  <div class="cart shopping">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="block">
            <div class="product-list">
              <form method="post">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="">Item Name</th>
                      <th class="">Item Price</th>
					  <th class="">quantity</th>
                      <th class="">Actions</th>
                    </tr>
                  </thead>
				<?php
					$total =0;
					$db = new DBController;
					$db->openConnection();
					$select_query = "SELECT product_id FROM cart_item WHERE user_id = $user_id";
					$db->select($select_query);
					$result_cart = $db->runQuery($select_query);
					while ($result_cart_row = mysqli_fetch_assoc($result_cart)) {
						$product_id = $result_cart_row['product_id'];
						$select_query = "SELECT product.*, cart_item.quantity from product left join cart_item on product.id = cart_item.product_id and cart_item.user_id = $user_id where product.id = $product_id";
						$db->select($select_query);
						$result_pro = $db->runQuery($select_query);
						while ($row = mysqli_fetch_assoc($result_pro)) {
							$product_quantity = $row['quantity'];

							$product_id = $row['id'];
							$product_title = $row['title'];
							$product_desc = $row['description'];
							$product_price = $row['price'];
							$product_category_id = $row['category_id'];
							$product_bar = $row['barcode'];
							$product_sale = $row['sale'];
							$product_details = $row['details'];
							// $product_image = $row['image1'];
							$product_final_price = $row['final_price'];
							$total = $total + ($product_final_price * $product_quantity);

							echo "
                  <tbody>
                    <tr class=''>
                      <td class=''>
                        <div class='product-info'>
                          <a href='#!'>$product_title</a>
                        </div>
                      </td>
                      <td class=''>$$product_final_price</td>
					  <td class=''>$product_quantity</td>
					  <form method='post' action=''>
                      <td class=''>
					  <input type='hidden' name='product_id' value='$product_id'>
					  
					  <button name='remove' class='btn btn-sm btn-outline-danger'>REMOVE</button>
                      </td>
					  </form>
                    </tr>
                    
                  </tbody>
				  ";
						}
					}
					?>
					</table>
					<a href='checkout.php' class='btn btn-main pull-right'>Checkout</a>
					</form>
					</div>
					<div class="border bg-light rounded p-4">
						<span style="font-size : 30px; ">Total :</span>
						<span style="font-size : 20px; " class="total-price">
							<?php echo $total ?> $
						</span>
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
				<p class="copyright-text">Copyright &copy;2021, Designed &amp; Developed by <a href="https://themefisher.com/">Themefisher</a></p>
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
