<?php include('includes/head_tag.php'); ?>

<body id="page-top">

  <?php include('includes/menu.php'); ?>
    <div id="content-wrapper" style="">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Medecine category</li>
        </ol>
        <div id="messages">
      <?php
        if (isset($_SESSION['imported'])) {
          # code...
          echo $_SESSION['imported'];
          unset($_SESSION['imported']);
          echo '<script>
         setTimeout(function(){
            window.location.href = "medecine_cat";
         }, 10000);
      </script>';
        }

?>  
      </div> 

        <!-- DataTables Example -->
        <div class="card col-md-12">
          <div class="card-header">
            <?php  if($rows['export_medecine_cat']== 1) {?>
            <form action="action_page.php" method="post"style="float:right;">
              <button type="submit" id="export_category" name='export_category' value="Export to excel" class="btn btn-primary btn-sm">
                <i class="fas fa-file-excel"></i>
                    Export to excel
              </button> 
            </form>
          <?php } if($rows['new_medecine_cat']== 1) { ?>
            <span><button style="float:right;margin-right: 5px;" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#import_category">
          <i class="fas fa-file-upload"></i>
              Import medicine category
        </button></span>
            <button style="float:right;margin-right: 5px;" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">
              <i class="fas fa-plus"></i>
                 Add medecine category
            </button>
            <?php  } ?>
            </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Branch</th>
                    <th>Done By</th>
                    <?php  if($rows['new_medecine_cat']== 1) { ?>
                    <th>Action</th>
                    <?php  } ?>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Branch</th>
                    <th>Done By</th>
                    <?php  if($rows['new_medecine_cat']== 1) { ?>
                    <th>Action</th>
                    <?php  } ?>
                  </tr>
                </tfoot>
                <tbody>
                  <?php 
                  if($_SESSION['role_id'] == 3){
                    $sql = "SELECT * FROM `medical_category`
                    INNER JOIN `login` ON medical_category.user_id = login.user_id
                    INNER JOIN `phar_branch` ON medical_category.branch_ID = phar_branch.branch_ID
                    WHERE medical_category.institution_code = '$_SESSION[institution_code]'";
                    $query = $conn->query($sql);
                  }else{
                    $sql = "SELECT * FROM `medical_category`
                    INNER JOIN `login` ON medical_category.user_id = login.user_id
                    INNER JOIN `phar_branch` ON medical_category.branch_ID = phar_branch.branch_ID
                    WHERE medical_category.branch_ID ='$_SESSION[branch]' 
                    AND medical_category.institution_code = '$_SESSION[institution_code]'";
                    $query = $conn->query($sql);
                  }
                      if(!empty($query)){
                    while($row = $query->fetch_assoc()){?>
                 
                 <tr>
                    <td><?php echo $row['category_ID']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo $row['category_desc']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                    <?php  if($rows['new_medecine_cat']== 1) { ?>
                    <td>
                      <div class="xs">
                        <!-- <a href="?delete=<?php// echo $row['category_name']; ?>">
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal" style="padding-top: 0px;padding-bottom: 0px; border-radius: 10px;"><i class="fas fa-trash"> Delete</i></button>
                        </a> -->
                        <a href="?delete=<?php echo $row['category_ID']; ?>">
                          <button type="button" class="btn btn-info btn-sm" style="padding-top: 0px;padding-bottom: 0px; border-radius: 5px;"><i class="fas fa-edit"> Edit</i></button>
                        </a>
                      </div>
                    </td>
                    <?php  } ?>
                  </tr>
                  <?php } }?>

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

   <!-- import_category Modal--import_category
   <div class="modal fade" id="import_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1DB0D8;">
          <h5 class="modal-title"><i class="fas fa-plus"> ADD MEDECINE CATEGORY</i></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="outer-container">
            <form action="action_page" method="post" name="frmExcelImport"
             id="frmExcelImport" enctype="multipart/form-data">
          <div>
            <label>Choose Excel
                File</label> <input type="file" name="file"
                id="file" accept=".xls,.xlsx">
            <!-- <button type="submit" id="submit" name="import" class="btn-submit">
                Import
            </button> --
        </form>
        
    </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit" id="submit_category" name="submit_category" class="btn-submit">
                Import
            </button>
        </div>
      </div>
    </div>
  </div>--->


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1DB0D8;">
            <h4 class="modal-title"><i class="fas fa-plus"> ADD MEDECINE CATEGORY</i> </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

        <form action="action_page" method="POST">
          <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" class="form-control" id="category" placeholder="Enter category name" name="category_name">
          </div>
          <div class="form-group">
            <label for="cat_decription">Description:</label>
            <input type="text" class="form-control" id="cat_decription" placeholder="Enter category Description" name="cat_decription">
            <input type="hidden" class="form-control" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" name="user_id">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-sm"name="add_new_category"><i class="fas fa-plus"> ADD</i></button>
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
