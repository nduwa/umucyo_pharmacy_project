<?php
include('includes/head_tag.php');

?>
</head>
<body id="page-top">

  <?php include('includes/menu.php'); ?>
    <div id="content-wrapper" >
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Medecine</li>
          <li class="breadcrumb-item active">Transactions done by <a href="profile"><?php echo $_SESSION['username'] ?></a></li>
        </ol>
        
  <?php
  if(!empty($_SESSION['cart'])){
 
    //create array of initail qty which is 1
    $index = 0;
    $total = 0;
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

    if(!isset($_SESSION['qty_array'])){
      $_SESSION['qty_array'] = array_fill(0, count($_SESSION['cart']), 1);
    }
            //echo implode(',',$_SESSION['cart']).' kike '.$_SESSION['qty_array'];
    $g = implode(',',$_SESSION['cart']);
    $sql = "SELECT *,SUM(product_quantity) as quantity FROM `purchase_medical_product`
        INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
        INNER JOIN `login` ON purchase_medical_product.user_id = login.user_id 
        WHERE  medical_product.product_ID IN ($g) GROUP BY purchase_medical_product.product_name";

    $query = $conn->query($sql);

      while($row = $query->fetch_assoc()){
          $done_on = date('Y-m-d');
         $qty        = $_SESSION['qty_array'][$index];
         $sel_price1 = $_SESSION['selling_price'][$index];
         $batch_num  = $_SESSION['batch_number'][$index];
         $sub_total  = $_SESSION['sub_total'][$index];

         $sql2 = "INSERT INTO total_sales (transaction_ID,medicine_ID,batch
         ,quantity,price,sub_total,total_price,date_done,userID,User_branch
         ,institution_code,date_with_hours,customer_name, customer_telphone
         ,payment_mode,customer_tin)
        VALUES ('$invoice_number','$row[product_ID]', '$batch_num',
                '$qty','$sel_price1','$sub_total',
                '$_SESSION[tt_price]','$done_on','$_SESSION[user_id]',
                '$_SESSION[branch]','$_SESSION[institution_code]',now(),
                '$_SESSION[customer_name]','$_SESSION[pnumber]',
                '$_SESSION[payment_mode]','$_SESSION[customer_tin]')";
        
        if ($conn->query($sql2) === TRUE) {
            $_SESSION['message'] = 'Transaction processed successfully';
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
       
      $index ++;
    }
    //info message
    if(isset($_SESSION['message'])){
      $today = date('Y-m-d');
      $sql2 = "INSERT INTO transactions (DATE_OF_TRANSACTION,TOTAL_PRICE,TRANSACTION_NUMBER,user,user_id,Branch,institution_code,done_at)
      VALUES (now(),'$_SESSION[tt_price]','$invoice_number','$_SESSION[username]','$_SESSION[user_id]','$_SESSION[branch]','$_SESSION[institution_code]','$today');";
        
        if ($conn->query($sql2) === TRUE) {
            $_SESSION['message'] = 'Transaction processed successfully';
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
       
      ?>
      <div class="row" style="padding: ">
        <div class="col-sm-6 col-sm-offset-6">
          <div class="alert alert-info text-center">
            <?php echo $_SESSION['message']; ?>
          </div>
        </div>
      </div>
      <?php
      unset($_SESSION['message']);
      unset($_SESSION['customer_name']);
      unset($_SESSION['pnumber']);
      unset($_SESSION['payment_mode']);
      unset($_SESSION['batch_number']);

      echo '<script>
         setTimeout(function(){
            window.location.href = "profile";
         }, 2000);
      </script>';
    }

  // list all transactions done by current user,....

    

   unset($_SESSION['cart']);
   //header('Location: profile.php');
  } 

else {

  // list all transactions done by current user,....
  if($_SESSION['role_id'] == 3){
    $sql = "SELECT DISTINCT * FROM transactions 
    WHERE institution_code = '$_SESSION[institution_code]'";
    $query = $conn->query($sql);
  }else{
    $sql = "SELECT DISTINCT * FROM transactions 
    WHERE Branch = '$_SESSION[branch]' AND
    institution_code = '$_SESSION[institution_code]'";
    $query = $conn->query($sql);
  }
    

?>

<!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th># Transaction ID</th>
                    <th>Date</th>
                    <th>Total price</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th># Transaction ID</th>
                    <th>Date</th>
                    <th>Total price</th>
                    <th>Option</th>
                  </tr>
                </tfoot>
                <tbody>
        <?php
        $inc = 4;
        while($row = $query->fetch_assoc()){
          $inc = ($inc == 4) ? 1 : $inc + 1; 
          if($inc == 1) echo "<div class='row text-center'>";  
        ?>
      <tr>
               
      <td>
        <a href="sales_details?sales_inv=<?php echo $row['TRANSACTION_NUMBER']; ?>"><?php echo $row['TRANSACTION_NUMBER']; ?></a>
      </td>
      <td><?php echo $row['DATE_OF_TRANSACTION']; ?></td>
      <td><p class="pull-left"><b><?php echo $row['TOTAL_PRICE'].' Frw'; ?></b></p></td>
      <td>
        <span class="pull-right">
         <a href="sales_details?sales_inv=<?php echo $row['TRANSACTION_NUMBER']; ?>" class="btn btn-primary btn-sm">
        <span class="fas fa-eye"></span> invoice</a></span>
      </td>
    </tr>
   </div>

      <?php
    }
    echo '
    </tbody>
    </table>';
    //if($inc == 1) echo "<div></div><div></div><div></div></div>";
    //if($inc == 2) echo "<div></div><div></div></div>";
    //if($inc == 3) echo "<div></div></div>";
    
    //end product row
  ?>
</div>
                           
      </tbody>
    </table>
  </div>
</div>
<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div></div>

<?php
unset($_SESSION['cart']);
//header('location: profile');
}
  ?>

</div>

<!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>
  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>

</body>

</html>