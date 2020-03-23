<?php include('includes/head_tag.php'); ?>

<body id="page-top">

  <?php include('includes/menu.php'); ?>
  <?php
               if (isset($_GET['sales_inv'])) {
                  # code...
                  
                }

            ?>
    <div id="content-wrapper">
      <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="home">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Sales for a certain transaction</li>
          <li class="breadcrumb-item active"><?php echo $invoice = $_GET['sales_inv'];?></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <!--<div class="card-header">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">
              <i class="fas fa-plus"></i>
                 New Sales
            </button>
            </div> -->
            
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Invoice Id</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Medecine</th>
                    <th>Quantity</th>
                    <th>Unit price</th>
                    <th>Sub total</th>
                    <th>Discount</th>
                    <th>Grand total</th>
                    <th>Amount received</th>
                    <th>Payment mode</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Invoice Id</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Medecine</th>
                    <th>Quantity</th>
                    <th>Unit price</th>
                    <th>Sub total</th>
                    <th>Discount</th>
                    <th>Grand total</th>
                    <th>Amount received</th>
                    <th>Payment mode</th>
                    <th>Options</th>
                  </tr>
                </tfoot>
                <tbody>

                  <?php 
                  $today = date('Y-m-d');
                  $sql_today_sales = "SELECT * FROM `total_sales`
                  INNER JOIN medical_product ON total_sales.medicine_ID = medical_product.product_ID WHERE total_sales.transaction_ID = '$invoice' ";

                    $T_sales = $conn->query($sql_today_sales);
                    //$c_query = $conn->query($sql);
                    $loan = 0;
                    $tot_amount_received = 0;

                    while($row = $T_sales->fetch_assoc()){
                    ?>
                  <tr><small>
                    <td><?php echo $row['transaction_ID']; ?></td>
                    <td><small><?php echo $row['customer_name']; ?></small></td>
                    <td><small><?php echo $row['date_with_hours']; ?></small></td>
                    <td><small><?php echo $row['product_Nmae']; ?></small></td>
                    <td><?php echo number_format($row['quantity']); ?></td>
                    <td><?php echo number_format($row['price']); ?></td>
                    <td><?php echo number_format($row['sub_total']); ?></td>
                    <td><?php echo "0.00 %"; ?></td>
                    <td><?php echo number_format($row['sub_total']); ?></td>
                    <td><?php if ($row['payment_mode']=='Loan') {
                      # code...
                     echo '0.00';
                    }  else{ echo number_format($row['sub_total']);}
                    ?></td>
                    <td><?php echo $row['payment_mode']; ?></td>
                    <td>
                     <small>
                      <div class="" padding: 0px;>
                       <a href="invoiceDetail?$inv=<?php echo $row['transaction_ID']; ?>">
                       <button type="button" class="btn btn-success btn-sm" style="padding-top: 0px;padding-bottom: 0px; border-radius: 5px;"><i class="fas fa-eye"> </i></button></a>
                      </div>
                      </small>
                    </td>
                  </small>
                  </tr>
                 
                  <?php
                  
                  if ( $row['payment_mode']=='Loan') {
                    # code...
                    $loan     += 0;
                    $tot_amount_received += 0;
                  }
                  else
                  {
                    $loan += $row['sub_total'];
                    $tot_amount_received += $row['sub_total'];
                  }
                  
                }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM 
            <?php echo "Loan: ". $loan." ".'Total amount received: '.$tot_amount_received; ?>
          </div>
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
            <h4 class="modal-title"><i class="fas fa-plus"> ADD Sales</i></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

        <form action="/action_page.php">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name of Sales" name="name">
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
