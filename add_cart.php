<?php
	session_start();
    //unset($_SESSION['cart']);
	//check if product is already in the cart
    require_once('includes/config.php');

    if (isset($_GET['send_recover_trans'])) {
    	# code...
    

	if(!in_array($_GET['Batch'], $_SESSION['batch_number'])){
        $_SESSION['checkout_btn'] = 'disabled';
/*        echo "'".$_GET['Batch']."'";
        die();*/
		array_push($_SESSION['cart'], $_GET['id']);
		array_push($_SESSION['current_qty'], $_GET['Quantity']);
		array_push($_SESSION['batch_number'], $_GET['Batch']);
		array_push($_SESSION['batch_number2'], "'".$_GET['Batch']."'");
		array_push($_SESSION['qty_array'], $_GET['served_quantity']);

           $sql       = "SELECT selling_price FROM `purchase_medical_product` WHERE batch_number = '$_GET[Batch]'";

           $sql_price = $conn->query($sql);
           $sql_price = $conn->query($sql);
           $p         = $sql_price->fetch_assoc();
           array_push($_SESSION['selling_price'], $p['selling_price']);
           $sub_total      = $p['selling_price']*$_GET['served_quantity'];
           array_push($_SESSION['sub_total'], $sub_total);

          /* echo implode(',',$_SESSION['qty_array']).'<br>';
           echo implode(',',$_SESSION['selling_price']).'<br>';
           echo implode(',',$_SESSION['sub_total']).'<br>';*/

           //die();
           $get_medecine_name = "SELECT * FROM `medical_product`  INNER JOIN `medical_category` ON 
           medical_product.category = medical_category.category_ID 
           WHERE medical_product.product_ID='$_GET[id]' LIMIT 1 ";
           $pr = $conn->query($get_medecine_name);
           $n = $pr->fetch_assoc();

           array_push($_SESSION['product_Nmae'], $n['product_Nmae']);

		$_SESSION['message'] = '

								<div id="snackbar">'.$_GET['served_quantity'].' '.$n['category_name'].' of '.$n['product_Nmae'].' added </div>

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
	/*unset($_SESSION['cart']);
	unset($_SESSION['batch_number']);
	unset($_SESSION['current_qty']);*/
	header('location: medecine');
}
?>