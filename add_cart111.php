<?php
	session_start();

	//check if product is already in the cart
	if(!in_array($_GET['id'], $_SESSION['cart'])){
		array_push($_SESSION['cart'], $_GET['id']);
		array_push($_SESSION['current_qty'], $_GET['Quantity']);
		$_SESSION['message'] = '

								<div id="snackbar">Product added </div>

								<script>
								//function myFunction() {
								  var x = document.getElementById("snackbar");
								  x.className = "show";
								  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
								//}
								</script>
		';

	}
	else{
		$_SESSION['message'] = '<div class="alert alert-danger">
                                <strong>Product already in cart</strong>
                                </div>';
	}

	header('location: medecine');
?>