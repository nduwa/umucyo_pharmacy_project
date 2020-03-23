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
          <li class="breadcrumb-item active">Pharmacy Branches </li>
        </ol>

  <!-- DataTables Example -->
  <div class="card mb-3">
    <div class="card-header">
    <!--  -->
      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"style="float: right;">
        <i class="fas fa-plus"></i>
            New Branch
      </button>
      <h5>List of Pharmacy Branches</h5>
      </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
                <tr>
                    <th>Branch Name</th>
                    <th>Province</th>  
                    <th>District</th>
                    <th>Region</th>
                    <th>ACTION</th>
                </tr>
          </thead>
          <tfoot>
                <tr>
                    <th>Branch Name</th>
                    <th>Province</th>  
                    <th>District</th>
                    <th>Region</th>
                    <th>ACTION</th>
                </tr>
          </tfoot>
          <tbody style="padding: 0px;">
            <?php
                $sql = "SELECT * FROM `phar_branch`WHERE institution_code ='$_SESSION[institution_code]'";
                $query = $conn->query($sql);
                while($row = $query->fetch_assoc()){
                  $branch_ID        = $row['branch_ID'];
                  $branch_name      = $row['branch_name'];
                  $branch_province  = $row['branch_province'];
                  $brannch_district = $row['brannch_district'];
                  $branch_region    = $row['branch_region'];
                  $inserted_date    = $row['inserted_date'];
                  $branch_status    =  $row['branch_status'];
                   // ####### Access to Donors Activities
                  if ($branch_status == '0') { 
                    $status = "OFF"; 
                    $user_status_view = "fa-toggle-off "; 
                    $st = "color: red;";
                    $user_ = 1; 
                }
                  else { 
                    $status = "ON"; 
                    $user_status_view = "fa-toggle-on";
                    $st = "color: green;";
                     $user_ = 0; 
                    }
                      
               
             
            ?>
            <tr>
              <td>
                <?php echo $branch_name; ?>
              </td>
              <td>	
                <?php echo $branch_province; ?>
              </td>
              <td>
                <?php echo $brannch_district; ?>
              </td>
              <td>
                <?php echo $branch_region; ?>
              </td> 
              <td>
                <a href="action_page.php?branch_status&status=<?php echo $user_;?>&&branch_ID=<?php echo $branch_ID; ?>">
                    <i class="fa <?php echo $user_status_view; ?>" style="<?php echo $st; ?>"> <?php echo $status; ?></i> 
                </a>
              </td>	
            </tr>
        </div>
			<?php }  ?>
    </div>
                  
                  
                </tbody>
              </table>
            </div>
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
            <h4 class="modal-title">PHARMACY BRANCH</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

        <form action="action_page.php" method="POST">
          <div class="form-group">
            <label for="name">Branch Name:</label>
            <input type="text" class="form-control" id="branch_name" placeholder="Enter the Branch Name" name="branch_name">
          </div>

          <div class="form-group">
            <label for="name">Province Name:</label>
            <select class="form-control" name="province_name">
               <option selected="selected" disabled="disabled">SELECT THE PROVINCE NAME</option>
                <option>Northern</option>
                <option>Eastern</option>
                <option>Southern</option>
                <option>Western</option>
                <option>Kigali City</option>
            </select>
          </div>
          
          <div class="form-group">
          <label for="name">District:</label>
          <input type="text" class="form-control" id="district_name" placeholder="Enter the District Name" name="district_name">
          </div>
          <div class="form-group">
            <label for="name">Region:</label>
            <input type="text" class="form-control" id="region" placeholder="Enter the Region" name="region">
            <input type="hidden" class="form-control" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" name="user_id">
          </div>
          
          
          <div class="modal-footer">
          <button type="submit" class="btn btn-success" name="save_branch"><i class="fas fa-plus"> ADD</i></button>
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
