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
?>

    <div id="content-wrapper" style="">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Purchase Medecine</li>
          
        </ol>
        <div id="messages">
 
      </div>
       
  <!-- DataTables Example -->
  <div class="card mb-3">
      
    <div class="card-header">
    <!--  -->
      <?php if($_SESSION['role_id'] == 3){ ?>
            <button class="btn btn-info btn-sm" style="float: right;" onclick="CopyToClipboard('dataTable')">Copy Current Data</button>
            
            
        <div style="float: right; margin-right: 20px;">
          <form class="form-inline pull-right" action="" method="post" >
            
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
      <h5>List of medical stocked out</h5>
      </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" cellspacing="0">
           <thead>
          <tr>
              <th>Product Name</th>
              <th>Batch number</th>
              <th>Purchase Price</th>  
              <th>Sellling Price</th>  
              <th>Quantity</th>
              <th>Exipired Date</th>
              <th>Done By</th>
              <th>ACTION</th>
            </tr>
          </thead>
          
          <tbody style="padding: 0px;">
            <?php

       if($_SESSION['role_id'] == 3){
        $sql = "SELECT *,product_quantity as quantity FROM `purchase_medical_product`
        INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
        INNER JOIN `login` ON purchase_medical_product.user_id = login.user_id 
        WHERE purchase_medical_product.institution_code = '$_SESSION[institution_code]'
        AND purchase_medical_product.purchase_status ='1'
        GROUP BY CONCAT(purchase_medical_product.product_name, '_', purchase_medical_product.batch_number)";
        $query = $conn->query($sql);
       }else{
        $sql = "SELECT *,product_quantity as quantity FROM `purchase_medical_product`
        INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
        INNER JOIN `login` ON purchase_medical_product.user_id = login.user_id 
        WHERE purchase_medical_product.branch_ID ='$_SESSION[branch]' 
        AND purchase_medical_product.institution_code = '$_SESSION[institution_code]'
        AND purchase_medical_product.purchase_status ='1'
        GROUP BY CONCAT(purchase_medical_product.product_name, '_', purchase_medical_product.batch_number)";

        $query = $conn->query($sql);
       }

        while($row = $query->fetch_assoc()){
          $product_id         = $row['product_ID'];
          $product_name       = $row['product_Nmae'];
          //$category           = $row['category_name'];
          $expired            = $row['expired_date'];
          $user               = $row['first_name']." ".$row['last_name'];
          $batch              = $row['batch_number'];
          $quantity_purchase  = $row['quantity'];
          $selling_price      = $row['selling_price'];
          $purhase_price     = $row['purchase_price'];

          $start  = date_create();// Current time and date
          $end  = date_create($expired); 
          $diff   = date_diff($start, $end );
          $ref = date_diff($end, $start);
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
            
            if($diff->format("%R%a") >= '0'){
              continue;
            }
            
            if($diff->format("%R%a") >=60){
              $date_expired= '<i style="float:right; color:green;margin-top:1%; ">Expired in '. $diff->format("%a").' days.</i>';
            }elseif( $diff->format("%R%a") < 30 && $diff->format("%R%a") > 0){
              $date_expired= '<i style="float:right; color:red;margin-top:1%; ">Expired in '.$diff->format("%a").'days.</i>';
            }elseif($diff->format("%R%a") <= 0){
              $date_expired= '<i style="float:right; color:red;margin-top:1%; ">Expired!!</i>';
              $pasted_days = '<i style="float:right; color:green;margin-top:1%; ">Expired!!' .$ref->format("%a").'days.</i>';
            }
           ?>
            <tr>
              <td>
                <?php echo $product_name; ?>
              </td>
              <td>
                <?php echo $batch; ?>
              </td>
              <td>  
                <?php echo $purhase_price." Frw"; ?>
              </td>
              <td>  
                <?php echo $selling_price." Frw"; ?>
              </td>
              <td>
                <?php echo $quantity_view; ?>
              </td>
              <td>
                <?php echo $expired; ?>
              </td>
              <td><p class="pull-left"><?php echo $pasted_days; ?></p></td> 
              
              <td>
                
                <?php if($diff->format("%R%a") <= 0) {
                   echo $date_expired; 
                }else{ 
                  echo $date_expired; 
                }
                  ?>
              </td>
            </tr>
        </div>
      <?php }  ?>
    </div>
                  
                  
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

  


  <!-- Modal -->

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
