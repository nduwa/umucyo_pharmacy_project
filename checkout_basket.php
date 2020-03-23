<?php
include 'includes/config.php';
  session_start();
  $today = date('Y-m-d');
$get_saved_sales = "SELECT DISTINCT * FROM `total_sales` WHERE User_branch = '$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]' AND userID ='$_SESSION[user_id]' AND ser_status ='0'";
$result_saved_sales = $conn->query($get_saved_sales);
$count = $result_saved_sales->num_rows;
while ($row_saved_sales = $result_saved_sales->fetch_assoc()) {
  # code...
  $sold_quantity = $row_saved_sales['quantity'];
$sql_qty = "SELECT * FROM `purchase_medical_product` WHERE batch_Number = '$row_saved_sales[batch]' AND product_name ='$row_saved_sales[medicine_ID]'";

$result_qty = $conn->query($sql_qty);
$row_qty = $result_qty->fetch_assoc();
$purchased_quantity = $row_qty['product_quantity'];
if ($result_qty) {
  # code...
  $update_sales = "UPDATE `total_sales` SET total_price = '$_REQUEST[total]',ser_status = '1' WHERE User_branch = '$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]' AND userID ='$_SESSION[user_id]' AND batch='$row_saved_sales[batch]' AND medicine_ID='$row_saved_sales[medicine_ID]' AND ser_status='0' ";
$result_update_sales = $conn->query($update_sales);
if ($result_update_sales) {
  # code...
  $remaim_quantity = $purchased_quantity - $sold_quantity;

  $update_purchase = "UPDATE `purchase_medical_product` SET product_quantity = '$remaim_quantity' WHERE branch_ID = '$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]' AND batch_Number='$row_saved_sales[batch]' AND product_name='$row_saved_sales[medicine_ID]'";
$result_update_purchase = $conn->query($update_purchase);
if ($result_update_purchase) {}
}}}

  # code...
  $sql_insert_trans = "INSERT INTO `transactions` VALUES(null,now(),'$_REQUEST[total]','$_REQUEST[trans]','$_SESSION[username]','$_SESSION[user_id]','$_SESSION[branch]','$_SESSION[institution_code]','$today')";
  $result_trans = $conn->query($sql_insert_trans);
  if ($result_trans) {
    # code...
    $_SESSION['message'] = 
        '<div id="snackbar">
                  <strong>Done successfully</strong>
              </div>
              <script>
        //function myFunction() {
          var x = document.getElementById("snackbar");
          x.className = "show";
          setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        //}
        </script>
            ';
            header('Location:profile');
  }


?>