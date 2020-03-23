<?php 
    include('includes/head_tag.php');

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
    <div id="content-wrapper" >
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Medecine</li>
        </ol>
       <?php
  /*//session_start();
  //initialize cart if not set or is unset
  if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
  }

  //unset qunatity
  //unset($_SESSION['qty_array']);*/
?> 
		  <div id="messages">
      <?php
      if (isset($_SESSION['inserted_medical'])) {
        # code...
        echo $_SESSION['inserted_medical'];
        unset($_SESSION['inserted_medical']);
        echo '<script>
       setTimeout(function(){
          window.location.href = "medical_list";
       }, 10000);
    </script>';
      }
        if (isset($_SESSION['imported'])) {
          # code...
          echo $_SESSION['imported'];
          unset($_SESSION['imported']);
          echo '<script>
         setTimeout(function(){
            window.location.href = "medical_list";
         }, 10000);
      </script>';
        }
        if (isset($_SESSION['med_deleted'])) {
          # code...
          echo $_SESSION['med_deleted'];
          unset($_SESSION['med_deleted']);
          echo '<script>
         setTimeout(function(){
            window.location.href = "medical_list";
         }, 5000);
      </script>';
        }
?>  
      </div>  
   
<?php
if($_SESSION['role_id'] == 3){
    $sql = "SELECT * FROM `medical_product`
            INNER JOIN `medical_category` ON medical_product.category = medical_category.category_ID
            INNER JOIN `phar_branch` ON medical_product.branch_ID = phar_branch.branch_ID
             WHERE  medical_product.institution_code = '$_SESSION[institution_code]' ";
      $query = $conn->query($sql);
}else{
  $sql = "SELECT * FROM `medical_product`
          INNER JOIN `medical_category` ON medical_product.category = medical_category.category_ID
          INNER JOIN `phar_branch` ON medical_product.branch_ID = phar_branch.branch_ID
          WHERE medical_product.branch_ID = '$_SESSION[branch]' AND medical_product.institution_code = '$_SESSION[institution_code]' ";
      $query = $conn->query($sql);
}
    //include 'export.php';
		?>
  <!-- DataTables Example -->
  <div class="card mb-3">
    <div class="card-header">
    <!--  -->
    <?php if($rows['new_medecine']== 1) { ?>
    <i style="float: right; display: inline-block;">

      <span><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#new_medicine">
        <i class="fas fa-plus"></i>
            New Medical Product
      </button></span>
      <span><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#new_medicine_import">
        <i class="fas fa-file-upload"></i>
            Import medicine
      </button></span>
      </i>
    <?php  } if($rows['export_medecine']== 1) {?>
      <i style="float: right; display: inline-block; margin-right: 5px;">
      <span style="">
      <!--<form action="export.php" method="post">-->
        <a href="export">
      <button type="submit" id="export" value="Export to excel" class="btn btn-primary btn-sm pull-right">
        <i class="fas fa-file-excel"></i>
            Export to excel
      </button> 
    </a>
    <!--</form>-->
  </span>
    </i>
    <?php  } ?>
      <h5>List of medical product</h5>
      </div><i>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Product Name</th>
              <th>Branch</th>
              <th>Category</th>
              <?php if($rows['remove_medecine']== 1){ ?>
              <th>ACTION</th>
              <?php  } ?>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Product Name</th>
              <th>Branch</th>
              <th>Category</th>
              <?php if($rows['remove_medecine']== 1){ ?>
              <th>ACTION</th>
              <?php  } ?>
            </tr>
          </tfoot>
          <tbody style="padding: 0px;">
            <?php
            if(!empty($query)){
            $inc = 1;
            while($row = $query->fetch_assoc()){
              
            ?>
            <tr>
              <td>
                <?php echo $inc; ?>
              </td>
              <td>
                <?php echo $row['product_Nmae']; ?>
              </td>
              <td>	
                <?php echo $row['branch_name']; ?>
              </td> 
              <td>
                <?php echo $row['category_name']; ?>
              </td>
              <?php if($rows['remove_medecine']== 1){ ?>
              <td>
                <a href="action_page?edit=<?php echo $row['product_ID']; ?>" class="btn btn-info btn-sm" style="padding-top: 0px;padding-bottom: 0px; border-radius: 5px; font-size: 100%;">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="action_page.php?delete=<?php echo $row['product_ID']; ?>&&med_name=<?php echo $row['product_Nmae'];  ?>" class="btn btn-danger btn-sm" style="padding-top: 0px;padding-bottom: 0px; border-radius: 5px; font-size: 100%;">
                  <i class="fas fa-trash"> </i>
                </a>
              </td>	
              <?php  }$inc++;
            } ?>
            </tr>
        </div>
			<?php
       $inc++; } 
        
	    ?>
    </div>
                                   
                </tbody>
              </table></i>
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
  <div class="modal fade" id="new_medicine_import" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1DB0D8;">
            <h4 class="modal-title"><i class="fas fa-plus"> NEW MEDECINE PRODUCT</i></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="outer-container">
            <form action="action_page.php" method="post" name="frmExcelImport"
             id="frmExcelImport" enctype="multipart/form-data">
          <div>
            <label>Choose Excel
                File</label> <input type="file" name="file"
                id="file" accept=".xls,.xlsx">
            <button type="submit" id="submit" name="import" class="btn-submit">
                Import
            </button>
        
            </div>
        
        </form>
        
    </div>
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

  <!-- Modal -->
  <div class="modal fade" id="new_medicine" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1DB0D8;">
            <h4 class="modal-title"><i class="fas fa-plus"> NEW MEDECINE PRODUCT</i></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

        <form action="action_page" method="POST">
          <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name of medecine" name="name">
          </div>
          <!-- <div class="form-group">
            <label for="name">Batch No:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter Batch No" name="batch">
          </div> -->
          <div class="form-group">
          <label for="name">Category:</label>
          <select class="form-control" name="category">
               <option selected="selected" disabled="disabled">SELECT THE MEDECINE CATEGORY</option>
              <?php
              if($_SESSION['role_id'] == 2){
              $stmt = $conn->query("SELECT * FROM `medical_category` WHERE institution_code = '$_SESSION[institution_code]'");
              }else{
                $stmt = $conn->query("SELECT * FROM `medical_category` WHERE branch_ID ='$_SESSION[branch]' 
                AND institution_code = '$_SESSION[institution_code]'");
              }
              if($stmt->num_rows>0){
              while ($row = $stmt->fetch_assoc()) {?>
                  <option value="<?php echo $row['category_ID']; ?>"><?php echo $row['category_name'];?></option>
              <?php }} ?>
            </select>
          </div>
          
          <div class="modal-footer">
          <button type="submit" class="btn btn-success" name="save_new_medical_product"><i class="fas fa-plus"> ADD</i></button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
        </form>
        </div>
        
      </div>
      
    </div>
  </div>
</html>
