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
          <li class="breadcrumb-item active">Purchase Medecine</li>
        </ol>
       <?php
        $sql = "SELECT * FROM `medical_selling_price`
        INNER JOIN `medical_product` ON medical_selling_price.product_ID = medical_product.product_ID
        INNER JOIN `login` ON medical_selling_price.user_id = login.user_id 
        WHERE selling_price_status = '1' AND medical_selling_price.branch_ID = '$_SESSION[branch]'";
		$query = $conn->query($sql);
		?>
  <!-- DataTables Example -->
  <div class="card mb-3">
    <div class="card-header">
    <!--  -->
      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"style="float: right;">
        <i class="fas fa-plus"></i>
            New selling price
      </button>
      <h5>List of selling prices of medical product</h5>
      </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Selling_price</th> 
              <th>Done By</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
          <tr>
              <th>Product Name</th>
              <th>Selling_price</th> 
              <th>Done By</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody style="padding: 0px;">
            <?php
            $status = '';
            while($row = $query->fetch_assoc()){
              if($row['selling_price_status'] == '1'){
                $status = "<span class='badge badge-success'>Activated</span>";
              } 

            ?>
            <tr>
              <td>
                <?php echo $row['product_Nmae']; ?>
              </td>
              <td>	
                <?php echo $row['selling_price']." Frw"; ?>
              </td>
              <td>
                <p class="pull-left">
                  <b><?php echo $row['first_name']." ".$row['last_name']; ?></b>
                </p>
              </td>	
              <td>
                <p class="pull-left">
                  <?php echo $status; ?>
                </p>
              </td>	
            </tr>
        </div>
			<?php
        }
        
        
        //end product row 
	    ?>
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
            <h4 class="modal-title">PURCHASE MEDICAL PRODUCT</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <form action="action_page.php" method="POST">
          <div class="form-group">
            <label for="name">Product Name:</label>
            <select class="form-control" name="product_ID">
                <option selected="selected" disabled="disabled">SELECT MECINE</option>
                <?php
                $stmt = $conn->query("SELECT * FROM `medical_product`WHERE branch_ID = '$_SESSION[branch]'");
                while ($row = $stmt->fetch_assoc()) {?>
                    <option value="<?php echo $row['product_ID']; ?>"><?php echo $row['product_Nmae'];?></option>
                <?php } ?>
            </select>
          </div>         
          <div class="form-group">
            <label for="name">Selling Price:</label>
            <input type="number" class="form-control" id="selling_price" placeholder="Enter the Selling Price" name="selling_price">
            <input type="hidden" class="form-control" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" name="user_id">
          </div>   
          <div class="modal-footer">
          <button type="submit" class="btn btn-success" name="medical_selling_price"><i class="fas fa-plus"> SAVE</i></button>
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
