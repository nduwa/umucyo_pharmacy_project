<?php 
    include('includes/head_tag.php'); 
    include('database_connection.php'); 
?>
<style>
  .product_image{
    height:200px;
  }
  .product_name{
    height:80px; 
    padding-left:20px; 
    padding-right:20px;
  }
  .product_footer{
    padding-left:20px; 
    padding-right:20px;
  }
</style>
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
    <div class="card-header">
    <!--  -->
      <!-- <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"style="float: right;">
        <i class="fas fa-plus"></i>
            New user
      </button>
      <form action="action_page.php" method="post" style="float: right;">
              <button type="submit" id="export" name='export_user' value="Export to excel" class="btn btn-primary btn-sm">
                <i class="fas fa-file-excel"></i>
                    Export to excel
              </button> 
            </form> -->
      <h5>List of User Level</h5>
     
      <div><?php 
          if (isset($_SESSION['reg_msg'])) {
            echo $_SESSION['reg_msg'];
            unset($_SESSION['reg_msg']);
          }
          ################## right ############
          
          if (isset($_REQUEST['edit'])) {
            $label = "Update Post:";
            $act = "update_place";
            $name = $_REQUEST['edit'];
            $id = $_REQUEST['id']; 
          }
          else {
            $label = "New Role:";
            $act = "new_level";
            $name = "";
            $id = ""; 
          }
          ?>
          </div>
        </div>
        <div class="card-body">
        <div class="box">
            <div class="box-header">
              
              
              <?php //if ($row_post['add_posts'] == 1) { ?>
              <div class="pull-right">
                <form action="action_page" method="post">
                  <label><?php echo $label; ?></label>
                  <input type="text" name="post" value="<?php echo $name; ?>" placeholder="New Role.." required>
                  <button type="submit" name="<?php echo $act; ?>" value="<?php echo $id; ?>">
                    <i class="fa fa-save text-blue"></i></button>
                </form>
              </div>
              <?php// } ?>
              
            </div>

            <?php
          
            if($_SESSION['role_id'] == 1){
              $sql = "SELECT * FROM user_role 
              INNER JOIN phar_institution ON user_role.institution_code=phar_institution.institution_code
              ORDER BY role_name ASC";
              $result = $conn->query($sql);
            }else{
              $sql = "SELECT * FROM user_role WHERE institution_code='$_SESSION[institution_code]'
              ORDER BY role_name ASC";
              $result = $conn->query($sql);
            }
            if ($result->num_rows > 0) {
            ?>

            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed ">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Psot Title</th>
                  <?php if($_SESSION['role_id'] == 1){?>
                  <th>INSTITUTION</th>
                  <?php } ?>
                  <th class="pull-right">Action</th>
                </tr>
                <?php
                $n = 1;
                while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                  <td><?php echo $n; ?></td>
                  <td><?php echo $row['role_name']; ?></td>
                  <?php if($_SESSION['role_id'] == 1){?>
                  <td><?php echo $row['institution_name']; ?></td> 
                  <?php } ?>
                  <td class="pull-right">
                    <?php //if ($row_post['act_posts'] == 1) { ?>
                    <a href="?edit=<?php echo $row['role_name']; ?>&id=<?php echo $row['role_id']; ?>" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Edit</a><?php// } ?>
                    <?php //if ($row_post['user_access'] == 1) { ?>
                    <a href="user_access?id=<?php echo $row['role_id']; ?>" class="btn-sm btn btn-info">
                      <i class="fa fa-gears"></i> Privilege</a><?php// } ?>
                  </td>
                </tr>
                <?php $n++; } ?>
              </table>
            </div>
            <!-- /.box-body -->
            <?php }
            else {
              echo "There is no Post available!";
            } ?>
          </div>
          <!-- /.box -->
        </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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
            <h4 class="modal-title">PHARMACY USERS</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

        <form action="action_page.php" method="POST">
          <div class="form-group">
            <label for="name">First Name:</label>
            <input type="text" class="form-control" id="first_name" placeholder="Enter the First Name" name="first_name">
          </div>

          <div class="form-group">
            <label for="name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" placeholder="Enter the First Name" name="last_name">
          </div>
          
          <div class="form-group">
            <label for="name">Email:</label>
            <input type="email" class="form-control" id="user_email" placeholder="Enter the Last Name" name="user_email">
          </div>

          <div class="form-group">
            <label for="name">Phone:</label>
            <input type="number" class="form-control" id="user_phone" placeholder="Enter the user phone" name="user_phone">
            <input type="hidden" class="form-control" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" name="user_id">
          </div>
          <div class="form-group">
            <label for="name">Branch Name:</label>
            <select class="form-control" name="branch_ID">
                <option selected="selected" disabled="disabled">SELECT BRANCH NAME</option>
                <?php
                $stmt = $conn->query("SELECT * FROM `phar_branch` ");
                while ($row = $stmt->fetch_assoc()) {?>
                    <option value="<?php echo $row['branch_ID']; ?>"><?php echo $row['branch_name'];?></option>
                <?php } ?>
            </select>
          </div> 

          <div class="form-group">
            <label for="name">Role:</label>
            <select class="form-control" name="role_id">
                <option selected="selected" disabled="disabled">SELECT ROLE NAME</option>
                <?php
                $stmt = $conn->query("SELECT * FROM `user_role` WHERE role_id !=1");
                while ($row = $stmt->fetch_assoc()) {?>
                    <option value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name'];?></option>
                <?php } ?>
            </select>
          </div> 

          <div class="form-group">
            <label for="name">Username:</label>
            <input type="text" class="form-control" id="username" name="username"placeholder="Enter the user Name">
          </div>
          
          <div class="modal-footer">
          <button type="submit" class="btn btn-success" name="pharmacy_users_registration"><i class="fas fa-plus"> ADD</i></button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
        </form>
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
