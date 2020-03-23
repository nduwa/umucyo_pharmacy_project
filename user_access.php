<?php 
    include('includes/head_tag.php'); 
    include('database_connection.php'); 
?>

	<!--<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">-->
</head>
<body id="page-top">
  <?php include('includes/menu.php'); ?>
    <div id="content-wrapper" style="">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Pharmacy Users </li>
        </ol>

  <!-- DataTables Example -->
  <div class="card col-md-12">
  <?php
    if (isset($_REQUEST['edit'])) {
      $label = "Update Post:";
      $act = "update_post";
      $name = $_REQUEST['edit'];
      $id = $_REQUEST['id']; 
    }
    else {
      $label = "Add Post:";
      $act = "new_post";
      $name = "";
      $id = ""; 
    }
    ?>

    <?php
    if(isset($_GET['id'])){
    $role = $_GET['id'];
    $sql = "SELECT * FROM user_privilegies WHERE role_id = '$role'";
    $result = $conn->query($sql);
    $row_access = $result->fetch_assoc();
    ?>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
      <?php //echo $role; ?>
<!-- ########################### Privileges About Giving Privileges ########################## -->
          <div class="box col-md-4" style=" padding: 10px; border: solid 1px #ccc;">
            <div class="box-header">
              <h5 class="box-title">Access Autorisation <i class="fa fa-exclamation-circle" title="Display on whole, Delete, Hide Form Whole"></i></h5>
            </div>

            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
          

                <?php // ####### Action On Teen Users
                if ($row_access['acc_privilegie'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Users Access Privilegies</td>
                  <td>
                    <a href="action_page?acc_privilegie&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                  <?php // ####### Action On access on medecine list
                if ($row_access['acc_medecine'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access To Medecine </td>
                  <td>
                    <a href="action_page?acc_medecine&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                      <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On list of medecine
                if ($row_access['acc_medecine_list'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access To  Medecine list</td>
                  <td>
                    <a href="action_page?acc_medecine_list&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On purchased medecine
                if ($row_access['acc_purchased'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access To Purchased Medecine</td>
                  <td>
                    <a href="action_page?acc_purchased&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On  medecine category
                if ($row_access['acc_medecine_cat'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access To  Medecine Category</td>
                  <td>
                    <a href="action_page?acc_medecine_cat&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On management part expenses,income
                if ($row_access['acc_management'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access To Management Part</td>
                  <td>
                    <a href="action_page?acc_management&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On serve medecine
                if ($row_access['acc_to_serve'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access To Serve Medecine</td>
                  <td>
                    <a href="action_page?acc_to_serve&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action to all served medecine
                if ($row_access['acc_all_served'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access To all Served Medecine</td>
                  <td>
                    <a href="action_page?acc_all_served&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>
                
                <?php // ####### Action to the branches
                if ($row_access['acc_branches'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access to the pharmacy branches</td>
                  <td>
                    <a href="action_page?acc_branches&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action to the pharmacy manager
                if ($row_access['acc_manager_report'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access to the pharmacy Reports</td>
                  <td>
                    <a href="action_page?acc_manager_report&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action to the pharmacy users
                if ($row_access['acc_pharmacy_user'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access to the pharmacy Users</td>
                  <td>
                    <a href="action_page?acc_pharmacy_user&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>
                

                <?php // ####### Action to the pharmacy transaction
                if ($row_access['acc_transaction'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Access to the transaction</td>
                  <td>
                    <a href="action_page?acc_transaction&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
<!----################################################################----->
          <div class="box col-md-4" style=" padding: 10px; border: solid 1px #ccc;">
            <div class="box-header">
              <h5 class="box-title">Add, Edit, Delete, Aprove <i class="fa fa-exclamation-circle" title="Display on whole, Delete, Hide Form Whole"></i></h5>
            </div>

            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
          
                <?php // ####### Action On add, import, export medecine
                if ($row_access['new_medecine'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Add, Import medecine</td>
                  <td>
                  <a href="action_page?new_medecine&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On add, import, export medecine
                if ($row_access['export_medecine'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td> Export medecine</td>
                  <td>
                  <a href="action_page?export_medecine&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                  <?php // ####### Action On remove, edit medecine
                if ($row_access['remove_medecine'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Edit, Delete Medecine</td>
                  <td>
                  <a href="action_page?remove_medecine&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On add, import, export medecine
                if ($row_access['new_medecine_cat'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Add, Import medecine category</td>
                  <td>
                  <a href="action_page?new_medecine_cat&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On add, import, export medecine
                if ($row_access['export_medecine_cat'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td> Export medecine category</td>
                  <td>
                  <a href="action_page?export_medecine_cat&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On add, import, export medecine
                if ($row_access['new_expenses'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td> New expenses</td>
                  <td>
                  <a href="action_page?new_expenses&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On add, import, export medecine
                if ($row_access['approve_expenses'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td> Approve and Hide expenses</td>
                  <td>
                  <a href="action_page?approve_expenses&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On add, import, export medecine
                if ($row_access['new_incomes'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td> New Incomes</td>
                  <td>
                  <a href="action_page?new_incomes&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On add, import, export medecine
                if ($row_access['approve_incomes'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td> Approve and Hide expenses</td>
                  <td>
                  <a href="action_page?approve_incomes&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On add, import, export medecine
                if ($row_access['new_purchase'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td> Add, Import the purchased medecine</td>
                  <td>
                  <a href="action_page?new_purchase&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On transaction_refound done
                if ($row_access['transaction_refound'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>To Refound a Transction done</td>
                  <td>
                  <a href="action_page?transaction_refound&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>

                <?php // ####### Action On loan_recovery done
                if ($row_access['loan_recovery'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>Medical Loan Recovery </td>
                  <td>
                  <a href="action_page?loan_recovery&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>



              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
<!----################################################################----->
          <div class="box col-md-4" style=" padding: 10px; border: solid 1px #ccc;">
            <div class="box-header">
              <h5 class="box-title">Add, Edit, Delete, View <i class="fa fa-exclamation-circle" title="Display on whole, Delete, Hide Form Whole"></i></h5>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
          
                <?php // ####### Action On add, import, export medecine
                if ($row_access['view_current_quantity'] == 0) { 
                  $status = "OFF";$act_st = "fa-toggle-off color: red;";$act = 1;$st = "color: #00b8ff;";}
                else { $status = "ON"; $act_st = "fa-toggle-on";$act = 0;$st = "color: green;";}
                    ?>
                <tr>
                  <td>View the Current Quantity for Branches</td>
                  <td>
                  <a href="action_page?view_current_quantity&status=<?php echo $act; ?>&role=<?php echo $role; ?>">
                    <i class="fa <?php echo $act_st; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i>
                    </a>
                  </td>
                </tr>
              
               </table>
            </div>
            <!-- /.box-body -->
          </div>

      </div>
    </section>
  </div>
      
                <?php } ?>





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
