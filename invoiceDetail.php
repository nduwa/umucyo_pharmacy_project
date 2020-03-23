<?php 
    include('includes/head_tag.php');  
    session_start();
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

    #printable { display: none; }

    @media print
    {
        #non-printable { display: none; }
        #printable { display: block; }
    }
    </style>
	<!--<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">-->
</head>
<body id="page-top" class="container" style="margin-top: 10px;">
  <?php //include('includes/menu.php'); ?>
  <?php include('includes/config.php'); ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb" id="non-printable">
          <li class="breadcrumb-item">
            <a href="profile"><span class="btn btn-info btn-sm"><i class="fas fa-arrow-left"></i>&nbsp;</span></a>
          </li>
          <button type="button" class="btn btn-default btn-sm" onclick="window.print();return false;" style="text-align: right;">
            <i class="fas fa-print"></i> Print
          </button>
        </ol>
       <?php
  //session_start();
  //initialize cart if not set or is unset
  /*if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
  }*/

  //unset qunatity
  //unset($_SESSION['qty_array']);
  if (isset($_GET['$inv'])) {
    # code...
    $invoice = $_GET['$inv'];
  }
?> 
	<?php
		
  if ($_SESSION['role_id'] == 3) {
    # code...
    $sql = "SELECT * FROM `total_sales` INNER JOIN `phar_branch` ON total_sales.User_branch= phar_branch.branch_ID
    INNER JOIN `medical_product` ON total_sales.medicine_ID = medical_product.product_ID
    INNER JOIN `phar_institution` ON total_sales.institution_code = phar_institution.institution_code
     WHERE total_sales.transaction_ID='$invoice' AND
      total_sales.institution_code= '$_SESSION[institution_code]'";
  }else{
    $sql = "SELECT * FROM `total_sales` INNER JOIN `phar_branch` ON total_sales.User_branch= phar_branch.branch_ID
    INNER JOIN `medical_product` ON total_sales.medicine_ID = medical_product.product_ID
    INNER JOIN `phar_institution` ON total_sales.institution_code = phar_institution.institution_code
     WHERE total_sales.transaction_ID='$invoice' AND
      total_sales.institution_code= '$_SESSION[institution_code]' AND
      total_sales.userID='$_SESSION[user_id]' AND total_sales.User_branch='$_SESSION[branch]'";
  }
		
    
    $query = $conn->query($sql);
    $c_query = $conn->query($sql);
     echo $conn->error;
    $customer_info = $c_query->fetch_assoc();

		?>
  <!-- DataTables Example -->
  <div class="card mb-3">
    <div class="card-header" id="">
    <!--  -->
      <div class="row">
        <div class="col-md-6 col-sm-6">
      <h5><strong># No: </strong> <?php echo $invoice; ?></h5>
      <p>
        <strong>Customer TIN: <?php echo $customer_info['customer_tin']; ?></strong><br>
        <strong>Customer names: </strong> <?php echo $customer_info['customer_name']; ?><br>
        <strong>Tel Number: </strong> <?php echo $customer_info['customer_telphone']; ?></p>
      </div>
      <div class="col-md-6 col-sm-6">
        <h1><b><i>TIN:</i></b>
        <?php echo $customer_info['institution_TIN']; ?>
        <hr></h1>
      </div>
      </div>
      </div>
    <div class="card-body">
      <div class="">
        <table class="table">
          <thead>
            <tr >
              <th style="padding: 5px;"># No </th>
              <th style="padding: 5px;">Medecine name</th>
              <th style="padding: 5px;">Quantity</th>
              <th style="padding: 5px;">Unit price</th>
              <th style="padding: 5px;">Tota price</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $inc = 1;
            $total_price=0;
            while($row = $query->fetch_assoc()){ 
            ?>
            <tr>
              <td style="padding: 5px;"><?php echo $inc; ?></td>
              <td style="padding: 5px;">
                <?php echo $row['product_Nmae']; ?>
              </td>
              <td style="padding: 5px;">	
                <?php echo $row['quantity']; ?>
              </td>
              <td style="padding: 5px;">
                <?php echo $row['price']; ?>
              </td>
              <td style="padding: 5px;">
                <?php echo number_format($row['quantity']*$row['price']); ?> <i>Rwf</i>
              </td>	
            </tr>
        
			<?php
      $total_price += $row['quantity']*$row['price'];
      $inc++;
      $done_at = $row['date_done'];
      $branch  = $row['branch_name'];
        }
        echo '</tbody>
        </table>';
        
        //end product row 
	    ?>
    </div>
                  
                  
                </tbody>
              </table>
            </div>
          </div>
          <div class="row container">
            <div class="col-md-6 col-sm-6 card-footer small text">
             <p><strong> Done at:<i> <?php echo $done_at; ?></i> </p>
             <p><?php echo $branch; ?></p></strong>
            </div>
            <div class="col-md-6 col-sm-6">
          <div style="float: right;" style="border: 2px solid black;">
              <table class="" style="border: 1px solid black; padding: 50px;">
                <tr>
                  <td style="padding: 10px;">
                    <strong>Sub Total:</strong>
                  </td>
                  <td style="border: 1px solid black; padding: 5px;">
                    <?php 
                        $fixed_money = floatval(str_replace(",", ".", $total_price));
                        echo number_format($fixed_money, 2, ".", ","); ?> Rwf
                  </td>
                </tr>
                <!-- <tr>
                  <td style="padding: 10px;"><strong>Discount:</strong></td><td style="border: 1px solid black; padding: 5px;"> 0.00%</td>
                </tr> -->
                <tr>
                  <td style="padding: 10px;">
                    <strong>Total Due:</strong> </td>
                    <td style="border: 1px solid black; padding: 5px;">
                    <?php 
                      $fixed_money = floatval(str_replace(",", ".", $total_price));
                      echo number_format($fixed_money, 2, ".", ","); ?>Rwf
                  </td>
                </tr>
              </table>
              </div>
            </div>
        </div>
        </div>
      </div>
      <!-- /.container-fluid -->
      
      <!-- Sticky Footer -->
  <!--    <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>
    -->

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

</body>

</html>
