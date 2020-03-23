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
          
          <li class="breadcrumb-item active">Transfered Transactions </li>
        </ol>
        

<!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
    <!--  -->
     
      <h5>List of Transfered Transactions</h5>
      </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Branch</th>
                    <th>Transaction</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Loan Amount</th>
                    <th>Paid Amount</th>
                    <th style="width: 250px;">Option</th>
                    
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Branch</th>
                    <th>Transaction</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Loan Amount</th>
                    <th>Paid Amount</th>
                    <th style="width: 250px;">Option</th>
                    
                  </tr>
                </tfoot>
                <tbody>
        <?php
          
          if($_SESSION['role_id'] == 3){
          $sql = "SELECT DISTINCT * FROM transactions 
                  INNER JOIN total_sales ON transactions.TRANSACTION_NUMBER = total_sales.transaction_ID 
                  INNER JOIN `phar_branch` ON transactions.Branch = phar_branch.branch_ID
                  
                  WHERE transactions.institution_code= '$_SESSION[institution_code]'
                  AND total_sales.payment_mode = 'Loan'
                  GROUP BY transactions.TRANSACTION_NUMBER";
          $query = $conn->query($sql);
        }else{
          $sql = "SELECT DISTINCT * FROM transactions 
                  INNER JOIN total_sales ON transactions.TRANSACTION_NUMBER = total_sales.transaction_ID 
                  INNER JOIN `phar_branch` ON transactions.Branch = phar_branch.branch_ID
                  WHERE transactions.Branch = '$_SESSION[branch]' AND transactions.institution_code= '$_SESSION[institution_code]'
                  AND total_sales.payment_mode = 'Loan'
                  GROUP BY transactions.TRANSACTION_NUMBER";
          $query = $conn->query($sql);
        }
        $inc = 4;
        while($row = $query->fetch_assoc()){
          $inc = ($inc == 4) ? 1 : $inc + 1; 
          $id = $row['TRANSACTION_NUMBER'];
          $sql_loan = "SELECT * FROM `medical_loan_recovery` WHERE transaction_ID = '$id' ";
          $loan_result = $conn->query($sql_loan);
          $loan_row = $loan_result->fetch_assoc();

          
          if($inc == 1) echo "<div class='row text-center'>";  
        ?>
      <tr>
      <td><?php echo $row['branch_name']; ?></td>      
      <td>
        <!-- <a href="sales_details?sales_inv=<?php// echo $row['TRANSACTION_NUMBER']; ?>"> -->
          <?php echo $row['TRANSACTION_NUMBER']; ?>
        <!-- </a> -->
      </td>
      <td><?php echo $row['customer_name']; ?></td>  
      <td><?php echo $row['DATE_OF_TRANSACTION']; ?></td>
      <td><p class="pull-left"><b><?php echo $row['TOTAL_PRICE'].' Frw'; ?></b></p></td>
      <td><p class="pull-left"><b><?php echo $loan_row['loan_amount'].' Frw'; ?></b></p></td>
      <td style="width: 250px;">
        <span class="pull-right" style="float: left; ">
         <a href="sales_details?sales_inv=<?php echo $row['TRANSACTION_NUMBER']; ?>" class="btn btn-primary btn-sm">
        <span class="fas fa-eye"></span> details</a></span>

        <?php if($rows['loan_recovery'] == '1'){ ?>
          
        <span class="pull-right" style="margin-left: 1em;">
         <a href="invoiceDetail?$inv=<?php echo $row['TRANSACTION_NUMBER']; ?>" class="btn btn-info btn-sm">
        <span class="fas fa-eye"></span> invoice</a></span>
      
        <?php 
        
        if ($loan_row['loan_amount'] < $row['TOTAL_PRICE']) {
          # code...
         ?>
        <a href="#demo_<?php echo $id; ?>" style="float: right;" class="btn btn-secondary btn-sm" data-toggle="collapse">Recovery</a>
           <div id="demo_<?php echo $id; ?>" class="collapse" style="margin-top: 5px;" >
            <form method="POST" action="action_page">
              <div class="col-md-10" >
                
                <button type="submit" name="send_recover_trans" style="margin-top: 5px;float: right;" class="btn btn-success btn-sm" value="" ><i class="fa fa-send">save</i></button>
              </div>
              <div class="col-md-7" >
                <input type="hidden" name="transaction_ID" step="any" value="<?php echo $id; ?>">
                <input type="hidden" name="paid_amount" step="any" value="<?php echo $row['TOTAL_PRICE']; ?>">
                <input type="number" name="loan_recover_amount" step="any" class="form-control" placeholder="recover amaunt">
               
              </div>
            </form>
           </div>
          <?php }else{?>
            <span class="pull-right" style="float: right;" >
         <a href="action_page?loan_recovered=<?php echo $row['TRANSACTION_NUMBER']; ?>" class="btn btn-success btn-sm">recovered</a></span>
        <?php  } }?>
      </td>
    </tr>
   </div>

      <?php
    }
    echo '
    </tbody>
    </table>';
    
    //end product row
  ?>
</div>
                           
      </tbody>
    </table>
  </div>
</div>
<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div></div>

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