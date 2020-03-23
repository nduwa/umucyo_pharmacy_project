<?php
  //session_start();
  //initialize cart if not set or is unset
  if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
    $_SESSION['current_qty'] = array();
    $_SESSION['qty_check_btn'] = array();
    $_SESSION['product_Nmae'] = array();
  }

  /*//unset qunatity
  unset($_SESSION['qty_array']);
  unset($_SESSION['current_qty']);
  unset($_SESSION['qty_check_btn']);
  unset($_SESSION['product_Nmae']);*/
?>
<?php include('includes/head_tag.php'); ?>
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
<body id="page-top" >

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
  <center>      
  <h2 classs="page-header">
    <strong>
      <i class="fas fa-info"> medecine to be printed on invoice</i> 
    </strong> 
  </h2><hr>
</center>
  <div class="row" >
    <div class="col-sm-12 col-sm-offset-12">
      <?php 
      if(isset($_SESSION['message'])){
        ?>
        <div class="alert alert-info text-center">
          <?php echo $_SESSION['message']; ?>
        </div>
        <?php
        unset($_SESSION['message']);
        echo '<script>
         setTimeout(function(){
            window.location.href = "view_cart";
         }, 2000);
      </script>';
      }
      elseif(isset( $_SESSION['check_qty'])){

               echo  $_SESSION['check_qty']; 
               unset($_SESSION['check_qty']);
      }

      ?>
      <form method="POST" action="save_cart">
        <div class="row">
          <?php  
            if (!empty($_SESSION['customer_name']) | !empty($_SESSION['pnumber'])) {
              # code...
           ?>
           <div class="form-group col-sm-3 col-md-3">
          <label for="email">Customer TIN:</label>
          <input type="number" class="form-control " id="c_tin" placeholder="Enter customer TIN" name="c_tin" 
          value="<?php echo $_SESSION['customer_tin']; ?>">
        </div>
         <div class="form-group col-sm-3 col-md-3">
          <label for="email">Customer name:</label>
          <input type="text" class="form-control " id="Cname" placeholder="Enter customer name" name="Cname" 
          value="<?php echo $_SESSION['customer_name']; ?>">
        </div>
        <div class="form-group col-sm-3 col-md-3">
          <label for="pwd">Customer Phone number:</label>
          <input type="tel" class="form-control" id="tel" placeholder="Enter Phone number" name="tel" 
          value="<?php echo $_SESSION['pnumber']; ?>">
        </div>
        <div class="form-group col-sm-3 col-md-3">
          <label for="pwd"><b>Payment mode:</b></label>
          <select name="payment_mode" class="form-control" required="required">
            <option value="<?php echo $_SESSION['payment_mode']; ?>"><?php echo $_SESSION['payment_mode']; ?></option>
            <option value="Paid">Paid</option>
            <option value="Loan">Loan</option>
            <option value="Transfer">Transfer</option>
            <option value="Inventory">Inventory</option>
          </select>
        </div>
      <?php } 
      else
      {
        ?>
        <div class="form-group col-sm-3 col-md-3">
          <label for="email">Customer TIN:</label>
          <input type="number" class="form-control " id="c_tin" placeholder="Enter customer TIN" name="c_tin" 
          >
        </div>
         <div class="form-group col-sm-3 col-md-3">
          <label for="email"><b>Customer name:</b></label>
          <input type="text" class="form-control " id="Cname" placeholder="Enter customer name" name="Cname" >
        </div>
        <div class="form-group col-sm-3 col-md-3">
          <label for="pwd"><b>Customer Phone number:</b></label>
          <input type="tel" class="form-control" id="tel" placeholder="Enter Phone number" name="tel" >
        </div>
        <div class="form-group col-sm-3 col-md-3">
          <label for="pwd"><b>Payment mode:</b></label>
          <select name="payment_mode" class="form-control" required="required">
            <option value="">Select payment mode</option>
            <option value="Paid">Paid</option>
            <option value="Loan">Loan</option>
            <option value="Transfer">Transfer</option>
            <option value="Inventory">Inventory</option>
          </select>
        </div>
        <?php
      }

       ?>
        </div>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
        <thead>
          <th># Option</th>
          <th>Name</th>
                    <th>Batch Number</th>
                    <th>batch selected</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </thead>
        <tbody>
          <?php
            //initialize total
            $total = 0;
            if(!empty($_SESSION['cart'])){
            //create array of initail qty which is 1
            $index = 0;
            if(!isset($_SESSION['qty_array'])){
              $_SESSION['qty_array'] = array_fill(0, count($_SESSION['cart']), 1);

            }
            
            //echo implode(',',$_SESSION['cart']).' array of quantity: '.$_SESSION['qty_array'][3];
            //print_r($_SESSION['cart']);
            
            $sql = "SELECT *,sum(purchase_medical_product.product_quantity) as quantity FROM `purchase_medical_product` 
            INNER JOIN medical_product ON purchase_medical_product.product_name = medical_product.product_ID
              WHERE purchase_medical_product.batch_number IN (".implode(',',$_SESSION['batch_number2']).")  GROUP BY CONCAT(purchase_medical_product.product_name, '_', purchase_medical_product.batch_number)";
            $query = $conn->query($sql);
              while($row = $query->fetch_assoc()){
                ?>
                <tr>
                  <td>
                    <a href="delete_item.php?id=<?php echo $row['product_ID']; ?>&bt=<?php echo $row['batch_number']; ?>&index=<?php echo $index; ?>" class="btn btn-danger btn-sm"><span class="fas fa-trash"></span></a>
                  </td>
                  <td><?php echo $_SESSION['product_Nmae'][$index]; ?></td>
                  <td>
                    <?php 
                      $sql = "SELECT DISTINCT batch_number FROM `purchase_medical_product` WHERE purchase_medical_product.product_name= '$row[product_ID]'
                      AND purchase_medical_product.purchase_status='1' ";

                      $sql_batch = $conn->query($sql);
                     
                     if (isset($_SESSION['batch_number'])) {
                        # code...   
                        $f         = $_SESSION['batch_number'][$index];
                        //$result = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($s));
                        $v         = $_SESSION['batch_number'][$index];
                        $sel_price = $_SESSION['selling_price'][$index];
                        $sub_total = $_SESSION['sub_total'][$index];
                      } else{
                        $f = "Select batch";
                        $v = "";
                        $sel_price = 0;
                        $sub_total = 0;
                      }
                      ?>

                   <!--  <select name="batch_Number[]" id="batchh" required="required" disabled="disabled">
                      <option value="<?php //echo $v;  ?>"><?php// echo $f; ?></option> -->
                      <?php //while ( $btch = $sql_batch->fetch_assoc()) {
                     ?>                               
                      <!-- <option value="<?php// echo $btch['batch_number']; ?>"><?php// echo $btch['batch_number']; ?></option>
                      
                    </select> -->
                    
                    <?php  //}  ?>
                    <input type="hidden" name="indexes[]" value="<?php echo $index; ?>">
                    <input type="text" name="batch_Number_<?php echo $index; ?>" id="batchh" value="<?php echo $_SESSION['batch_number'][$index]; ?>" disabled="disabled" />
                  </td>
                  <input type="hidden" name="indexes[]" value="<?php echo $index; ?>">
                  <td><input type="text" name="batch_number_<?php echo $index; ?>" value="<?php echo $f; ?>"  disabled="disabled" /></td>
                  <td >
                    <input type="text" class="form-control" id="price" value="<?php echo $sel_price; ?>" disabled >         
                  </td>
     
                  <input type="hidden" name="indexes[]" value="<?php echo $index; ?>">
                  <td><input type="text" class="form-control" id="sel1" value="<?php echo $_SESSION['qty_array'][$index]; ?>" name="qty_<?php echo $index; ?>" min="0" value="0" step="any"required title="<?php echo 'Total Quantity in stock is '.$_SESSION['current_qty'][$index]; ?>"
                    placeholder="<?php echo 'Enter qty <= '.$_SESSION['current_qty'][$index]; ?>"></td>
                  <td><input type="text" id="sub_total" class="form-control" value="<?php echo $sub_total.' frw'; ?>" disabled="disabled" name="sub_total_<?php echo $index; ?>"> </td>
                  <?php $total += $_SESSION['qty_array'][$index]*$sel_price; ?>
                </tr>
                <?php
                $index ++;
              }
              $_SESSION['tt_price'] = $total;
            }
            else{
              ?>
              <tr>
                <td colspan="4" class="text-center">No Item in Cart</td>
              </tr>
              <?php
            }

          ?>
          <tr>
            <td colspan="4" align="right"><b>Total</b></td>
            <td><b><?php echo number_format($total, 2) . " <i>frw</i>"; ?></b></td>
          </tr>
        </tbody>
        <?php   
        // if(in_array($_SESSION['qty_check_btn'], 'disabled'))
        // {
        //  $_SESSION['checkout_btn'] = 'disabled';
        // } 
        // else { $_SESSION['checkout_btn'] = ''; }
        
        ?>
      </table>
      <a href="medecine" class="btn btn-primary"><span class="fas fa-arrow-left"></span> Back</a>
      <button type="submit" class="btn btn-success" name="save"><span class="fas fa-save"></span> Save Changes</button>
      <a href="clear_cart" class="btn btn-danger"><span class="fas fa-trash"></span> Clear Cart</a>
      <a href="checkout.php" class="btn btn-success <?php echo $_SESSION['checkout_btn'];  ?>" ><span class="fas fa-check"></span>Checkout</a>
      </form>
    </div>
  </div>
</div>
            </div>
          </div>
          <div class="card-footer small text-muted"><?php echo date('l') .' '.date('Y-m-d').' '.date('h:i:sa'); ?></div>
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
</body>

</html>
