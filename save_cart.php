<?php
  session_start();
  include 'includes/config.php';

  if(isset($_POST['save'])){
      unset($_SESSION['checkout_btn']);
    $_SESSION['customer_tin']   = $_POST['c_tin'];
    $_SESSION['customer_name']  = $_POST['Cname'];
    $_SESSION['pnumber']        = $_POST['tel'];
    $_SESSION['payment_mode']   = $_POST['payment_mode'];

    

    foreach($_POST['indexes'] as $key){
           
           $bat       = $_SESSION['batch_number'][$key];

           $sql       = "SELECT selling_price FROM `purchase_medical_product` WHERE batch_number='$bat' ";

           $sql_price = $conn->query($sql);
           $p         = $sql_price->fetch_assoc();
           //$_SESSION['batch_number'][$key]    = $bat;

           if ($_POST['qty_'.$key] <= $_SESSION['current_qty'][$key] && $_POST['qty_'.$key] > 0) {
            # code...
            $_SESSION['qty_array'][$key]  = $_POST['qty_'.$key];
            $_SESSION['checkout_btn'] = '';
            $_SESSION['check_qty'] ='';

           }else{
             $_SESSION['qty_array'][$key] = 0;
             $_SESSION['check_qty'] = '<div class="alert alert-danger text-center">
                           Please enter qty in stock on line '.($key+1).'</div>';
             $_SESSION['message'] = '<div class="alert alert-warning text-center"> Cart Quantity not saved</div>';
             $_SESSION['checkout_btn'] = 'disabled';
             //header('location: view_cart');
             
           }
       //$_SESSION['qty_array'][$key]       = $_POST['qty_'.$key];
           $_SESSION['selling_price'][$key]   = $p['selling_price'];
           $_SESSION['sub_total'][$key]       = $p['selling_price']*$_SESSION['qty_array'][$key];

           //echo $key.' '.$_POST['batch_Number'][$key].'p:'.$_SESSION['selling_price'][$key].' '.$_SESSION['qty_array'][$key].'<br>';
           
    }

     $_SESSION['message'] = '<div class="alert alert-info text-center">
                  Cart updated successfully</div>';

     header('location: view_cart.php');
  }
?>
