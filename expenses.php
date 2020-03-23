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
          <li class="breadcrumb-item active">Expense</li>
          <li><h5 style="margin-left: 10em;">List of Pharmacy Branches expenses</h5></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
             <?php if($_SESSION['role_id'] == 3){ ?>
            <!-- <button class="btn btn-info btn-sm" style="float: right;" onclick="CopyToClipboard('dataTable')">Copy Current Data</button>
 -->            
            <!-- <button class="alert alert-info alert-sm" style="margin-left: 0px;" onclick="CopyToClipboard('dataTable')">Copy Data</button> -->
        <div style="float: right; margin-right: 10px;">

          <form class="form-inline pull-right" action="" method="post" >

              <div class="form-group">
                <label for="date">From &nbsp;</label>
                <input type="date" class="form-control" id="email" required="required" placeholder="Select date" name="dateFrom">
              </div>
              <div class="form-group">
                <label for="pwd">&nbsp;To &nbsp;</label>
                <input type="date" class="form-control" id="dateTo" required="required" placeholder="Date to" name="dateTo">
              </div>&nbsp;&nbsp;&nbsp;&nbsp;
              <div class="form-group" >
              <!-- <label for="pwd">&nbsp;&nbsp;&nbsp;Select Branch &nbsp;</label> -->
              <select class="form-control" name="branch_ID">
                <option selected="selected" disabled="disabled">SELECT BRANCH NAME</option>
                <?php
                $stmt = $conn->query("SELECT * FROM `phar_branch`WHERE institution_code = '$_SESSION[institution_code]' ");
                while ($row = $stmt->fetch_assoc()) {?>
                    <option value="<?php echo $row['branch_ID']; ?>"><?php echo $row['branch_name'];?></option>
                <?php } ?>
              </select>
            
              &nbsp;&nbsp;<button type="submit" name="find_report" class="btn btn-info btn-sm">Find</button>
            </div>
          </form>
        </div>
        <?php } ?>
            <?php  if($rows['new_expenses']== 1) { ?>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"style="float: right;">
              <i class="fas fa-plus"></i>
                 New Expense
            </button>
            <?php } ?>
            
            </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Date</th> 
                    <th>Branch</th>
                    <th>Bank Slip Number</th>
                    <th>Amount</th>
                    <th>Comment</th>
                    <th>Done By</th>
                    <?php  if($rows['approve_expenses']== 1) { ?>
                    <th>Options</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Date</th> 
                    <th>Branch</th>
                    <th>Bank Slip Number</th>
                    <th>Amount</th>
                    <th>Comment</th>
                    <th>Done By</th>
                    <?php  if($rows['approve_expenses']== 1) { ?>
                    <th>Options</th>
                    <?php } ?>
                  </tr>
                </tfoot>
                <tbody>
                <?php
                $date1 = date("Y-m-d");
              $date2 = date("Y-m-d");
              $_SESSION['br'] = $_SESSION['branch'];
              if(isset($_POST['find_report'])){
                  $_SESSION['br'] = $_POST['branch_ID'];
                  $date1 = $_POST['dateFrom'];
                 $date2 = $_POST['dateTo'];
                if($_SESSION['role_id'] == 3){
                  $sql = "SELECT * FROM `medical_expense` 
                  INNER JOIN `phar_branch` ON medical_expense.branch_id = phar_branch.branch_ID
                  INNER JOIN `login` ON medical_expense.user_ids = login.user_id
                  WHERE medical_expense.institution_code = '$_SESSION[institution_code]'
                  AND medical_expense.branch_id = '$_SESSION[br]'
                  AND medical_expense.expense_date BETWEEN '$date1' AND '$date2'";
                  $query = $conn->query($sql);
                }else{
                  $sql = "SELECT * FROM `medical_expense` 
                  INNER JOIN `phar_branch` ON medical_expense.branch_id = phar_branch.branch_ID
                  INNER JOIN `login` ON medical_expense.user_ids = login.user_id
                  WHERE medical_expense.branch_id = '$_SESSION[br]'
                  AND medical_expense.expense_date BETWEEN '$date1' AND '$date2' 
                  AND medical_expense.institution_code = '$_SESSION[institution_code]'";
                  $query = $conn->query($sql);
                }
              }else{
                if($_SESSION['role_id'] == 3){
                  $sql = "SELECT * FROM `medical_expense` 
                  INNER JOIN `phar_branch` ON medical_expense.branch_id = phar_branch.branch_ID
                  INNER JOIN `login` ON medical_expense.user_ids = login.user_id
                  WHERE medical_expense.institution_code = '$_SESSION[institution_code]'";
                  $query = $conn->query($sql);
                }else{
                  $sql = "SELECT * FROM `medical_expense` 
                  INNER JOIN `phar_branch` ON medical_expense.branch_id = phar_branch.branch_ID
                  INNER JOIN `login` ON medical_expense.user_ids = login.user_id
                  WHERE medical_expense.branch_ID ='$_SESSION[branch]' 
                  AND medical_expense.institution_code = '$_SESSION[institution_code]'";
                  $query = $conn->query($sql);
                }
              }
                $total_amount_ = 0;
                while($row = $query->fetch_assoc()){ 
                  //$reg_date       = date('h:m:i');
                  $amount = $row['expense_amount'];
                  ?>
                 <tr>
                    <td><?php echo $row['expense_date']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['bank_number']; ?></td>
                    <td><?php echo $row['expense_amount']." Frw"; ?></td>
                    <td><?php echo $row['expense_reason']; ?></td>
                    <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                    <?php  if($rows['approve_expenses']== 1) { ?>
                    <td>
                    <div class="xs">
                      <?php if($row['expense_status'] == '2'){ ?>
                        <a href="action_page?Approve_expense=<?php echo $row['expense_ID']?>&&Approver=<?php echo $_SESSION['user_id']; ?>" class="btn btn-success btn-sm" style="padding-top: 0px;padding-bottom: 0px; border-radius: 10px;"><i class="fas fa-edit"> Approve</i></a>
                      <?php }elseif($row['expense_status'] == '1'){ ?>
                        <a href="action_page?Hidding_expense=<?php echo $row['expense_ID']?>&&Hidder=<?php echo $_SESSION['user_id']; ?>" class="btn btn-danger btn-sm" style="padding-top: 0px;padding-bottom: 0px; border-radius: 5px;"><i class="fas fa-track"> Hide</i></a>
                      <?php }else{?>
                        <button type="button" class="btn btn-info btn-sm" style="padding-top: 0px;padding-bottom: 0px; border-radius: 5px;"><i class="fas fa-edit"> Hidden</i></button>
                      <?php } ?>
                      </div>
                    </td>
                    <?php } ?>
                  </tr>
                  <?php 
                  $total_amount_ = $total_amount_+$amount;
                } ?>

                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">
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


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1DB0D8;">
            <h4 class="modal-title"><i class="fas fa-plus"> ADD EXPENSE</i> </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

        <form action="action_page" method="POST">
        <div class="form-group">
            <label for="cat_decription">Bank Slip Number:</label>
            <input type="text"required="required" class="form-control" id="bank_number" placeholder="Enter Bank Slip Number" name="bank_number">
          </div>
          
          <div class="form-group">
            <label for="cat_decription">Expense Amount:</label>
            <input type="number"required="required" class="form-control" id="expense_amount" placeholder="Enter amount Rwf" name="expense_amount">
            <input type="hidden"  id="expense_amount" value="<?php echo $_SESSION['branch']?>" name="branch_id">
            <input type="hidden"  id="expense_amount" value="<?php echo $_SESSION['user_id']?>" name="user_id">
          </div>

          <div class="form-group">
            <label for="cat_decription">Expense Reason:</label>
            <textarea required="required" autofocus='autofocus' name="expense_reason" rows="3" placeholder="Enter the expense reason" class="form-control">
              </textarea>
          </div>
          
        
        </div>
        <div class="modal-footer">
        <button type="submit" name="send_expenses" class="btn btn-success btn-sm"><i class="fas fa-plus"> SAVE</i></button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
        </form>
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
