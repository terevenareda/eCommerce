<?php
require_once "../Controllers/DBController.php";
require_once "../PHPMailer-6.7.1/src/PHPMailer.php";
require_once "../PHPMailer-6.7.1/src/SMTP.php";


if (!isset($_SESSION['userID'])){
	session_start();
	$userAdmin = $_SESSION['isUserAdmin'];
	$userID = $_SESSION['userID'];
	if ($userAdmin != 1){
		header('location: login.php');
	}
}
else {
	header('location: login.php');
}
$db = new DBController;
$db->openConnection();
$query = "SELECT * FROM the_order";
$result = $db->select($query);

if (isset($_POST['order_id'])){

	$order_id = $_POST['order_id'];

	if (isset($_POST['cancelled'])){
		$status = 'Cancelled';
	}
	else if (isset($_POST['processing'])){
		$status = 'Processing';
	}
	else if (isset($_POST['completed'])){
		$status = 'Completed';
	}
	else {

		$order_id = $_POST['order_id'];
		$status = 'Shipping';

		$user_id = $_POST['user_id'];
		$query = "SELECT email, first_name, last_name FROM user WHERE id = $user_id";
		$user = $db->select($query);
		$email = $user[0]['email'];
		$user_name = $user[0]['first_name'];

		$mail = new PHPMailer\PHPMailer\PHPMailer();

		// Set the SMTP server details
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = 'bassamemad000@gmail.com';
		$mail->Password = 'adtndwvefougrjqy';
		// Set the email subject, body, and recipient
		$mail->Subject = 'Your order is ready!';
		$mail->Body = "Hello $user_name, your order (#$order_id) has been shipped successfully. Please go collect it
		Thank you for using Aviato.";
		$mail->setFrom('bassamemad000@gmail.com', 'Bassam Emad The Owner Of Aviato');
		$mail->addAddress("$email", "$user_name");
		if( $mail->Send() == true ) {
		   echo "Message sent successfully...";
		}else {
		   echo "Message could not be sent...";
		}
	}

	$query = "UPDATE the_order SET status = '$status'  WHERE id = '$order_id' ";
	$db->runQuery($query);
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


<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Dashboard</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">my account</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="user-dashboard page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="list-inline dashboard-menu text-center">
					<li><a class="active" href="admin-order.php">Orders</a></li>
				</ul>
				<div class="dashboard-wrapper user-dashboard">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Order ID</th>
									<th>Full Name</th>
									<th>Buyer</th>
									<th>Status</th>
									<th></th>
									<th></th>


								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($result as $row) {
									$buyer_id = $row['user_id'];
									$query = "SELECT first_name, last_name FROM user WHERE id = $buyer_id";
									$buyer = $db->select($query);
									?>
									<tr>
									<td>#<?php print_r($row['id']); ?></td>
									<td><?php print_r($row['full_name']); ?></td>
									<td><?php print_r($buyer[0]['first_name']); echo "\t"; print_r($buyer[0]['last_name']); ?></td>
									<td><?php print_r($row['status']); ?></td>
									<td><form action="order-items.php" method="POST">
											<input hidden type="text" name = 'order_id' value="<?php print_r($row['id']); ?>">
											<input type="submit" class="btn btn-default" value="View">
										</form>
									</td>
									<td>
								<form action="admin-order.php" method="POST">
											<input hidden type="text" name = 'order_id' value="<?php print_r($row['id']); ?>">
											<input hidden type="text" name = 'user_id' value="<?php print_r($row['user_id']); ?>">
											<div class="dropdown">
												<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Change Order Status
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<input type="submit" class="dropdown-item" value="Change status to Completed" name = 'completed'><br>
													<input type="submit" class="dropdown-item" value="Change status to Processing" name = 'processing'><br>
													<input type="submit" class="dropdown-item" value="Change status to Cancelled" name = 'cancelled'><br>
													<input type="submit" class="dropdown-item" value="Change status to Shipping" name = 'shipping'><br>
													
												</div>
												</div>
									</form>
									</td>

									</tr>

									<?php
								}
								?>
							</tbody>
						</table>
					</div>
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