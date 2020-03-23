<?php
include('includes/head_tag.php');

?>
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
          
          <li class="breadcrumb-item active">Purchased inventored Quantity </li>
        </ol>
        

<!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
    <!--  -->
     
      <h5>List of Purchased inventored Quantity</h5>
      </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Batch</th>
                    <th>Category</th>
                    <th>Purchase price</th>
                    <th>Selling price</th>
                    <th>Quantity</th>
                    <th>Expire date</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Batch</th>
                    <th>Category</th>
                    <th>Purchase price</th>
                    <th>Selling price</th>
                    <th>Quantity</th>
                    <th>Expire date</th>
                    <th>Option</th>
                  </tr>
                </tfoot>
                <tbody>
        <?php
                      if($_SESSION['role_id'] == 3){
                      $sql = "SELECT * FROM purchase_medical_product 
                             INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
                            INNER JOIN `medical_category` ON purchase_medical_product.product_category = medical_category.category_ID 
                          WHERE purchase_medical_product.institution_code = '$_SESSION[institution_code]' AND purchase_medical_product.medical_source = '2'
                          GROUP BY purchase_medical_product.product_name";
                          $query = $conn->query($sql);
                    }else{
                      $sql = "SELECT * FROM purchase_medical_product 
                              INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
                              INNER JOIN `medical_category` ON purchase_medical_product.product_category = medical_category.category_ID 
                              WHERE purchase_medical_product.institution_code = '$_SESSION[institution_code]' AND purchase_medical_product.branch_ID ='$_SESSION[branch]' AND purchase_medical_product.purchase_status ='1' AND purchase_medical_product.medical_source = '2'
                              GROUP BY CONCAT(purchase_medical_product.product_name, '_', purchase_medical_product.batch_number)  ";
                      $query = $conn->query($sql);
                    }
                    $inc = 4;
                    while($row = $query->fetch_assoc()){
                     ?>
                  <tr>
                    <td><?php echo $row['purchase_date']; ?></td> 
                    <td><?php echo $row['product_Nmae']; ?></td>      
                    <td>
                        <?php echo $row['batch_number']; ?>
                    </td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>
                      <p class="pull-left"><b><?php echo $row['purchase_price'].' Frw'; ?></b></p>
                    </td>
                    <td>
                      <p class="pull-left"><b><?php echo $row['selling_price'].' Frw'; ?></b></p>
                    </td>
                    <td><?php echo $row['product_quantity']; ?></td> 
                    
                    <td><?php echo $row['expired_date']; ?></td> 
                    <td >
                      <span class="pull-right" style="float: left; "><i style=" color:blue; ">Inventored!!</i>
                      </span>
                    </td>
                </tr>
              <?php } ?>      
      </tbody>
    </table>
  </div>
</div>
<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div></div>

</div>

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