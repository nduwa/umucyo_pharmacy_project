
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
    <style>
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>
  <!--<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">-->
</head>
<body id="page-top">

  <?php include('includes/menu.php'); ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Serve Medecine</li>
      
        </ol>
       <?php

    //info message
    if(isset($_SESSION['message'])){
      ?>
      <div class="row" style="padding: ">
        <div class="col-sm-6 col-sm-offset-6">
          <!-- <div class="alert alert-info text-center"> -->
            <?php echo $_SESSION['message']; ?>
          <!-- </div> -->
        </div>
      </div>
      <?php
      unset($_SESSION['message']);
       echo '<script>
         setTimeout(function(){
            window.location.href = "medecine";
         }, 2500);
      </script>';
    }
    $basket_count ="SELECT * FROM `total_sales` WHERE User_branch = '$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]' AND userID = '$_SESSION[user_id]' AND ser_status = '0'";
    $basket_result = $conn->query($basket_count);
    $basket_number = $basket_result->num_rows;
    if($basket_number > 0){
      $_SESSION['basket_number'] = $basket_number;
    }else{
      $_SESSION['basket_number'] = '0';
    }

    ?>
    
        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">

            <!-- <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">
              <i class="fas fa-plus"></i>
                 Add medecine

            </button> -->
            <?php if($_SESSION['role_id'] != 3){ ?>
            <button class="btn btn-default btn-sm" style="float: right;">
          <p><a href="view_basket.php"><span class="badge badge-info">
              <?php echo $_SESSION['basket_number']; ?></span> Basket 
           <span class="fas fa-shopping-cart"></span></a></p>
        </button>
        <?php } ?>
            <?php if($_SESSION['role_id'] == 3){ ?>
            <button class="btn btn-info btn-sm "style="float: right;" onclick="CopyToClipboard('dataTable')">Copy Current Data</button>
            
            
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
        <h5>List of current medecine in stock</h5>

            </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Batch</th>
                    <th>Category</th>
                    <?php if($_SESSION['role_id'] == 3){ ?>
                    <th>Purchase price</th>
                    <?php } ?>
                    <th>Selling price</th>
                    <th>Quantity</th>
                    <th>Expire date</th>
                    <th>Expire days</th>
                    <?php if($_SESSION['role_id'] != 3){ ?>
                    <th>Option</th>
                    <?php }?>
                  </tr>
                </thead>
                
                <tbody style="padding: 0px;">
                  <?php
    
        $_SESSION['br'] = $_SESSION['branch'];
        if(isset($_POST['find_report'])){
          $_SESSION['br'] = $_POST['branch_ID'];

       if($_SESSION['role_id'] == 3){
        $sql = "SELECT *,product_quantity as quantity FROM `purchase_medical_product`
        INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
        INNER JOIN `medical_category` ON purchase_medical_product.product_category = medical_category.category_ID 
        WHERE purchase_medical_product.institution_code = '$_SESSION[institution_code]' 
        AND purchase_medical_product.branch_ID = '$_SESSION[br]'
        GROUP BY CONCAT(purchase_medical_product.product_name, '_', purchase_medical_product.batch_number)";
        $query = $conn->query($sql);
       }else{
        $sql = "SELECT *,product_quantity as quantity FROM `purchase_medical_product`
        INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
        INNER JOIN `medical_category` ON purchase_medical_product.product_category = medical_category.category_ID 
        WHERE purchase_medical_product.branch_ID ='$_SESSION[br]' 
        AND purchase_medical_product.institution_code = '$_SESSION[institution_code]' AND
        purchase_medical_product.purchase_status ='1'
        GROUP BY CONCAT(purchase_medical_product.product_name, '_', purchase_medical_product.batch_number)";
        $query = $conn->query($sql);
       }
     }else{
      if($_SESSION['role_id'] == 3){
        $sql = "SELECT *,product_quantity as quantity FROM `purchase_medical_product`
        INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
        INNER JOIN `medical_category` ON purchase_medical_product.product_category = medical_category.category_ID 
        WHERE purchase_medical_product.institution_code = '$_SESSION[institution_code]' 
        GROUP BY CONCAT(purchase_medical_product.product_name, '_', purchase_medical_product.batch_number)";
        $query = $conn->query($sql);
       }else{
        $sql = "SELECT DISTINCT *,product_quantity as quantity FROM `purchase_medical_product`
        INNER JOIN `medical_product` ON purchase_medical_product.product_name = medical_product.product_ID
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
          //$user               = $row['first_name']." ".$row['last_name'];
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
            <td><?php echo $product_name; ?></td>
            <td> <?php echo $batch; ?></td>
            <td><?php echo $category; ?></td>
            <?php if($_SESSION['role_id'] == 3){ ?>
            <td><?php echo $purchase_price.' Frw'; ?></td>
            <?php } ?>
            <td><?php echo $selling_price.' Frw'; ?></td>
            <td><?php echo $quantity_purchase; ?></td>
            <td><?php echo $expired; ?></td>
            <td><?php if($diff->format("%R%a") > 0) { ?>
              <?php echo $date_expired; ?>
               <?php }else{ 
                  echo $date_expired; 
                }
                  ?>
            </td>
              <?php if($_SESSION['role_id'] != 3){
                  $idd = $product_id;
                  $id_batch = $product_id."_".$batch;
               ?>
            <td>
               <a href="#demo_<?php echo $id_batch; ?>"  class="btn btn-primary btn-sm" data-toggle="collapse"><span class="fas fa-shopping-cart"></span>Serve</a>
                 <div id="demo_<?php echo $id_batch; ?>" class="collapse" style="margin-top: 5px;" >
                  <form method="get" action="add_basket" >
                    <div class="col-md-12" >
                      <input type="hidden" name="id" step="any" value="<?php echo $product_id; ?>">
                      <input type="hidden" name="Quantity" step="any" value="<?php echo $quantity; ?>">
                      <input type="hidden" name="price" step="any" value="<?php echo $selling_price; ?>">
                      <input type="number" required="required" name="served_quantity" style="width: 7em;" step="any" placeholder="Quantity">
                      <input type="hidden" name="Batch" step="any" value="<?php echo $batch; ?>"> 
                      <button type="submit" name="send_served_medecine" style="margin-top: 5px;float: right;" class="btn btn-success btn-sm" value="" ><i class="fa fa-send">&nbsp;save</i></button>
                    </div>
                  </form>
                 </div> 
              </td>
              <?php } ?>
            </tr>
            <?php } ?>
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
            <h4 class="modal-title"><i class="fas fa-plus"> ADD MEDECINE</i></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

        <form action="/action_page.php">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name of medecine" name="name">
          </div>
          <div class="form-group">
           <select class="form-control">Category:
            <option>Category 1</option>
            <option>Category 2</option>
            <option>Category 3</option>
            <option>Category 4</option>
           </select>
          </div>
          <div class="form-group">
            <label for="Purchase">Purchase Price:</label>
            <input type="number" class="form-control" id="Purchase" placeholder="Enter Purchase Price" name="name">
          </div>
          <div class="form-group">
            <label for="Salling">Salling Price:</label>
            <input type="number" class="form-control" id="Salling" placeholder="Enter Salling Price" name="name">
          </div>
          <div class="form-group">
            <label for="Quantity">Quantity:</label>
            <input type="number" class="form-control" id="Quantity" placeholder="Enter Quantity" name="med_qty">
          </div>
          <div class="form-group">
            <label for="Expire_date">Expire date:</label>
            <input type="date" class="form-control" id="Expire_date" placeholder="Enter Expire date" name="Expire_date">
          </div>
          <button type="submit" class="btn btn-success"><i class="fas fa-plus"> ADD</i></button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
  <script>
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
