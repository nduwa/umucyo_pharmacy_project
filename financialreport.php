
<?php include('includes/head_tag.php'); ?>
<?php include('includes/menu.php'); ?>
</head>
<body id="page-top">

  
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active" >Overview</li>&nbsp;&nbsp;&nbsp;&nbsp;
          <li id="clock"><?php echo date("Y-m-d")."  ". date("l"); ?>&nbsp;&nbsp;&nbsp;<label id="timer"></label></li>
          <li class="breadcrumb-item"><i>REPORTING</i></li>
        </ol>  
        <!-- Icon Cards-->

        <?php
        //initialize current date

        $to_day = date("Y-m-d");
        
        echo $conn->error;

        if (isset($_POST['report'])) {
          # code...
          $total_sales = 0;
          $gross_total_purchase = 0;
          $_SESSION['date1'] = $_POST['dateFrom'];
          $_SESSION['date2'] = $_POST['dateTo'];

          $d1  = $_POST['dateFrom'];
          $d2  = $_POST['dateTo'];
        }
        else{
          $total_sales = 0;
          $gross_total_purchase = 0;
          $total_expense = 0;
          $_SESSION['date1'] = date("Y-m-d");
          $_SESSION['date2'] = date("Y-m-d");
          
        }
        if($_SESSION['role_id'] == 3){
        $Sql_sales_today = "SELECT * FROM total_sales WHERE total_sales.date_done BETWEEN '$_SESSION[date1]' AND '$_SESSION[date2]' AND total_sales.institution_code = '$_SESSION[institution_code]' AND total_sales.payment_mode = 'Paid'";
        $sales = $conn->query($Sql_sales_today);

        $Sql_gross_purchase = "SELECT * FROM `purchase_medical_product` WHERE purchase_medical_product.purchase_date BETWEEN '$_SESSION[date1]' AND '$_SESSION[date2]' AND purchase_medical_product.institution_code = '$_SESSION[institution_code]' ";
        $Gross_purchase = $conn->query($Sql_gross_purchase);

        $Sql_expenses = "SELECT * FROM `medical_expense` WHERE medical_expense.expense_date BETWEEN '$_SESSION[date1]' AND '$_SESSION[date2]' AND medical_expense.institution_code = '$_SESSION[institution_code]' ";
        $expenses = $conn->query($Sql_expenses);

        $sql_branch = "SELECT * FROM `phar_branch` WHERE phar_branch.institution_code = '$_SESSION[institution_code]'";
        $branch_list = $conn->query($sql_branch);   
        
            
        }else{
          $Sql_sales_today = "SELECT * FROM total_sales WHERE date_done BETWEEN '$_SESSION[date1]' AND '$_SESSION[date2]'
          AND User_branch='$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]'";
        $sales = $conn->query($Sql_sales_today);

        $Sql_gross_purchase = "SELECT * FROM `purchase_medical_product` WHERE purchase_date BETWEEN '$_SESSION[date1]' AND '$_SESSION[date2]' 
        AND branch_ID='$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]'";
        $Gross_purchase = $conn->query($Sql_gross_purchase);

        $Sql_expenses = "SELECT * FROM `medical_expense` WHERE expense_date BETWEEN '$_SESSION[date1]' AND '$_SESSION[date2]' AND branch_id='$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]' ";
        $expenses = $conn->query($Sql_expenses);
        }  
           while ($row = $sales->fetch_assoc()) {
             # code...
              $total_sales += $row['quantity'] * $row['price'];
           }
           
           while ($gross = $Gross_purchase->fetch_assoc()) {
             # code...
              $gross_total_purchase += $gross['product_quantity'] * $gross['purchase_price'];
           }
           while ($exp = $expenses->fetch_assoc()) {
            # code...
            $total_expense += $exp['expense_amount']; 
           }
           
          ?>
        <div class="row container ">
          <div class="col-sm-7 col-md-7 col-lg-7 col-xs-12">
          <form class="form-inline" action="" method="post" >
            <div class="form-group">
              <label for="date">From &nbsp;</label>
              <input type="date" class="form-control" id="email" required="required" placeholder="Select date" name="dateFrom">
            </div>
            <div class="form-group">
              <label for="pwd">&nbsp;To &nbsp;</label>
              <input type="date" class="form-control" id="dateTo" required="required" placeholder="Date to" name="dateTo">
            </div>
            &nbsp;&nbsp;<button type="submit" name="report" class="btn btn-info btn-sm">Submit</button>
          </form>
        </div>
        <div class="col-sm-5 col-md-5 col-lg-5 col-xs-12" style="float: right;">
              <div class="card-header">
                <i class="far fa-money-bill-alt"></i>
                <small>REPORT STATISTICS <strong>FROM</strong> <?php echo $_SESSION['date1']."<strong> TO </strong> ".$_SESSION['date2'] ?></small>
              </div>
        </div>
        </div>
        <br>
        <div class="row">
          <div class="col-sm-8 col-md-8 col-xl-8">
            <!-- Area Chart Example  branches list sales-->
            <div class="card mb-3">
            
              <div class="card-header">
                <i class="far fa-money-bill-alt"></i>
                BRANCHES SALES REPORT <strong>FROM</strong> <?php echo $_SESSION['date1']."<strong> TO </strong> ".$_SESSION['date2'] ?></div>
              <div class="card-body">

              <div class="card-header" style="background-color: #d8ffec;">
                  <div class="row">
                    <div class="col-sm-3 col-md-3">
                      <i class="far fa-money-bill-alt"></i>
                      &nbsp;BRANCHE 
                    </div>
                  <div class="col-sm-3 col-md-3">
                    <strong>
                      SALES 
                    </strong>
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <strong>
                      PURCHASED 
                    </strong>
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <strong>
                      EXPENSES 
                    </strong>
                  </div>
                </div>
                </div>
              <?php 
            while($row_branch = $branch_list->fetch_assoc()){
              $id = $row_branch['branch_ID'];
              /// sales sum
              $sql_sum = "SELECT SUM(quantity * price) AS T_price FROM total_sales
              WHERE total_sales.User_branch = '$id' AND total_sales.date_done BETWEEN '$_SESSION[date1]' AND '$_SESSION[date2]' AND total_sales.payment_mode = 'Paid' GROUP BY User_branch";
              $to_sales_branch = $conn->query($sql_sum);
              echo $conn->error;
              $row_sum = $to_sales_branch->fetch_assoc();
              /// purchase sum
              $sql_sum_purchase = "SELECT SUM(purchase_price * product_quantity) AS P_price FROM purchase_medical_product
              WHERE purchase_medical_product.branch_ID = '$id' AND purchase_medical_product.purchase_date BETWEEN '$_SESSION[date1]' AND '$_SESSION[date2]' GROUP BY branch_ID";
              $to_purchase_branch = $conn->query($sql_sum_purchase);
              $row_sum_pur = $to_purchase_branch->fetch_assoc();
              /// Expenses sum
              $sql_sum_expense = "SELECT SUM(expense_amount) AS E_price FROM medical_expense
              WHERE medical_expense.branch_id = '$id' AND medical_expense.expense_date BETWEEN '$_SESSION[date1]' AND '$_SESSION[date2]' GROUP BY branch_id";
              $to_expense_branch = $conn->query($sql_sum_expense);
              $row_sum_exp = $to_expense_branch->fetch_assoc();


              ?>
              
              
              <div class="card-header" style="background-color: skyblue;">
                  <div class="row">
                    <div class="col-sm-3 col-md-3">
                    <i class="far fa-money-bill-alt"></i>
                    &nbsp;<?php echo $row_branch['branch_name']; ?> 
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <?php echo number_format($row_sum['T_price']); ?> frw
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <?php echo number_format($row_sum_pur['P_price']); ?> frw
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <?php echo number_format($row_sum_exp['E_price']); ?> frw
                  </div>
                  </div>       
                </div>
              <?php 
            }
            ?>
                <div class="card-header" style="background-color: #c6e3ff;">
                  <div class="row">
                    <div class="col-sm-3 col-md-3">
                    <i class="far fa-money-bill-alt"></i>
                    &nbsp;TOTAL: 
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <?php echo number_format($total_sales); ?> frw 
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <?php echo number_format($gross_total_purchase); ?> frw 
                  </div>
                  <div class="col-sm-3 col-md-3">
                    <?php echo number_format($total_expense); ?> frw 
                  </div>
                  </div>       
                </div>

                        

              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>

<!--             
             <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-money-check-alt"></i>
                 EXPENSE REPORT</div>
              <div class="card-body">
                       <!-- DataTables Example --
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" cellspacing="0">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Category(Description)</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody style="padding: 0px;">
                      <?php
                        
                        // $num = 1;
                        // $total_expense = 0;
                        // while ($exp = $expenses->fetch_assoc()) {
                        //  # code...
                        //  $total_expense += $exp['expense_amount']; 
                      ?>
                      <tr>
                        <td><?php //echo $num; ?></td>
                        <td><?php //echo $exp['expense_reason']; ?></td>
                        <td><?php //echo number_format($exp['expense_amount']).' frw'; ?></td>
                      </tr>
                    <?php //$num++; } ?>
                     </tbody>
                    </table>
                  </div>      

                  </div>
              <div class="card-footer " >
                <p style="float: right;">
                <strong style="border: 1px black solid; padding: 5px;">
                Total expenses</strong> 
                <b style="border: 1px black solid; padding: 5px;"><i style="color: #900;">
                  <?php// echo number_format($total_expense).'</i> frw</b>'; ?>
                </p>
                </div>
            </div> -->

          </div>
          <!-- statistic sales -->
          <div class="col-sm-4 col-md-4 col-xl-4" style="padding: 0px;">
            <div class="col-xl-12 col-sm-12 mb-12">
            <div class="card-header">
                <i class="fas fa-money-check"></i>
                 STATISTICS
            </div>
          </div>
           <br>
            <div class="col-xl-12 col-sm-12 mb-12">
            <div class="card text-white bg-success o-hidden h-100" style="border-radius: 20px;">
              <div class="card-body">
                <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12" style="margin-bottom: -25px; margin-top: -10px;" >
                  <center><i style="font-size: 70px;" 
                    class="far fa-money-bill-alt"></i></center>
                  <p style="text-align: center;">Gross Purchase Price</p>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
                    <i class=""><p class="spinner-border text-default"></p></i>
                    <span><?php echo number_format($gross_total_purchase); ?> Frw</span>
                </div>
               </div>
            </div>
          </div>
          </div>
           <br>
          <div class="col-xl-12 col-sm-12 mb-12">
            <div class="card text-white bg-success o-hidden h-100" style="border-radius: 20px;">
              <div class="card-body">
                <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12" style="margin-bottom: -25px; margin-top: -10px;" >
                  <center><i style="font-size: 70px;" class="fas fa-money-check-alt"></i></center>
                  <p style="text-align: center;">Gross Selling Price</p>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
                    <i class=""><p class="spinner-border text-info"></p></i>
                    <span><?php echo number_format($total_sales); ?> frw</span>
                </div>
               </div>
            </div>
          </div>
          </div>

       <br>
          <div class="col-xl-12 col-sm-12 mb-12">
            <div class="card text-white bg-success o-hidden h-100" style="border-radius: 20px;">
              <div class="card-body">
                <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12" style="margin-bottom: -25px; margin-top: -10px;" >
                  <center><i style="font-size: 70px;" 
                    class="fas fa-money-bill-wave-alt"></i></center>
                  <p style="text-align: center;">Gross Expense</p>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
                    <i class=""><p class="spinner-border text-info"></p></i>
                    <span><?php echo number_format($total_expense); ?> frw</span>
                </div>
               </div>
            </div>
          </div>
          </div>

          <br>
          <div class="col-xl-12 col-sm-12 mb-12">
            <div class="card text-white bg-success o-hidden h-100" style="border-radius: 20px;">
              <div class="card-body">
                <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12" style="margin-bottom: -25px; margin-top: -10px;" >
                  <center><i style="font-size: 70px;" class="fas fa-money-bill" aria-hidden="true"></i></center>
                  <p style="text-align: center;">Profit</p>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
                    <i class=""><p class="spinner-border text-info"></p></i>
                    <span><?php 
                            $profit = $total_sales - $gross_total_purchase-$total_expense;
                            echo number_format($profit); 
                           ?> frw
                    </span>
                </div>
               </div>
            </div>
          </div>
          </div>
          <br>
       <!--  ends of right column  -->   
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
