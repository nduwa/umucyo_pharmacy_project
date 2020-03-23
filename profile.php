<?php include('includes/head_tag.php'); ?>
</head>
<body id="page-top">

  <?php include('includes/menu.php'); ?>
    <div id="content-wrapper">
      <div class="container-fluid" >
       
        <ol class="breadcrumb">

      <ul class="nav nav-tabs" id="myTab">
        <li class="breadcrumb-item active"><a href="#home" class="btn btn-info btn-sm" data-toggle="tab">
          <i class="fas fa-list"></i> Transaction(s)</a>
        </li>
        
        
        <li class="breadcrumb-item"><a href="#basic_info" class="btn btn-primary btn-sm" data-toggle="tab"><i class="fas fa-info"></i> Basic Information</a>
      </li>
        <li class="breadcrumb-item"><a href="#update" class="btn btn-success btn-sm" data-toggle="tab"><i class="fas fa-edit"></i>Update Account</a>
      </li>
      <li class="breadcrumb-item">
        <form class="form-inline" action="" method="post" >
            
            <div class="form-group" style="margin-top: -30px;">
              <label for="pwd">&nbsp;&nbsp;&nbsp;Transaction Position &nbsp;</label>
              <select name="payment_mode" class="form-control" required="required">
                <option selected="selected"disabled="disabled">Select Transaction mode</option>
                <option value="Paid">Paid</option>
                <option value="Loan">Loan</option>
                <option value="Transfer">Transfer</option>
                <option value="Refounded">Refounded</option>
                <option value="Inventory">Inventory</option>
              </select>
            
              &nbsp;&nbsp;<button type="submit" name="find_report" class="btn btn-info btn-sm">Find</button>
            </div>
          </form>
      </li>

      </ul>
        </ol>

        <div class="tab-content container">
            <div class="tab-pane active" id="home">
              
              <!-- checkout code here --->
				<?php
				   if(isset($_SESSION['message'])){
       
				      ?>
				      <div class="row" style="padding: ">
				        <div class="col-sm-6 col-sm-offset-6">
				          <div class="alert alert-info text-center">
				            <?php echo $_SESSION['message']; ?>
				          </div>
				        </div>
				      </div>
				      <?php
				       unset($_SESSION['message']);
               echo '<script>
                 setTimeout(function(){
                    window.location.href = "profile";
                 }, 2500);
              </script>';
            }
            if(isset($_SESSION['refounded'])){
              echo $_SESSION['refounded'];

              unset($_SESSION['refounded']);
            }
            $_SESSION['tr']="Paid";

            if(isset($_POST['find_report'])){
              $_SESSION['tr']=$_POST['payment_mode'];

              if($_SESSION['role_id'] == 3){
              $sql = "SELECT DISTINCT * FROM transactions 
                      INNER JOIN total_sales ON transactions.TRANSACTION_NUMBER = total_sales.transaction_ID 
                      WHERE transactions.institution_code= '$_SESSION[institution_code]'
                      AND total_sales.payment_mode = '$_SESSION[tr]'
                      GROUP BY transactions.TRANSACTION_NUMBER";
            }else{
              $sql = "SELECT DISTINCT * FROM transactions 
                      INNER JOIN total_sales ON transactions.TRANSACTION_NUMBER = total_sales.transaction_ID WHERE transactions.user_id='$_SESSION[user_id]' 
                    AND transactions.Branch='$_SESSION[branch]'
                    AND transactions.institution_code= '$_SESSION[institution_code]'
                    AND total_sales.payment_mode = '$_SESSION[tr]'
                    GROUP BY transactions.TRANSACTION_NUMBER";
            }

            }else{
              if($_SESSION['role_id'] == 3){
              $sql = "SELECT DISTINCT * FROM transactions 
                      INNER JOIN total_sales ON transactions.TRANSACTION_NUMBER = total_sales.transaction_ID 
                      WHERE transactions.institution_code= '$_SESSION[institution_code]'
                      GROUP BY transactions.TRANSACTION_NUMBER";
            }else{
              $sql = "SELECT DISTINCT * FROM transactions 
                      INNER JOIN total_sales ON transactions.TRANSACTION_NUMBER = total_sales.transaction_ID WHERE transactions.user_id='$_SESSION[user_id]' 
                    AND transactions.Branch='$_SESSION[branch]'
                    AND transactions.institution_code= '$_SESSION[institution_code]'
                    GROUP BY transactions.TRANSACTION_NUMBER";
            }

            }
				   // list all transactions done by current user,....
            
				    $query = $conn->query($sql);

				?>

				<!-- DataTables Example -->
				        <div class="card mb-3">
				          <div class="card-body">
				            <div class="table-responsive" >
				              <table class="table table-bordered" id="dataTable" cellspacing="0" >
				                <thead>
				                  <tr>
				                    <th># Transaction ID</th>
				                    <th>Date</th>
				                    <th>Total price</th>
				                    <th>Option</th>
				                  </tr>
				                </thead>
				                <tfoot>
				                  <tr>
				                    <th># Transaction ID</th>
				                    <th>Date</th>
				                    <th>Total price</th>
				                    <th>Option</th>
				                  </tr>
				                </tfoot>
				                <tbody>
				        <?php
				        $inc = 4;
				        while($row = $query->fetch_assoc()){
				          $inc = ($inc == 4) ? 1 : $inc + 1; 
                  if($row['payment_mode'] == 'Paid') {
                    $msg = "Paid";
                  }elseif ($row['payment_mode'] == 'Transfer') {
                    $msg = "Transfered";
                  }elseif ($row['payment_mode'] == 'Refounded') {
                    $msg = "Refounded";
                  }elseif ($row['payment_mode'] == 'Loan') {
                    $msg = "Loan";
                  }elseif ($row['payment_mode'] == 'Inventory') {
                    $msg = "Inventory";
                  }

				          if($inc == 1) echo "<div class='row text-center'>";  
				        ?>
				      <tr>
				               
				      <td>
				        <a href="invoiceDetail?$inv=<?php echo $row['TRANSACTION_NUMBER']; ?>" target="_blank"><?php echo $row['TRANSACTION_NUMBER']; ?></a>
				      </td>
				      <td><?php echo $row['DATE_OF_TRANSACTION']; ?></td>
				      <td><p class="pull-left"><b><?php echo $row['TOTAL_PRICE'].' Frw'; ?></b></p></td>
				      <td>
				        <span class="pull-right">
				         <a href="invoiceDetail?$inv=<?php echo $row['TRANSACTION_NUMBER']; ?>" class="btn btn-primary btn-sm" target="_blank">
				        <span class="fas fa-eye"></span> detail</a></span>

                  <?php  if($row['payment_mode'] != 'Refounded' && $rows['transaction_refound']== 1 || $_SESSION['role_id']== 1){
                    //echo $action;
                    ?>
                  <a href='action_page?refound=<?php echo $row['TRANSACTION_NUMBER']; ?>' class='btn btn-warning btn-sm'>
                    <span class='fas fa-money-bill-alt'></span> Refound</a></span>
                    
                  <?php }if ($row['payment_mode'] == 'Loan') {?>
                    <a href="loan_trans" class="btn btn-secondary btn-sm">
                    <span class="fas fa-money-bill-alt"></span> Recovery</a></span>
                 <?php } ?>

                 <span class="btn btn-light btn-sm"><strong><i style="color: #090;"><?php echo $msg; ?></i></strong></span>
				      </td>
				    </tr>
				   </div>

				      <?php
				    }
				    echo '</tbody>
				    </table>';
				    //if($inc == 1) echo "<div></div><div></div><div></div></div>"; 
				    //if($inc == 2) echo "<div></div><div></div></div>"; 
				    //if($inc == 3) echo "<div></div></div>";
				    
				    //end product row 
				  ?>
				</div>
				                           
				      </tbody>
				    </table>
				  </div>
				</div>
				<!--<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>-->

				   <!--  checkout code ends here --->
              
             </div><!--/tab-pane-->
             <div class="tab-pane" id="basic_info">
               
               <h2></h2>
               
               <ul class="list-group">
                  <div class="row">
                    <div class="col-xl-6 col-sm-6 mb-6" >
                      <div class="card text-white bg-info o-hidden h-100">
                        <div class="card-body" style="padding: 20px;">
                          <div class="card-body-icon">
                            <i class="fas fa-fw fa-info"></i>
                          </div>
                          <div class="mr-5"><span class="badge badge-default">
                            <img class="img-circle" src="img/user.jpg" alt="profile photo" width="auto" height="auto" />
                          </span> Name: <?php echo $_SESSION['first_name'].' '. $_SESSION['last_name'];; ?></div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                          <span class="float-left">Member Since: <?php echo $_SESSION['reg_date']; ?></span>
                          <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                          </span>
                        </a>
                      </div>
                    </div>
                    <?php
                      $get_branch ="SELECT * FROM `phar_branch` WHERE branch_ID='$_SESSION[branch]'";
                      $branch_n = $conn->query($get_branch);
                      $bra_name = $branch_n->fetch_assoc();
                    ?>
                    <div class="col-xl-6 col-sm-6 mb-6">
                          <div class="tab-pane" id="messages">                            
                            <ul class="list-group">   

                            	<!-- user basic information -->

                              <li class="list-group-item text-left">
                              	<strong>First Name:</strong><i> <?php echo $_SESSION['first_name']; ?></i> </li>
                              <li class="list-group-item text-left">
                                <strong>Last Name: </strong><i><?php echo $_SESSION['last_name']; ?></i></li>
                              <li class="list-group-item text-left">
                                <strong>Username: </strong><i><?php echo $_SESSION['username']; ?></i></li> 
                              <li class="list-group-item text-left">
                                <strong>Contact Number:</strong> <i><?php echo $_SESSION['phone']; ?></i></li>
                              <li class="list-group-item text-left">
                                <strong>Branch:</strong> <i><?php echo $bra_name['branch_name']; ?></i></li>                                      
                            </ul>

                           </div><!--/tab-pane-->
                      </div>
                  </div>
                  
                </ul> 
               
             </div><!--/tab-pane-->
             <div class="tab-pane" id="update">

                  <hr>
                  <form  class="form" action="f/UpdateUserInfo" method="post" id="registrationForm">
                      <div class="form-group">
                          
                          <div class="col-xs-12">
                              <label for="FIRSTNAME">First name</label>
                              <input value="<?php echo $_SESSION['first_name']; ?>"  type="text" class="form-control" name="FIRSTNAME" id="FIRSTNAME" placeholder="first name" title="enter your first name if any.">
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-5">
                            <label for="LASTNAME">Last name</label>
                              <input value="<?php echo $_SESSION['last_name']; ?>" type="text" class="form-control" name="LASTNAME" id="LASTNAME" placeholder="last name" title="enter your last name if any.">
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-5">
                            <label for="LASTNAME">Branch</label>
                              <input value="<?php echo $_SESSION['branch']; ?>" type="text" class="form-control" name="Branch" disabled id="Branch" placeholder="Branch" title="enter your Branch.">
                          </div>
                      </div>

                      <div class="form-group">
                          
                          <div class="col-xs-5">
                              <label for="CONTACTNUMBER">Phone</label>
                              <input value="<?php echo $_SESSION['phone']; ?>" type="text" class="form-control" name="CONTACTNUMBER" id="CONTACTNUMBER" placeholder="enter phone" title="enter your phone number if any.">
                          </div>
                      </div> 
                    
                      <div class="form-group">
                          
                          <div class="col-xs-5">
                              <label for="USERNAME">User Name</label>
                              <input value="<?php echo $_SESSION['username'];  ?>" type="text" class="form-control" name="USERNAME" id="USERNAME" placeholder="Username" title="enter your username.">
                          </div>
                      </div>
                      <div class="form-group">
                          
                   
                      <div class="form-group">
                          
                          <div class="col-xs-5">
                              <label for="password1">Password</label>
                              <input value="" type="password" class="form-control" name="password1" id="password1" placeholder="password" title="enter your password.">
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-5">
                            <label for="password2">Confirm password</label>
                              <input value="" type="password" class="form-control" name="password2" id="password2" placeholder="confirm password" title="enter your password2.">
                          </div>
                      </div> 
                      </div>
                      <div class="form-group">
                           <div class="col-xs-5">
                                <br>
                                <button class="btn btn-lg btn-success btn-sm" name="UpdateUserInfo" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                <button class="btn btn-warning btn-sm" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                            </div>
                      </div>
                </form>
              <!-- </div> -->
               
              </div><!--/tab-pane-->
          </div><!--/tab-content-->
      </div>
      <!-- /.container-fluid -->
      
      <!-- Sticky Footer -->
      <?php include('includes/footer.php'); ?>
     
    </div>
  </div>
    <!-- /.content-wrapper -->
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
   <script src="js/chatJs.js"></script>
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

