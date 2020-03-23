<?php
  session_start();
  include 'includes/config.php';

  if(isset($_POST['save'])){

    unset($_SESSION['checkout_btn']);

    $_SESSION['customer_tin']   = $_POST['c_tin'];

    $_SESSION['customer_name']  = $_POST['Cname'];
    $_SESSION['pnumber']        = $_POST['tel'];
    $_SESSION['payment_mode']   = $_POST['payment_mode'];


$get_unsaved_sales = "SELECT DISTINCT * FROM `total_sales` WHERE User_branch = '$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]' AND userID ='$_SESSION[user_id]' AND ser_status ='0'";
$result_unsaved_sales = $conn->query($get_unsaved_sales);
while ($row_unsaved_sales = $result_unsaved_sales->fetch_assoc()) {
  # code...
 $sql_price = "SELECT * FROM `purchase_medical_product` WHERE batch_Number = '$row_unsaved_sales[batch]' AND product_name ='$row_unsaved_sales[medicine_ID]'";

$result_price = $conn->query($sql_price);
$row_price = $result_price->fetch_assoc();
if ($_SESSION['payment_mode'] == 'Transfer') {
  $price = $row_price['purchase_price'];
}else{
  $price = $row_price['selling_price'];
}

### save new data
$sub_total = $price * $row_unsaved_sales['quantity'];
 $save_new = "UPDATE `total_sales` SET price='$price', sub_total='$sub_total', quantity = '$row_unsaved_sales[quantity]', customer_name='$_SESSION[customer_name]', customer_telphone ='$_SESSION[pnumber]', customer_tin ='$_SESSION[customer_tin]', payment_mode='$_SESSION[payment_mode]'
WHERE batch='$row_unsaved_sales[batch]' AND medicine_ID='$row_unsaved_sales[medicine_ID]' AND ser_status='0' ";
$result_update = $conn->query($save_new);

if ($result_update) {
  # code...
  $_SESSION['message'] = 
        '<div id="snackbar">
                  <strong>All data updated successfully</strong>
              </div>
              <script>
        //function myFunction() {
          var x = document.getElementById("snackbar");
          x.className = "show";
          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        //}
        </script>
            ';
            header('Location:view_basket');
}



  /*$medecine_id[]    = $row_price['product_name'];
  $batches[]        = $row_unsaved_sales['batch'];
  $serv_quantity[]  = $row_unsaved_sales['quantity'];
  $selling_price[]  = $row_price['selling_price'];
  $sub_total[]      = $row_price['selling_price'] * $row_unsaved_sales['quantity'];*/


}


}
           
?>
