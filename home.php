
<?php include('includes/head_tag.php'); ?>
<?php include('includes/menu.php'); ?>
<?php include 'chart_h.php'; ?>
<!-- <script type="text/javascript">
  $(document).ready(function () {
    setInterval(function() {
        $.get("home.php", function (result) {
            $('#page-top2').html(result);
        });
    }, 20000);
});
</script> -->
</head>
<body id="page-top">

  
    <div id="content-wrapper" style="margin-top: auto;">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active" >Overview</li>&nbsp;&nbsp;&nbsp;&nbsp;
          <li id="clock"><?php echo date("Y-m-d")."  ". date("l"); ?>&nbsp;&nbsp;&nbsp;<label id="timer"></label></li>
        </ol>  
        <!-- Icon Cards-->

        <div class="row" id="IDD">
          <?php
          $to_day = date("Y-m-d");
          if($_SESSION['role_id'] == 3){
            $Sql_sales_today = "SELECT * FROM total_sales
                              WHERE  total_sales.institution_code = '$_SESSION[institution_code]'
                              AND total_sales.date_done BETWEEN '$to_day' AND '$to_day' ";
           $sales = $conn->query($Sql_sales_today);

           $Total_sales = $conn->query("SELECT * FROM `total_sales`
                                  WHERE total_sales.institution_code = '$_SESSION[institution_code]'
                                   ORDER BY Ids ASC");
           $expense = "SELECT * FROM  `medical_expense`
                      WHERE  medical_expense.institution_code = '$_SESSION[institution_code]'";
           $expense_result = $conn->query($expense);

           $Sql_medicine = "SELECT * FROM `medical_product`
          WHERE  medical_product.institution_code = '$_SESSION[institution_code]' 
            ORDER BY product_ID ASC ";

           $tota_medicine = $conn->query($Sql_medicine);
           $Sql_users = "SELECT * FROM `login`
           WHERE login.user_status='1' AND
            login.institution_code = '$_SESSION[institution_code]' 
            ORDER BY user_id ASC";
           $tota_users = $conn->query($Sql_users);

          }else{
            $Sql_sales_today = "SELECT * FROM total_sales
            WHERE total_sales.User_branch = '$_SESSION[branch]' 
            AND total_sales.institution_code = '$_SESSION[institution_code]'
            AND total_sales.date_done BETWEEN '$to_day' AND '$to_day' ";
            $sales = $conn->query($Sql_sales_today);

            $Total_sales = $conn->query("SELECT * FROM `total_sales`
                            WHERE total_sales.User_branch = '$_SESSION[branch]' 
                            AND total_sales.institution_code = '$_SESSION[institution_code]'
                            ORDER BY Ids ASC");
            $expense = "SELECT * FROM  `medical_expense`
                WHERE medical_expense.branch_id = '$_SESSION[branch]' 
                AND medical_expense.institution_code = '$_SESSION[institution_code]'";
            $expense_result = $conn->query($expense);

            $Sql_medicine = "SELECT * FROM `medical_product`
            WHERE  medical_product.branch_ID = '$_SESSION[branch]' 
              AND medical_product.institution_code = '$_SESSION[institution_code]' 
              ORDER BY product_ID ASC ";
  
             $tota_medicine = $conn->query($Sql_medicine);

             $Sql_users = "SELECT * FROM `login`
           WHERE login.user_status='1' AND
           login.branch = '$_SESSION[branch]' 
            AND login.institution_code = '$_SESSION[institution_code]' 
            ORDER BY user_id ASC";
           $tota_users = $conn->query($Sql_users);
          }
         

          ?>
          <div class="col-xl-3 col-sm-6 mb-3" >
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body" style="padding: 20px;">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-plus"></i>
                </div>
                <div class="mr-5"><span class="badge badge-danger"><?php echo $sales->num_rows; ?></span>
                <i style="font-size: 12px;"> Sales Today!</i></div>
                <div class="mr-5"><span class="badge badge-danger" ><?php echo $Total_sales->num_rows; ?></span>
                  <i style="font-size: 12px;"> Total Sales!</i></div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="today_sales" >
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-minus"></i>
                </div>
                <div class="mr-5"><span class="badge badge-danger">
                  <?php echo $expense_result->num_rows; ?>
                </span> Expense Today!&nbsp;</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
         <?php 
          
          ?>
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-notes-medical"></i>
                </div>
                <div class="mr-5"><span class="badge badge-danger"><?php echo $tota_medicine->num_rows; ?></span> Medecine!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="medical_list">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">

       <?php 
          
          ?>

            <div class="card text-white bg-info o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-users"></i>
                </div>
                <div class="mr-5"><span class="badge badge-info"><?php echo $tota_users->num_rows; ?></span> Staff!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="pharmacy_users">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
        <?php 
              $to_day = date("Y-m-d");
              $sql_todaySales = $conn->query("SELECT * FROM total_sales WHERE date_done = '$to_day' ORDER BY Ids ASC");

              $sql_totalSales = $conn->query("SELECT * FROM total_sales ORDER BY Ids ASC");
              
       
         ?>
        <div class="row">
           
            
          <?php if ($_SESSION['role_id'] == 3 || $_SESSION['role_id'] == 1) {   ?>

          <div class="col-sm-6 col-md-6 col-xl-6">
            <!-- Area Chart Example-->
            <div class="card mb-3"> 
              <div class="card-header">
                <i class="fas fa-chart-area"></i>
                GENERAL ACTIVITY VALUES FOR ALL BRANCH</div>
              <div class="card-body">
                <ul class="list-group" style="padding: 0px;">
                  <a href="medical_list" class="list-group-item">All Medicines for branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="medecine_cat" class="list-group-item">All Medical Category for branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="medecine_purchase" class="list-group-item">All Purchased medecine for branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="expenses" class="list-group-item">All Expenses for branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="medical_income" class="list-group-item">All Incomes for branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="all_sales" class="list-group-item">All Sales Medecine for branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>
 
                  <a href="checkout" class="list-group-item">All Transactions for branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>
                </ul>
              </div>
              <div class="card-footer small text-muted">Updated by umucyo</div>
            </div>
          </div>
          <?php } ?>
          <div class="col-sm-6 col-md-6 col-xl-6">

             <!-- Area Chart Example-->
            <div class="card mb-3"> 
              <div class="card-header">
                <i class="fas fa-chart-area"></i>
                BRANCH ACTIVITY VALUES</div>
              <div class="card-body">
                <ul class="list-group" style="padding: 0px;">

                  <?php if($rows['view_current_quantity']){?>
                  <a href="medecine" class="list-group-item">The Current Stock Quantity for every branch<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>
                  <?php } ?>

                  <a href="medecine_stock_out" class="list-group-item">Stock Out Quantity for every branch<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="medecine_expired_qty" class="list-group-item">The Expired Quantity for every branch<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>



                  <a href="refounded_trans" class="list-group-item">Refounded transactions for every branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="transfered_trans" class="list-group-item">Transfered transactions for every branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="loan_trans" class="list-group-item">Loan transactions for every branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>
                  
                  <?php if ($_SESSION['role_id'] != 3) {
                    # code...
                   ?>
                  <a href="checkout" class="list-group-item">All Transactions for branches<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>
                  <?php } ?>

                </ul>
              </div>
              <div class="card-footer small text-muted">Updated by umucyo</div>
            </div>
          </div>

          <!-- statistic sales -->
          <div class="col-sm-6 col-md-6 col-xl-6" style="padding: 0px;">
            <!-- Area Chart Example-->
            <div class="card mb-3"> 
              <div class="card-header">
                <i class="fas fa-chart-area"></i>
                STATISTICS</div>
              <div class="card-body">
                <ul class="list-group" style="padding: 0px;">

                  

                  <a href="medical_inventory" class="list-group-item">Purchased Inventory Quantity<span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="sold_inventory" class="list-group-item">Sold Inventory Quantity <span class="badge badge-info" style="float: right;">
                    <i class="fa fa-exclamation-circle"></i>
                  </span></a>

                  <a href="all_sales" class="list-group-item">2 Total Sales<span class="badge badge-info" style="float: right;">
                    <?php echo $sql_totalSales->num_rows; ?></span></a>
                  
                  <a href="#" class="list-group-item">4 Total Expense<span class="badge badge-info" style="float: right;">0</span></a>
                  <a href="medical_list" class="list-group-item">5 Number Of Medicines<span class="badge badge-info" style="float: right;">
                    <?php echo $tota_medicine->num_rows; ?>
                  </span></a>
                  <a href="#" class="list-group-item">6 In Stock Inventory Quantity<span class="badge badge-info" style="float: right;">0</span></a>
                  
                </ul>
              </div>
              <div class="card-footer small text-muted">Updated by umucyo</div>
            </div>
          </div>
        
          <div class="col-sm-6 col-md-6 col-xl-6">
            <!-- Area Chart Example-->
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-area"></i>
                THE TOTAL AMOUNT FOR EVERY DAY</div>
              <div class="card-body" id="">
                <canvas id="kike" width="100%" height="30"></canvas>
              </div>
              <div class="card-footer small text-muted" id="updated_time">
                
              </div>
            </div>
                  <script type="text/javascript">
                    $(document).ready(function () {
                      setInterval(function() {
                          $.get("chart_h.php", function (result) {
                              $('#kike').html(result);
                          });
                      }, 10000);
                  });
                  </script>

                  <?php $tim = 'Updated'.' ' .date('l').' '.date('Y-m-d h:i:sa');?>
                  <script type="text/javascript">
                    $(document).ready(function(){
                       var timee = '<?php echo $tim; ?>';
                      document.getElementById("updated_time").innerHTML = timee;
                    });
                  </script>
                                        
            <?php if($_SESSION['role_id'] == 3){?>        
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-users"></i>
                STATUS OF USER(S) IN PHARMACY</div>
              <div class="card-body" id="">
                <div id="users"></div>
                <?php //include('user_list.php'); ?>
                <!-- <canvas id="users" width="100%" height="30"></canvas> -->
              </div>
              <div class="card-footer small text-muted" id="updated_time">
                
              </div>
            </div>          
          <script type="text/javascript">
            $(document).ready(function () {
               setInterval(function() {
                $.get("user_list.php", function (result) {
                $('#users').html(result);
               });
              }, 10000);
            });
          </script>
        <?php } ?>
        </div>

          
        </div>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <?php include('includes/footer.php'); ?>

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
   <script src="js/chatJs.js"></script>
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
