<?php
	session_start();
    //unset($_SESSION['cart']);
	//check if product is already in the cart
    require_once('includes/config.php');

    if (isset($_GET['send_served_medecine'])) {
    	# code...
        $_SESSION['checkout_btn'] = 'disabled';
    	$medecine_id = $_GET['id'];
    	$current_qty = $_GET['Quantity'];
    	$served_qty	 = $_GET['served_quantity'];
        $price       = $_GET['price'];
    	$batch_nmber = $_GET['Batch'];
    	$branch_ID   		= $_SESSION['branch'];
        $institution_code	= $_SESSION['institution_code'];
        $user				= $_SESSION['user_id'];
        $ser_date 	 = date('Y-m-d');
    	$status      = 0;

        //generate order number....
        $invoice_n = "SELECT TRANSACTION_NUMBER FROM transactions WHERE
        Branch='$_SESSION[branch]' ORDER BY DATE_OF_TRANSACTION DESC LIMIT 1";
        $inv_num   = $conn->query($invoice_n);
        $num =$inv_num->fetch_assoc();

        //check if there is any transaction
        $www = "SELECT COUNT(TRANSACTION_ID) FROM `transactions`";
        $tr   = $conn->query($www);

        //$tr_num =$tr->fetch_assoc();

        if ($tr  = 0){
          $last = 000000;
        }
        else{
          $last = $num['TRANSACTION_NUMBER']; // This is fetched from database
        }
       
          //echo 'Invoice number: '.$num['TRANSACTION_NUMBER'];
      
        $last++;
        //$invoice_number = sprintf('%07d', $last);
        $invoice_number = sprintf('%07d', $last);
        
        //generate order number ends here

        //
    	$sql_serve = "SELECT COUNT(Ids) FROM `total_sales` WHERE medecine_ID = '$medecine_id' AND batch = '$batch_nmber' AND ser_status = '0'";
    	$serve_result = $conn->query($sql_serve);
    	 
    	if($serve_result > 0 ){	    	
    		$_SESSION['message'] = 
    		'<div id="snackbar">
                	<strong>Product already in basket</strong>
            	</div>
            	<script>
				//function myFunction() {
				  var x = document.getElementById("snackbar");
				  x.className = "show";
				  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
				//}
				</script>
            ';
          	header('Location:medecine');
    		}else{
                if($current_qty >= $served_qty) {
                    $sql = "INSERT INTO `total_sales`(transaction_ID,medicine_ID,batch,quantity,price,date_done,userID,User_branch,institution_code,date_with_hours,ser_status) 
                    VALUES('$invoice_number','$medecine_id','$batch_nmber','$served_qty','$price','$ser_date','$user','$branch_ID','$institution_code',now(),'$status')";
                    $result = $conn->query($sql);
                    echo $conn->error;
                    if($result){
                        //echo "well inserted in the system";
                       $_SESSION['message'] = '

                        <div id="snackbar">'.$served_qty.'  of '.$medecine_id.' added </div>
                        <script>
                        //function myFunction() {
                          var x = document.getElementById("snackbar");
                          x.className = "show";
                          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                        //}
                        </script>
                        ';
                        header('Location:medecine');
                    }else{
                        echo "not ";
                    }
                }else{
                    $_SESSION['message'] = '
                    <div id="snackbar"> '.$served_qty.' This Quantity is greater than  of '.$current_qty.' please check!! </div>
                    <script>
                    //function myFunction() {
                      var x = document.getElementById("snackbar");
                      x.className = "show";
                      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
                    //}
                    </script>
                    ';
                    header('Location:medecine');
                }
            }
    }
?>