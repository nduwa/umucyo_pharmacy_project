<?php include('includes/head_tag.php'); ?>

<body id="page-top">

  <?php include('includes/menu.php'); ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">EDIT PURCHASED MEDICINE PRODUCT
          </li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <!-- <div class="card-header">
            
            <h5>List of Pharmacy Branches income</h5>
            </div> -->
          <div class="card-body">
            <div class="table-responsive">
<?php ########################################################################################  ?>
                      <!-- Modal -->
  <div class="">
    <div class="panel panel-default">
    
      <!-- Modal content-->
      <div class="modal-content">
        <center>
        <div class="modal-header" style="background-color: #1DB0D8;">
            <h4 class="modal-title">EDIT PURCHASED MEDICINE PRODUCT</h4>

        </div>
        </center>
        <div class="modal-body">
    <?php
    
    if (isset($_GET['med_batch']) && ($_GET['product_id'])) {
      # code...
      $_SESSION['batch'] = $_GET['med_batch'];
      $med_batch = $_GET['med_batch'];
      $p_id = $_GET['product_id'];
    $edit_purchased_medecine = "SELECT * FROM purchase_medical_product 
    INNER JOIN `medical_product` ON purchase_medical_product.product_name=medical_product.product_ID
    INNER JOIN medical_category ON  purchase_medical_product.product_category=medical_category.category_ID
     WHERE purchase_medical_product.institution_code='$_SESSION[institution_code]' AND purchase_medical_product.branch_ID='$_SESSION[branch]'
      AND md5(purchase_medical_product.batch_number)='$med_batch'  AND purchase_medical_product.purchase_status='1' 
      AND md5(purchase_medical_product.product_name)='$_GET[product_id]'";

    $medecine_to_edit = $conn->query($edit_purchased_medecine);
 
    if ($medecine_to_edit->num_rows > 0) {
      # code...
     $edit_med = $medecine_to_edit->fetch_assoc();

     ?>
        <form action="action_page.php" method="post" >
        <input type="hidden" value="<?php echo $p_id; ?>" name="purchase_id" >
          <div class="form-group">
            <label for="name">Product Name:</label>
            <select class="form-control" name="product_name">
               <option value="<?php echo $edit_med['product_ID']; ?>" selected="selected" >
                      <?php echo $edit_med['product_Nmae']; ?></option>
              <?php
              if($_SESSION['role_id'] == 2){
                $stmt = $conn->query("SELECT * FROM `medical_product` WHERE institution_code = '$_SESSION[institution_code]'");
                }else{
                  $stmt = $conn->query("SELECT * FROM `medical_product` WHERE branch_ID ='$_SESSION[branch]' 
                  AND institution_code = '$_SESSION[institution_code]'");
                }
              //$stmt = $conn->query("SELECT * FROM `medical_product`WHERE branch_ID = '$_SESSION[branch]'");
              while ($row = $stmt->fetch_assoc()) {?>
                  <option value="<?php echo $row['product_ID']; ?>"><?php echo $row['product_Nmae'];?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group">
            <label for="name">Category Name:</label>
            <select class="form-control" name="category">
               <option selected="selected" value="<?php echo $edit_med['category_ID']; ?>" ><?php echo $edit_med['category_name']; ?></option>
              <?php
              if($_SESSION['role_id'] == 2){
                $stmt = $conn->query("SELECT * FROM `medical_category` WHERE institution_code = '$_SESSION[institution_code]'");
                }else{
                  $stmt = $conn->query("SELECT * FROM `medical_category` WHERE branch_ID ='$_SESSION[branch]' 
                  AND institution_code = '$_SESSION[institution_code]'");
                }
              //$stmt = $connect->query("SELECT * FROM `medical_category`");
              while ($row = $stmt->fetch_assoc()) {?>
                  <option value="<?php echo $row['category_ID']; ?>"><?php echo $row['category_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
          <label for="name">Batch Number:</label>
          <input type="text" class="form-control" id="batch_number" value="<?php echo $edit_med['batch_number']; ?>" name="batch_number">
          </div>
          <div class="form-group">
          <label for="name">Purchase Price:</label>
          <input type="number" class="form-control" id="purchase_price" value="<?php echo $edit_med['purchase_price']; ?>" name="purchase_price">
          </div>
          <div class="form-group">
          <label for="name">Selling Price:</label>
          <input type="number" class="form-control" id="selling_prices" value="<?php echo $edit_med['selling_price']; ?>" name="selling_price">
          </div>
          <div class="form-group">
            <label for="name">Quantity:</label>
            <input type="number" class="form-control" id="quantity" value="<?php echo $edit_med['product_quantity']; ?>" name="quantity">
            <input type="hidden" class="form-control" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" name="user_id">
          </div>
          <div class="form-group">
            <label for="name">Expiration Date:</label>
            <input type="date" class="form-control" value="<?php echo $edit_med['expired_date']; ?>" id="expiration_date" name="expiration_date" >
          </div>
          
          <div class="modal-footer">
          <button type="submit" class="btn btn-success" name="edit_purchase_medical_product"><i class="fas fa-save"> SAVE</i></button>
          <a href="medecine_purchase" class="btn btn-warning" data-dismiss="modal">Cancel</a>
        </div>
        </form>

      <?php  } } ?>
        </div>
        
      </div>
      
    </div>
  </div>


<?php ########################################################################################  ?>

            </div>
          </div>
          
        </div>
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © PHARMACY MANAGEMENT SYSTEM</span>
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
