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
          
          <li class="breadcrumb-item active">Refounded Transactions </li>
        </ol>
        

<!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
    <!--  -->
      
      <h5>List of Refounded Transactions</h5>
      </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Branch</th>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Total price</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Branch</th>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Total price</th>
                    <th>Option</th>
                  </tr>
                </tfoot>
                <tbody>
        <?php
              
          if($_SESSION['role_id'] == 3){
          $sql = "SELECT DISTINCT * FROM transactions 
                  INNER JOIN total_sales ON transactions.TRANSACTION_NUMBER = total_sales.transaction_ID 
                  INNER JOIN `phar_branch` ON transactions.Branch = phar_branch.branch_ID
                  WHERE transactions.institution_code= '$_SESSION[institution_code]'
                  AND total_sales.payment_mode = 'Refounded'
                  GROUP BY transactions.TRANSACTION_NUMBER";
          $query = $conn->query($sql);
        }else{
          $sql = "SELECT DISTINCT * FROM transactions 
                  INNER JOIN total_sales ON transactions.TRANSACTION_NUMBER = total_sales.transaction_ID 
                  INNER JOIN `phar_branch` ON transactions.Branch = phar_branch.branch_ID
                  WHERE transactions.Branch = '$_SESSION[branch]' AND transactions.institution_code= '$_SESSION[institution_code]'
                  AND total_sales.payment_mode = 'Refounded'
                  GROUP BY transactions.TRANSACTION_NUMBER";
          $query = $conn->query($sql);
        }
        $inc = 4;
        while($row = $query->fetch_assoc()){
          $inc = ($inc == 4) ? 1 : $inc + 1; 
          if($inc == 1) echo "<div class='row text-center'>";  
        ?>
      <tr>
      <td><?php echo $row['branch_name']; ?></td>      
      <td>
        <!-- <a href="sales_details?sales_inv=<?php// echo $row['TRANSACTION_NUMBER']; ?>"> -->
          <?php echo $row['TRANSACTION_NUMBER']; ?>
        <!-- </a> -->
      </td>
      <td><?php echo $row['DATE_OF_TRANSACTION']; ?></td>
      <td><p class="pull-left"><b><?php echo $row['TOTAL_PRICE'].' Frw'; ?></b></p></td>
      <td>
        <span class="pull-right">
         <a href="sales_details?sales_inv=<?php echo $row['TRANSACTION_NUMBER']; ?>" class="btn btn-primary btn-sm">
        <span class="fas fa-eye"></span> details</a></span>
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
//unset($_SESSION['cart']);
//header('location: profile');
//}
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