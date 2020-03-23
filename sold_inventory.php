<?php include('includes/head_tag.php'); ?>

<body id="page-top">

  <?php include('includes/menu.php'); ?>
    <div id="content-wrapper" >
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Total Sales</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
        <!-- <div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
          <form class="form-inline" action="" method="post" >
            <div class="form-group">
              <label for="date">From &nbsp;</label>
              <input type="date" class="form-control" id="email" required="required" placeholder="Select date" name="dateFrom">
            </div>
            <div class="form-group">
              <label for="pwd">&nbsp;To &nbsp;</label>
              <input type="date" class="form-control" id="dateTo" required="required" placeholder="Date to" name="dateTo">
            </div>
            &nbsp;&nbsp;<button type="submit" name="all_sales_report" class="btn btn-info btn-sm">Find</button>
          </form>
        </div> -->
        <?php 
                  /*$all_sales_other_user = "SELECT * FROM `total_sales` 
                  INNER JOIN `medical_product` ON total_sales.medicine_ID = medical_product.product_ID 
                  INNER JOIN `phar_branch` ON total_sales.user_branch= phar_branch.branch_ID 
                  INNER JOIN `login` ON total_sales.userID = login.user_id 
                  WHERE total_sales.User_branch = '$_SESSION[branch]' AND total_sales.userID='$_SESSION[user_id]'
                  AND total_sales.institution_code = '$_SESSION[institution_code]'";*/
                       # code...
                  ################## ALL SALES REPORT ##########################
                
                  if($_SESSION['role_id'] == 3){
                    $all_sales = "SELECT * FROM `total_sales` 
                    INNER JOIN `medical_product` ON total_sales.medicine_ID = medical_product.product_ID 
                    INNER JOIN `phar_branch` ON total_sales.user_branch= phar_branch.branch_ID 
                    INNER JOIN `login` ON total_sales.userID = login.user_id
                    WHERE total_sales.institution_code = '$_SESSION[institution_code]'
                    AND total_sales.payment_mode ='Inventory' ";
                    $all_sales_result = $conn->query($all_sales);
                  }else{
                    $all_sales = "SELECT * FROM `total_sales` 
                    INNER JOIN `medical_product` ON total_sales.medicine_ID = medical_product.product_ID 
                    INNER JOIN `phar_branch` ON total_sales.user_branch= phar_branch.branch_ID 
                    INNER JOIN `login` ON total_sales.userID = login.user_id 
                    WHERE total_sales.User_branch='$_SESSION[branch]' 
                    AND total_sales.institution_code = '$_SESSION[institution_code]'
                    AND total_sales.payment_mode ='Inventory'";

                    $all_sales_result = $conn->query($all_sales);
                  }
                  
                ?>
          <div class="card-header">
           <!--  <form action="action_page.php" method="post"style="float:right;">
              <button type="submit" id="export" name='export' value="Export to excel" class="btn btn-primary btn-sm">
                <i class="fas fa-file-excel"></i>
                    Export to excel
              </button> 
            </form> -->
            </div>
            
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Branch</th>
                    <th>Invoice</th>
                    <th>Medical</th>
                    <th>Batch</th>
                    <th>Quantity</th>
                    <th>Grand total</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Date</th>
                    <th>Branch</th>
                    <th>Invoice</th>
                    <th>Medical</th>
                    <th>Batch</th>
                    <th>Quantity</th>
                    <th>Grand total</th>
                    <th>Options</th>
                  </tr>
                </tfoot>
                <tbody>
                <?php
                $total_amount_ = 0;
                $transfer_amount = 0;
                $paid_amount = 0;
                $loan_amount = 0;
                  while ( $sales = $all_sales_result->fetch_assoc()) {
                    # code...
                    $price = $sales['quantity']*$sales['price'];
                     ?>
                 
                  <tr>
                    <td><?php  echo $sales['date_with_hours']; ?></td>
                    <td><?php  echo $sales['branch_name']; ?></td>
                    <td><?php  echo $sales['transaction_ID']; ?></td>
                    <td><?php  echo $sales['product_Nmae']; ?></td>
                    <td><?php  echo $sales['batch']; ?></td>
                    <td><?php  echo number_format($sales['quantity']); ?></td>
                    
                    <td><?php  echo number_format($sales['quantity']*$sales['price']).' frw'; ?></td>

                    
                    <td>
                     <span class="pull-right" style="float: left; "><i style=" color:blue; ">Inventored!!</i>
                      </span>
                    </td>
                  </tr>
                <?php $price;
                $total_amount_ = $total_amount_+$price;
                if ($sales['payment_mode'] == 'Transfer') {
                  # code...
                  $transfer_amount = $transfer_amount+$price;
                }
                if ($sales['payment_mode'] == 'Paid') {
                  # code...
                  $paid_amount = $paid_amount+$price;
                }
                if ($sales['payment_mode'] == 'Loan') {
                  # code...
                  $loan_amount = $loan_amount+$price;
                }

                 }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          
          <div class="card-footer small text-centered" >
            <center>
              

              <strong style="font-size: 1.5em; float: right;">
                <span class="alert alert-success">TOTAL AMOUNT: 
                  <?php echo number_format($total_amount_)." frw"; ?>
                </span>
              </strong>
            </center>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

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
