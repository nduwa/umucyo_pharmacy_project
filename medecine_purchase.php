<?php 
    include('includes/head_tag.php'); 
    include('database_connection.php'); 
    //$_SESSION['reg_msg_purchase'] = "";
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
  <?php include('includes/menu.php');
if (isset($_GET['med_batch'])) {
  # code...
  $med_batch = $_GET['med_batch'];
  $delete_purchased_medecine = "DELETE  FROM purchase_medical_product WHERE institution_code='$_SESSION[institution_code]' AND branch_ID='$_SESSION[branch]' AND md5(batch_number)='$med_batch' ";

  $medecine_deleted = $conn->query($delete_purchased_medecine);

  if ($medecine_deleted) {
    $_SESSION['purchased_medecine_deleted'] = '<div class="alert alert-success">
                         medecine deleted.
                          </div>';
    //header('Locatio: medecine_purchase');
    # code...
  }else{
    $_SESSION['purchased_medecine_deleted'] = '<div class="alert alert-danger">
                         medecine not deleted, Try again
                          </div>'.$conn->error;
      //header('Locatio: medecine_purchase');
  }
}
  ?>

    <div id="content-wrapper" style="">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Purchase Medecine</li>
          <li><h5 style="margin-left: 200px;">List of purchased medical product</h5></li>
        </ol>
        <div id="messages">
      <?php
        if (isset($_SESSION['reg_msg_purchase'])) {
          # code...
          echo $_SESSION['reg_msg_purchase'];
          unset($_SESSION['reg_msg_purchase']);
          echo '<script>
         setTimeout(function(){
            window.location.href = "medecine_purchase";
         }, 10000);
      </script>';
        }

?>  
      </div>
       
  <!-- DataTables Example -->
  <div class="card mb-3">
      <div>
      <?php
        if (isset($_SESSION['imported_purchased'])) {
          # code...
          echo $_SESSION['imported_purchased'];
          unset($_SESSION['imported_purchased']);
          echo '<script>
         setTimeout(function(){
            window.location.href = "medecine_purchase";
         }, 10000);
      </script>';
        } 
        if (isset($_SESSION['purchased_medecine_deleted'])) {
          # code...
          echo $_SESSION['purchased_medecine_deleted'];
                unset($_SESSION['purchased_medecine_deleted']);
                echo '<script>
               setTimeout(function(){
                  window.location.href = "ksjhdjshdjh@@@IUIIUKKkdfr";
               }, 10000);
            </script>';
        }
        if (isset($_SESSION['edited_medecine_purchased'])) {
          # code...
          echo $_SESSION['edited_medecine_purchased'];
                unset($_SESSION['edited_medecine_purchased']);
                echo '<script>
               setTimeout(function(){
                  window.location.href = "ksjhdjshdjh@@@IUIIUKKkdfr";
               }, 10000);
            </script>';
        }
        ?>
    </div>
    <div class="card-header">

    <?php if($_SESSION['role_id'] == 3){ ?>
            <!-- <button class="btn btn-info btn-sm" style="float: right;" onclick="CopyToClipboard('dataTable')">Copy Current Data</button>
 -->            
            <button class="alert alert-info alert-sm" style="margin-left: 0px;" onclick="CopyToClipboard('dataTable')">Copy Data</button>
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
    <!--  -->
    <?php if($rows['new_purchase']== 1) { ?>
      <span style="float: right;"> 
    <!--  -->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#new_purchase_medicine_import">
        <i class="fas fa-file-excel"></i>
            Import Purchase Medecine(Excel)
      </button> &nbsp;
      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"style="float: right;">
        <i class="fas fa-plus"></i>
            Purchase Medecine
      </button>
      </span>
      <?php  } ?>
      
      </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
           <thead>
          <tr>
              <th>Product Name</th>
              <th>Batch number</th>
              <th>Purchase Price</th> 
              <th>Selling Price</th>   
              <th>Quantity</th>
              <th>Exipired Date</th>
              <th>Done By</th>
              <?php if($rows['new_purchase']== 1) {?>
              <th>ACTION</th>
            <?php } ?>
            </tr>
          </thead>
          
          <tbody style="padding: 0px;">
            <?php
       
        $date1 = date("Y-m-d");
        $date2 = date("Y-m-d");
        //$_SESSION['br'] = $_SESSION['branch'];
        if(isset($_POST['find_report'])){
          $_SESSION['br'] = $_POST['branch_ID'];
          $date1 = $_POST['dateFrom'];
          $date2 = $_POST['dateTo'];
         
       if($_SESSION['role_id'] == 3){
        $sql = "SELECT *,product_quantity as quantity FROM `purchase_medical_product_backup`
        INNER JOIN `medical_product` ON purchase_medical_product_backup.product_name = medical_product.product_ID
        INNER JOIN `login` ON purchase_medical_product_backup.user_id = login.user_id 
        INNER JOIN `medical_category` ON purchase_medical_product_backup.product_category = medical_category.category_ID 
        WHERE purchase_medical_product_backup.institution_code = '$_SESSION[institution_code]' 
        AND purchase_medical_product_backup.branch_ID = '$_SESSION[br]'
        AND purchase_medical_product_backup.purchase_date BETWEEN '$date1' AND '$date2'
        GROUP BY CONCAT(purchase_medical_product_backup.product_name, '_', purchase_medical_product_backup.batch_number)";
        $query = $conn->query($sql);
       }else{
        $sql = "SELECT *,product_quantity as quantity FROM `purchase_medical_product_backup`
        INNER JOIN `medical_product` ON purchase_medical_product_backup.product_nampurchase_medical_product_backup = medical_product.product_ID
        INNER JOIN `medical_category` ON purchase_medical_product_backup.product_category = medical_category.category_ID 
        INNER JOIN `login` ON purchase_medical_product_backup.user_id = login.user_id 
        WHERE purchase_medical_product_backup.branch_ID ='$_SESSION[br]' 
        AND purchase_medical_product_backup.institution_code = '$_SESSION[institution_code]'
        AND purchase_medical_product_backup.purchase_date BETWEEN '$date1' AND '$date2'
        AND purchase_medical_product_backup.purchase_status ='1'
        GROUP BY CONCAT(purchase_medical_product_backup.product_name, '_', purchase_medical_product_backup.batch_number)";
        $query = $conn->query($sql);
       }
     }else{
      if($_SESSION['role_id'] == 3){
        $sql = "SELECT *,product_quantity as quantity FROM `purchase_medical_product`
        INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
        INNER JOIN `login` ON purchase_medical_product.user_id = login.user_id 
        INNER JOIN `medical_category` ON purchase_medical_product.product_category = medical_category.category_ID 
        WHERE purchase_medical_product.institution_code = '$_SESSION[institution_code]' 
        GROUP BY CONCAT(purchase_medical_product.product_name, '_', purchase_medical_product.batch_number)";
        $query = $conn->query($sql);
       }else{
        $sql = "SELECT *,product_quantity as quantity FROM `purchase_medical_product`
        INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
        INNER JOIN `login` ON purchase_medical_product.user_id = login.user_id 
        INNER JOIN `medical_category` ON purchase_medical_product.product_category = medical_category.category_ID 
        WHERE purchase_medical_product.branch_ID ='$_SESSION[branch]' 
        AND purchase_medical_product.institution_code = '$_SESSION[institution_code]' AND
        purchase_medical_product.purchase_status ='1'
        GROUP BY CONCAT(purchase_medical_product.product_name, '_', purchase_medical_product.batch_number)";
        $query = $conn->query($sql);
       }
     }       
        
        while($row = $query->fetch_assoc()){
          $product_id         = $row['product_ID'];
          $product_name       = $row['product_Nmae'];
          $category           = $row['category_name'];
          $expired            = $row['expired_date'];
          $user               = $row['first_name']." ".$row['last_name'];
          $batch              = $row['batch_number'];
          $quantity_purchase  = $row['quantity'];
          $selling_price      = $row['selling_price'];
          $purchase_price     = $row['purchase_price'];

          $start  = date_create();// Current time and date
          $end  = date_create($expired); 
          $diff   = date_diff($start, $end );
          // $years=$diff->y;
          // $months=$diff->m;
          // $days=$diff->d;
          // $hours=$diff->h;
          // $minutes=$diff->i;
          // $seconds=$diff->s;
          $totalDays=$diff->days;
          if($quantity_purchase < 5){
            $quantity_view = "<span class='badge badge-danger'> $quantity_purchase </span>";
          }else{
            $quantity_view = "<span class='badge badge-info'> $quantity_purchase </span>";
          }

            if($quantity_purchase <= '0'){
              continue;
            }
            if($diff->format("%R%a") <= '0'){
              continue;
            }
            if($diff->format("%R%a") >=60){
              $date_expired= '<i style="float:right; color:green;margin-top:1%; ">Expired in '. $diff->format("%a").' days.</i>';
            }elseif( $diff->format("%R%a") < 30 && $diff->format("%R%a") > 0){
              $date_expired= '<i style="float:right; color:red;margin-top:1%; ">Expired in '.$diff->format("%a").'days.</i>';
            }elseif($diff->format("%R%a") <= 0){
              $date_expired= '<i style="float:right; color:red;margin-top:1%; ">Expired!!</i>';
            }
           ?>    
        
            <tr>
         <td>
        <?php echo $product_name; ?>
       </td>
       <td> 
        <?php echo $batch; ?>
      </td>
      
      <td><?php echo $purchase_price.' Frw'; ?></td>
      
      <td><?php echo $selling_price.' Frw'; ?></td>
      <td><?php echo $quantity_view; ?></td>
      <td><?php echo $expired; ?></td>
      <td><p class="pull-left"><b><?php echo $user; ?></b></p></td> 
      <?php if($_SESSION['role_id'] != 3){
          $idd = $product_id;
       ?>

      <td>
        <!-- <a href="purchased_edit?edit_purchase=<?php// echo $purchase_ID[$i]; ?>" class="btn btn-info btn-sm" style="padding-top: 0px;padding-bottom: 0px; border-radius: 5px; font-size: 100%;">
                  <i class="fas fa-edit"></i>
                </a> -->
                <!-- <a href="ksjhdjshdjh@@@IUIIUKKkdfr?med_batch=<?php //echo md5($batch_number[$i]); ?>" 
                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a> -->
                <?php if($rows['new_purchase']== 1) {
                if($diff->format("%R%a") >= 0) { ?>
                  <span><a href="ksjhdjshdjh@@@IUIIUU?med_batch=<?php echo md5($batch); ?>&&product_id=<?php echo md5($product_id); ?>" 
                  class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a></span>

    
                <?php } if($diff->format("%R%a") <= 0) { ?>
              <?php echo $date_expired; ?>
               <?php }else{ 
                  echo $date_expired; 
                }}else{
                 echo $date_expired;  }
                  ?>
              </td>
            <?php } ?>
              </tr>
          <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM
          <?php echo $_SESSION['branch']; ?></div>
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
 <!-- IMPORT PURCHASED MEDECINE USING EXCEL FILE Modal -->
  <div class="modal fade" id="new_purchase_medicine_import" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1DB0D8;">
            <h4 class="modal-title"><i class="fas fa-plus"> IMPORT PURCHASED MEDECINE</i></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <div class="outer-container">
           <form action="action_page.php" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
             <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import_purchase" class="btn-submit">
                   Import
                </button>       
             </div>
          </form>
        </div>
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
            <select class="form-control" name="product_name">
               <option selected="selected" disabled="disabled">SELECT THE MEDECINE NAME</option>
              <?php
              if($_SESSION['role_id'] == 2){
                $stmt = $conn->query("SELECT * FROM `medical_product` WHERE institution_code = '$_SESSION[institution_code]' ORDER BY product_Nmae");
                }else{
                  $stmt = $conn->query("SELECT * FROM `medical_product` WHERE branch_ID ='$_SESSION[branch]' 
                  AND institution_code = '$_SESSION[institution_code]' ORDER BY product_Nmae");
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
               <option selected="selected" disabled="disabled">SELECT THE CATEGORY NAME</option>
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
          <label for="pwd">Medical Source:</label>
          <select name="medical_source" class="form-control" required="required">
            <option selected="selected" disabled="disabled">SELECT THE SOURCE</option>
            <option value="0">MEDICAL STORE</option>
            <option value="2">INVENTORY</option>
          </select>
        </div>
          <div class="form-group">
          <label for="name">Batch Number:</label>
          <input type="text" class="form-control" id="batch_number" placeholder="Enter batch number of medicine....." name="batch_number">
          </div>
          <div class="form-group">
          <label for="name">Purchase Price:</label>
          <input type="number" class="form-control" min="0" value="0" step="any" id="purchase_price" placeholder="Enter the Purchase Price" name="purchase_price">
          </div>
          <div class="form-group">
          <label for="name">Selling Price:</label>
          <input type="number" class="form-control" min="0" value="0" step="any" id="selling_prices" placeholder="Enter the selling Price" name="selling_price">
          </div>
          <div class="form-group">
            <label for="name">Quantity:</label>
            <input type="number" class="form-control" min="0" value="0" step="any" id="quantity" placeholder="Enter the quantity" name="quantity">
            <input type="hidden" class="form-control" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" name="user_id">
          </div>
          <div class="form-group">
            <label for="name">Expiration Date:</label>
            <input type="date" class="form-control" id="expiration_date" name="expiration_date">
          </div>
          
          <div class="modal-footer">
          <button type="submit" class="btn btn-success" name="purchase_medical_product"><i class="fas fa-plus"> ADD</i></button>
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
  <script type="text/javascript">
function CopyToClipboard(containerid) {
if (document.selection) { 
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select().createTextRange();
    document.execCommand("copy"); 

} else if (window.getSelection) {
    var range = document.createRange();
     range.selectNode(document.getElementById(containerid));
     window.getSelection().addRange(range);
     document.execCommand("copy");
     alert("the pharmacy current data are copied successfull") 
}}
</script>

</body>

</html>
