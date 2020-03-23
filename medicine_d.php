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
          <li class="breadcrumb-item active">Medecine details</li>
        </ol>
       <?php
?> 
      <div id="messages">
      <?php
        if (isset($_SESSION['med_updated'])) {
          # code...
          echo $_SESSION['med_updated'];
          unset($_SESSION['med_updated']);
              // unset($_SESSION['med_name']);
              // unset($_SESSION['med_ID']); 
              // unset($_SESSION['category']);
              // unset($_SESSION['batch_No']);
              // unset($_SESSION['category_name']);
          echo '<script>
         setTimeout(function(){ 
            window.location.href = "medical_list";
         }, 2000);
      </script>';
        }
?>  
      </div>  
   
<?php
  # code...
//if (isset($_GET['med_edit']) && isset($_GET['med_name'])) {

    /*$sql = "SELECT * FROM `medical_product`
            INNER JOIN `medical_category` ON medical_product.category = medical_category.category_ID WHERE  product_ID='$_GET[med_edit]'";
            
    $query = $conn->query($sql);*/

    $sql2 = "SELECT * FROM `medical_category` ORDER BY category_ID ASC";
    $query2 = $conn->query($sql2);
    //include 'export.php';
    ?>
  <!-- DataTables Example -->
  <div class="card mb-3">
    <div class="card-header">
    <!--  -->
    
      <h5>Details of medicine product</h5>
      </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Product Name</th>
              <!-- <th>Bacth No</th> -->
              <th>Category</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Product Name</th>
              <!-- <th>Bacth No</th> -->
              <th>Category</th>
            </tr>
          </tfoot>
          <tbody style="padding: 0px;">
            <?php
            $inc = 1;
            //$row = $query->fetch_assoc();

            ?>
            <tr>
              <td>
                <?php echo $inc; ?>
              </td>
              <td>
                <?php echo $_SESSION['med_name']; ?>
              </td>
              <!-- <td>  
                <?php //echo $_SESSION['batch_No']; ?>
              </td> -->
              <td>
                <?php echo $_SESSION['category_name']; ?>
              </td>

            </tr>
        </div>
      <?php
       $inc++; //} 
        
      ?>
    </div>
                                   
                </tbody>
              </table>

                  <form action="action_page.php" method="post">
                    <div class="form-group">
                      <label for="med_name">Name:</label>
                      <input type="hidden" name="med_ID" value="<?php echo $_SESSION['med_ID']; ?>">
                      <input  value="<?php echo $_SESSION['med_name']; ?>" type="text" class="form-control" id="med_name" placeholder="<?php echo $_SESSION['med_name']; ?>" name="med_name" >
                    </div>
                   
                    <div class="form-group">
                      <label for="pwd">Category:</label>
                      <select name="med_category" class="form-control">
                        <option value="<?php echo $_SESSION['category']; ?>"><?php echo $_SESSION['category_name']; ?></option>
                         <?php 
                      while($categories = $query2->fetch_assoc()){
                        ?>
                          <option value="<?php echo $categories['category_ID']; ?>"><?php echo $categories['category_name']; ?></option>
                        <?php
                      }
                     ?>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-success" name="med_update"><i class="fas fa-save"></i> Update</button>
                  </form>
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

<?php //} ?>
