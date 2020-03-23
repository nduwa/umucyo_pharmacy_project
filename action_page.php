<?php 
    include('database_connection.php');
    include('includes/config.php');
    require_once('vendor/php-excel-reader/excel_reader2.php');
    require_once('vendor/SpreadsheetReader.php'); 
    session_start();
########################################################################
        # registration of new medical product 
########################################################################
$_SESSION['inserted_medical'] = "";
    if(isset($_POST['save_new_medical_product'])){
        
                $medical_product_name  = $_POST['name'];
                //$medical_batch_no      = $_POST['batch'];
                $medical_category      = $_POST['category'];
                $branch_ID             = $_SESSION['branch'];
                $institution_code      = $_SESSION['institution_code'];
                $medical_insert_date   = date('Y-m-d');
                $medical_product_status= '1';
            
            $sql = "INSERT INTO `medical_product` VALUES(null,'$medical_product_name',
            '$medical_category','$branch_ID','$institution_code','$medical_insert_date','$medical_product_status')";
            $result = $conn->query($sql);
            if($result){
                //echo "well inserted in the system";
                $type = "success";
                        $_SESSION['inserted_medical'] = '<strong class="alert alert-success">Category Data inserted into the Database</strong>
                            
                        </script>';
                header('Location:medical_list');
            }else{
                //echo  "not yet inserted data";
                $type = "Error";
                        $_SESSION['inserted_medical'] = '<strong class="alert alert-danger">Category Data not inserted into the Database</strong>'.'<script>
                            setTimeout(function(){
                                window.location.href = "medical_list";
                            }, 5000);
                        </script>';
                //header('Location:medecine');
            }
        
    }
####################################################################################
            # purchase the medical product
####################################################################################
    if(isset($_POST['purchase_medical_product'])){
        
        $medical_name         = $_POST['product_name'];
        $purchase_price       = $_POST['purchase_price'];
        $selling_price        = $_POST['selling_price'];
        $medical_source       = $_POST['medical_source'];
        $medical_category     = $_POST['category'];
        $batch_number         = $_POST['batch_number'];
        $medical_quantity     = $_POST['quantity'];
        $medical_expired_date = $_POST['expiration_date'];
        $user_ids             = $_POST['user_id'];
        $branch_ID            = $_SESSION['branch'];
        $institution_code     = $_SESSION['institution_code'];
        $purchased_date       = date('Y-m-d');
        $purchase_status      = '1';
        $qty_expired          = '';

        $sql_compare = "SELECT * FROM `purchase_medical_product` WHERE product_name = '$medical_name' AND batch_number = '$batch_number'";
        $result_compare = $conn->query($sql_compare);
        $count = $result_compare->num_rows;
         
        if($count > 0 ){ 
            $row_compare = $result_compare->fetch_assoc();
            $quantity = $row_compare['product_quantity'];
            // $purchase = $row_compare['purchase_price'];
            // $selling = $row_compare['selling_price'];

            $qyt = $medical_quantity+$quantity;

            $sql_update = "UPDATE `purchase_medical_product` SET purchase_price = '$purchase_price', product_quantity = '$qyt', selling_price = '$selling_price', expired_date = '$medical_expired_date' WHERE product_name = '$medical_name' AND batch_number = '$batch_number'";
            $result_update = $conn->query($sql_update);
            echo $conn->error;
            //die();
        
            if($result_update){
                $sql_backup = "INSERT INTO `purchase_medical_product_backup` VALUES(null,'$medical_name','$purchase_price','$selling_price','$medical_category','$medical_source','$batch_number','$medical_quantity','$user_ids','$branch_ID','$institution_code','$medical_expired_date','$purchased_date','$purchase_status','$qty_expired')";
                    $result_backup = $conn->query($sql_backup);
                    if($result_backup){
                        $ppp = '<li class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Purchase well performed in the system</strong>
                        </li>';

                            $_SESSION['reg_msg_purchase'] = $ppp;
                            echo '
                        <script>
                         setTimeout(function(){
                            window.location.href = "medecine_purchase";
                         }, 0);
                        </script>';
                    }
            
            }else{
                echo $conn->error;
                //exit();
                $ppp = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Purchase not yet performed in the system</strong>';

                $_SESSION['reg_msg_purchase'] = $ppp;
                echo '<script>
                setTimeout(function(){
                    window.location.href = "medecine_purchase";
                }, 0);
                </script>';
       
            }


        }else{

        $sql = "INSERT INTO `purchase_medical_product` VALUES(null,'$medical_name','$purchase_price','$selling_price','$medical_category','$medical_source','$batch_number','$medical_quantity','$user_ids','$branch_ID','$institution_code','$medical_expired_date','$purchased_date','$purchase_status','$qty_expired')";
        $result = $conn->query($sql);
        
        if($result){
            $sql_backup = "INSERT INTO `purchase_medical_product_backup` VALUES(null,'$medical_name','$purchase_price','$selling_price','$medical_category','$medical_source','$batch_number','$medical_quantity','$user_ids','$branch_ID','$institution_code','$medical_expired_date','$purchased_date','$purchase_status','$qty_expired')";
                $result_backup = $conn->query($sql_backup);
                if($result_backup){
                    $ppp = '<li class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Purchase well performed in the system</strong>
                    </li>';

                        $_SESSION['reg_msg_purchase'] = $ppp;
                        echo '
                    <script>
                     setTimeout(function(){
                        window.location.href = "medecine_purchase";
                     }, 0);
                    </script>';
                }
            
        }else{
            echo $conn->error;
            exit();
            $ppp = '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Purchase not yet performed in the system</strong>';

            $_SESSION['reg_msg_purchase'] = $ppp;
            echo '<script>
            setTimeout(function(){
                window.location.href = "medecine_purchase";
            }, 0);
            </script>';
   
        }
       } 
    }
############################################################################################
            #   selling price changing
############################################################################################
    if(isset($_POST['medical_selling_price'])){
        $medical_ID           = $_POST['product_ID'];
        $selling_price        = $_POST['selling_price'];              
        $user_ids             = $_POST['user_id'];
        $branch_ID             = $_SESSION['branch'];
        $changing_date        = date('Y-m-d');
        $selling_price_status = '1'; 
        $sql = "UPDATE medical_selling_price SET selling_price_status ='0' 
            WHERE selling_price_status = '1' AND product_ID = '$medical_ID'";
        $result = $conn->query($sql);
        if($result){
            $query = "INSERT INTO `medical_selling_price` VALUES(null,'$medical_ID',
            '$selling_price','$user_ids','$branch_ID','$changing_date','$selling_price_status')";
            $result_update = $conn->query($query);
            if($result_update){
                echo "well inserted in the system";
                header('Location:selling_price');
            }else{
                echo  "not yet inserted data";
                echo $conn->error;
                header('Location:selling_price');
            }
        }else{
            echo  "not yet inserted data";
            echo $conn->error;
            header('Location:selling_price');
        }  
    }
############################################################################################
        #   category type   #
############################################################################################
    if(isset($_POST['add_new_category'])){
        try{
            $medecine_category = array(
                ':category_name'  => $_POST['category_name'],
                ':category_desc'  => $_POST['cat_decription'],
                ':user_ids'       => $_POST['user_id'],
                ':branch'         => $_SESSION['branch'],
                ':institution_code' => $_SESSION['institution_code'],
                ':insert_date'    => date('Y-m-d'),
                ':statuse'         => '1'
            );
            $sql = "INSERT INTO `medical_category` VALUES(null,:category_name,
            :category_desc,:user_ids,:branch,:institution_code,:insert_date,:statuse)";
            $result = $connect->prepare($sql);
            if($result->execute($medecine_category)){
                echo "well inserted in the system";
                header('Location:medecine_cat');
            }else{
                echo  "not yet inserted data";
                header('Location:medecine_cat');
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
    }
############################################################################################
        #   category type   #
############################################################################################
    if(isset($_POST['save_branch'])){
        try{
            $branch = array(
                ':branch_name'    => $_POST['branch_name'],
                ':institution_code'    => $_SESSION['institution_code'],
                ':province_name'  => $_POST['province_name'],
                ':district_name'  => $_POST['district_name'],
                ':region'         => $_POST['region'],
                ':user_ids'       => $_POST['user_id'],
                ':insert_date'    => date('Y-m-d'),
                ':statuse'        => '0'
            );
            $sql = "INSERT INTO `phar_branch` VALUES(null,:branch_name,:institution_code,
            :province_name,:district_name,:region,:user_ids,:insert_date,:statuse)";
            $result = $connect->prepare($sql);
            if($result->execute($branch)){
                echo "well inserted in the system";
                header('Location:pharmacy_branch');
            }else{
                echo  "not yet inserted data";
                header('Location:pharmacy_branch');
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        
    }
/*==========================================================================
				Update user access part
============================================================================*/
    if (isset($_REQUEST['user_status'])) {
        $status = $_REQUEST['status'];
        $id =$_REQUEST['user_ID'];
        //$col = $_REQUEST['user_status'];
        $sql = "UPDATE `login` SET user_status = '$status' WHERE user_id = '$id'";
        $result = $conn->query($sql);
        if ($result) {
            $url = "pharmacy_users.php?msg=&done";
        }
        else{
            $url = "pharmacy_users.php?msg=&Error".$conn->error;
        }
        header('location: '.$url);
    }
/*==========================================================================
				Update institution users access part
============================================================================*/
if (isset($_REQUEST['inst_user_status'])) {
    $status = $_REQUEST['status'];
    $id =$_REQUEST['user_ID'];
    //$col = $_REQUEST['user_status'];
    $sql = "UPDATE `login` SET user_status = '$status' WHERE user_id = '$id'";
    $result = $conn->query($sql);
    if ($result) {
        $url = "phar_institution?msg=&done";
    }
    else{
        $url = "phar_institution?msg=&Error".$conn->error;
    }
    header('location: '.$url);
}
/*==========================================================================
				Update branch access part
============================================================================*/
if (isset($_REQUEST['branch_status'])) {
    $status = $_REQUEST['status'];
    $id =$_REQUEST['branch_ID'];
    //$col = $_REQUEST['user_status'];
    $sql = "UPDATE `phar_branch` SET branch_status = '$status' WHERE branch_ID = '$id'";
    $result = $conn->query($sql);
    if ($result) {
        $url = "pharmacy_branch.php?msg=&done";
    }
    else{
        $url = "pharmacy_branch.php?msg=&Error".$conn->error;
    }
    header('location: '.$url);
}

           # registration of a pharmacy user
####################################################################################
$_SESSION['reg_msg'] = "";
#################function for generating random password#######################
  

    if(isset($_POST['pharmacy_users_registration'])){

             $first_name   = $_POST['first_name'];
             $last_name    = $_POST['last_name'];

             $full_name   = $first_name.$last_name."1234567890";
             $length      = 5;
             ##function for generating user password
            function random_alphanumeric($full_name,$length) {
            $my_string = '';
            for ($i = 0; $i < $length; $i++) {
              $pos = mt_rand(0, strlen($full_name) -1);
              $my_string .= substr($full_name, $pos, 1);
              }
              return $my_string;
              }
            

            $user_email   = $_POST['user_email'];
            $user_phone   = $_POST['user_phone'];
            $branch_ID    = $_POST['branch_ID'];
            $role_id      = $_POST['role_id'];
            $username     = $_POST['username'];
            //$pass         = random_alphanumeric($full_name ,5);
            $pass         = 'umucyo';
            $passcode     = password_hash($pass, PASSWORD_DEFAULT);
            $user_ids     = $_SESSION['user_id'];
            $user_status  = '0';
            $pass_update  = '0';
            $reg_date     = date('Y-m-d');

        $sql_check_username = "SELECT * FROM `login` WHERE username = '$username' ";
        $sql_check_user_email = "SELECT * FROM `login` WHERE email = '$user_email' ";
        $sql_user_name = $conn->query($sql_check_username);
        $sql_user_email= $conn->query($sql_check_user_email);
       
        if ($sql_user_name->num_rows > 0) {
            //echo "<script>alert('Username taken'); </script>";
            $_SESSION['reg_msg'] = '
                                    <div class="alert alert-danger alert-dismissible">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <strong>Username taken</strong>
                                    </div>';
        echo '
        <script>
         setTimeout(function(){
            window.location.href = "pharmacy_users";
         }, 0);
        </script>';
        }
        elseif ($sql_user_email->num_rows > 0) {
            # code...
            //echo "<script>alert('Email taken');</script>";
            $_SESSION['reg_msg'] = '<div class="alert alert-danger alert-dismissible">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <strong>Email taken</strong>
                                    </div>';
        echo '
        <script>
         setTimeout(function(){
            window.location.href = "pharmacy_users";
         }, 0);
        </script>';
        }
        else{

        $sql = "INSERT INTO `login` VALUES(null,'$first_name','$last_name','$user_phone',
        '$username','$passcode','$user_email','$_SESSION[institution_code]','$branch_ID','$role_id','$user_ids','$reg_date','$user_status','$pass_update')";
        $result = $conn->query($sql);
        $last_id = $conn->insert_id;
        if($result){
            // $sql_priv = "INSERT INTO `user_privilegies`(users_id,role_id) VALUES('$last_id','$role_id')";
            // $results = $conn->query($sql_priv);
            // if($results){
            //echo "well inserted in the system";
            $ppp = '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>well inserted in the system</strong>
                    <p><i style="color: #000;">Username is: </i><b>'.$username.'</b>';

            $user_pass = '<i style="color: #000;">Password is:</i> <b>'.$pass.'</b>';
            $ppp2 = '</div>';
            $user_info = '<p> Password and username is sent to this email <strong>'.$user_email.'</strong></p>';

            $_SESSION['reg_msg'] = $ppp." and ".$user_pass.$ppp2;

/*

            require 'PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;

			$mail->isSMTP();                            // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                     // Enable SMTP authentication
			$mail->Username = 'niyongirapatrick29@gmail.com';          // SMTP username
			$mail->Password = 'Patrick321'; // SMTP password
			$mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                          // TCP port to connect to

			$mail->setFrom('niyongirapatrick29@gmail.com', 'UMUCYO Pharmacy managment');
			$mail->addReplyTo('niyongirapatrick29@gmail.com', 'UMUCYO Pharmacy managment');
			$mail->addAddress($user_email);   // Add a recipient
			$mail->addCC($user_email);
			$mail->addBCC($user_email);

			$mail->isHTML(true);  // Set email format to HTML
			define('SITE_URL', 'http://localhost/pharmacyApp/');
			$bodyContent = '<h1>Account Registration Information from Pharmacy management system</h1>';
			$bodyContent .= '<p>Email from <b>UMUCYO pharmacy management system</b>
							Your username: '.$username. ' Password: '.$pass.'</p>
							<a href="'.SITE_URL.'"index">Login</a>';

			$mail->Subject = 'Email from Umucyo Pharmacy management system.';
			$mail->Body    = $bodyContent;

			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    echo 'Message has been sent';
			     $_SESSION['reg_msg'] = $ppp." and ".$user_pass.$ppp2.' and also '.$user_info;
			}


            */
			            echo '
			        <script>
			         setTimeout(function(){
			            window.location.href = "pharmacy_users";
			         }, 0);
			        </script>';




			            //}
			        }else{
			            //echo  "not yet inserted data".$conn->error;
			            $_SESSION['reg_msg'] = '<div class="alert alert-warning alert-dismissible">
			                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
			                                      <strong>User data not saved</strong>
			                                    </div>';

			            //header('Location:pharmacy_users'.$conn->error);
			            echo '
			        <script>
			         setTimeout(function(){
			            window.location.href = "pharmacy_users";
			         }, 0);
			        </script>';
			        }
			    }
			}
####################################################################################           
         # registration of a pharmacy institution
$_SESSION['reg_msg_inst'] = "";
#################function for generating random password#######################
  

    if(isset($_POST['pharmacy_institution_registration'])){
        $institution_name   = $_POST['institution_name'];
        $institution_email  = $_POST['institution_email'];
        $institution_phone  = $_POST['institution_phone'];
        $institution_tin    = $_POST['institution_tin'];
        $institution_location  = $_POST['institution_location'];
        $first_name            = $_POST['first_name'];
        $last_name          = $_POST['last_name'];

        $full_name   = $first_name.$last_name."1234567890";
        $length      = 5;
        $inst_code   = $institution_name."1234567890";
        ##function for generating user password
        function random_alphanumeric($inst_code,$length) {
            $my_string = '';
            for ($i = 0; $i < $length; $i++) {
                $pos = mt_rand(0, strlen($inst_code) -1);
                $my_string .= substr($inst_code, $pos, 1);
            }
            return $my_string;
        }
        
        $user_email   = $_POST['user_email'];
        $user_phone   = $_POST['user_phone'];
        $branch_ID    = $_POST['branch_ID'];
        $role_id      = $_POST['role_id'];
        $username     = $_POST['username'];
        $code_inst    = random_alphanumeric($inst_code ,5);
        $pass         = random_alphanumeric($inst_code ,5);
        $passcode     = password_hash($pass, PASSWORD_DEFAULT);
        $user_ids     = $_SESSION['user_id'];
        $user_status  = '0';
        $pass_update  = '0';
        $reg_date     = date('Y-m-d');

        $sql_inst = "INSERT INTO `phar_institution`(institution_id,institution_name,institution_email,institution_phone,institution_code,institution_TIN,
        institution_location,registered_by,reg_date,institution_status) VALUES(null,'$institution_name','$institution_email','$institution_phone','$code_inst',
        '$institution_tin','$institution_location','$user_ids','$reg_date','$user_status')";
        $result_inst = $conn->query($sql_inst);
        if($result_inst){

        
        $sql = "INSERT INTO `login`(user_id,first_name,last_name,phone,username,password,email,institution_code,branch,role_id,registered_by,
        reg_date,user_status,pass_updated) VALUES(null,'$first_name','$last_name','$user_phone','$username','$passcode',
        '$user_email','$code_inst','$branch_ID','$role_id','$user_ids','$reg_date','$user_status','$pass_update')";
        $result = $conn->query($sql);
        $last_id = $conn->insert_id;
        if($result){
            // $sql_priv = "INSERT INTO `user_privilegies`(users_id,role_id) VALUES('$last_id','$role_id')";
            // $results = $conn->query($sql_priv);
            // if($results){
            //echo "well inserted in the system";
            $ppp = '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>well inserted in the system</strong>
                    <p><i style="color: #000;">Username is: </i><b>'.$username.'</b>';

            $user_pass = '<i style="color: #000;">Password is:</i> <b>'.$pass.'</b>';
            $user_code = '<i style="color: #000;">Password is:</i> <b>'.$code_inst.'</b>';
            $ppp2 = '</div>';

            $_SESSION['reg_msg_inst'] = $ppp." and ".$user_pass.$ppp2. "
             and institution code ".$user_code;
            echo '
        <script>
         setTimeout(function(){
            window.location.href = "phar_institution";
         }, 0);
        </script>';
        
        }else{
            //echo  "not yet inserted data".$conn->error;
            $_SESSION['reg_msg_inst'] = '<div class="alert alert-warning alert-dismissible">
                                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                                      <strong>User data not saved</strong>
                                    </div>';

            //header('Location:pharmacy_users'.$conn->error);
            echo '
        <script>
         setTimeout(function(){
            window.location.href = "phar_institution";
         }, 0);
        </script>';
        }
    }
}
####################################################################################
            # registration of the branch expenses
####################################################################################
    if(isset($_POST['send_expenses'])){
        $bank_number    = $_POST['bank_number'];
        $expense_amount = $_POST['expense_amount'];
        $branch_id      = $_POST['branch_id'];
        $institution_code = $_SESSION['institution_code'];
        $user_ids       = $_POST['user_id'];
        $expense_reason = $_POST['expense_reason'];
        $expense_status    = '2';
        $expense_date       = date('y-m-d');
        $reg_time       = date('h:m:i');
    $sql = "INSERT INTO `medical_expense`(expense_ID,bank_number,expense_amount,
    branch_id,institution_code,user_ids,expense_reason,expense_date,reg_time,expense_status) 
    VALUES(null,'$bank_number','$expense_amount','$branch_id','$institution_code','$user_ids',
    '$expense_reason','$expense_date','$reg_time','$expense_status')";
    $result = $conn->query($sql);
    if($result){
        echo "well inserted in the system";
        header('Location:expenses');
    }else{
        echo  "not yet inserted data".$conn->error;
        header('Location:expenses'.$conn->error);
    }
    }  
####################################################################################
            # registration of the branch incomes    
####################################################################################
    if(isset($_POST['send_medical_income'])){
        $bank_number    = $_POST['bank_number'];
        $income_amount  = $_POST['income_amount'];
        $branch_id      = $_POST['branch_id'];
        $institution_code = $_SESSION['institution_code'];
        $user_ids       = $_POST['user_id'];
        $income_reason  = $_POST['income_reason'];
        $income_status    = '2';
        $income_date       = date('y-m-d');
        $reg_time       = date('h:m:i');
        $sql = "INSERT INTO `medical_incomes`(income_ID,bank_number,income_amount,
        branch_id,institution_code,user_ids,income_reason,income_date,reg_time,income_status) 
        VALUES(null,'$bank_number','$income_amount','$branch_id','$institution_code','$user_ids',
        '$income_reason','$income_date','$reg_time','$income_status')";
        $result = $conn->query($sql);
        if($result){
            echo "well inserted in the system";
            header('Location:medical_income');
        }else{
            echo  "not yet inserted data".$conn->error;
            header('Location:medical_income'.$conn->error);
        }
    }
 ####################################################################################
            # registration of the system roles
####################################################################################
if(isset($_POST['new_level'])){
    $role_name    = $_POST['post'];
    $institution_code = $_SESSION['institution_code'];
    $reg_date       = date('y-m-d');
    
    $sql = "INSERT INTO `user_role` 
    VALUES(null,'$role_name','$institution_code','$reg_date')";
    $result = $conn->query($sql);
    $last_id = $conn->insert_id;
    if($result){
        $sql_priv = "INSERT INTO `user_privilegies`(role_id,institution_code)
        VALUES('$last_id','$institution_code')";
        $results = $conn->query($sql_priv);
        if($results){
        
        echo "well inserted in the system";
        header('Location:pharmacy_privilegie');
    }
}else{
        echo  "not yet inserted data".$conn->error;
        header('Location:pharmacy_privilegie'.$conn->error);
    }
}      
/*==========================================================================
				to approve the income in the system
============================================================================*/
if (isset($_REQUEST['Approve'])) {
    $status = '1';
    $approver   = $_REQUEST['Approver'];
    $id         = $_REQUEST['Approve'];
    //$col = $_REQUEST['user_status'];
    $sql = "UPDATE `medical_incomes` SET income_status = '$status', 
    approved_by = '$approver' WHERE income_ID = '$id'";
    $result = $conn->query($sql);
    if ($result) {
        $url = "medical_income.php?msg=&done";
    }
    else{
        $url = "medical_income.php?msg=&Error".$conn->error;
    }
    header('location: '.$url);
} 
/*==========================================================================
				to hidding the income in the system
============================================================================*/
if (isset($_REQUEST['Hidding_income'])) {
    $status = '0';
    $approver   = $_REQUEST['Approver'];
    $id         = $_REQUEST['Hidding_income'];
    //$col = $_REQUEST['user_status'];
    $sql = "UPDATE `medical_incomes` SET income_status = '$status', 
    Hidder = '$approver' WHERE income_ID = '$id'";
    $result = $conn->query($sql);
    if ($result) {
        $url = "medical_income.php?msg=&done";
    }
    else{
        $url = "medical_income.php?msg=&Error".$conn->error;
    }
    header('location: '.$url);
} 
/*==========================================================================
				to approve the expense in the system
============================================================================*/
if (isset($_REQUEST['Approve_expense'])) {
    $status = '1';
    $approver   = $_REQUEST['Approver'];
    $id         = $_REQUEST['Approve_expense'];
    $approval_date       = date('y-m-d');
    //$col = $_REQUEST['user_status'];
    $sql = "UPDATE `medical_expense` SET expense_status = '$status', 
    approved_by = '$approver', approved_date = '$approval_date' WHERE expense_ID = '$id'";
    $result = $conn->query($sql);
    if ($result) {
        $url = "expenses.php?msg=&done";
    }
    else{
        $url = "expenses.php?msg=&Error".$conn->error;
    }
    header('location: '.$url);
} 
/*==========================================================================
				to hidding the expenses in the system
============================================================================*/
if (isset($_REQUEST['Hidding_expense'])) {
    $status = '0';
    $approver   = $_REQUEST['Approver'];
    $id         = $_REQUEST['Hidding_expense'];
    $hidding_date       = date('y-m-d');
    //$col = $_REQUEST['user_status'];
    $sql = "UPDATE `medical_expense` SET expense_status = '$status', 
    Hidder = '$approver', Hidding_date = '$hidding_date' WHERE expense_ID = '$id'";
    $result = $conn->query($sql);
    if ($result) {
        $url = "expenses.php?msg=&done";
    }
    else{
        $url = "expenses.php?msg=&Error".$conn->error;
    }
    header('location: '.$url);
} 


###################export all sales #################

if(isset($_POST["export"])) {   
if($_SESSION['role_id']==3){
    $sql_query = "SELECT medical_product.product_Nmae as MEDICAL_NAME, total_sales.quantity as SOLD_QUANTITY,
    total_sales.price as UNIT_PRICE, total_sales.total_price as TOTAL_AMOUNT,login.first_name as DONE_BY,login.last_name as DONE,
    phar_branch.branch_name, phar_institution.institution_name as INSTITUTION, total_sales.customer_name,total_sales.customer_telphone,total_sales.date_with_hours
    ,total_sales.payment_mode FROM total_sales
    INNER JOIN `login`  ON total_sales.userID = login.user_id
    INNER JOIN medical_product ON total_sales.medicine_ID = medical_product.product_ID
    INNER JOIN `phar_branch` ON total_sales.User_branch = phar_branch.branch_ID
    INNER JOIN `phar_institution` ON total_sales.institution_code = phar_institution.institution_code
    WHERE total_sales.institution_code = '$_SESSION[institution_code]' ORDER BY Ids ASC";
}else{
    $sql_query = "SELECT medical_product.product_Nmae as MEDICAL_NAME, total_sales.quantity as SOLD_QUANTITY,
    total_sales.price as UNIT_PRICE, total_sales.total_price as TOTAL_AMOUNT,login.first_name as DONE_BY
    ,login.last_name as DONE,
    phar_branch.branch_name, phar_institution.institution_name as INSTITUTION, total_sales.customer_name,
    total_sales.customer_telphone,total_sales.date_with_hours,total_sales.payment_mode FROM total_sales 
    INNER JOIN `login`  ON total_sales.userID = login.user_id
    INNER JOIN medical_product ON total_sales.medicine_ID = medical_product.product_ID
    INNER JOIN `phar_branch` ON total_sales.User_branch = phar_branch.branch_ID
    INNER JOIN `phar_institution` ON total_sales.institution_code = phar_institution.institution_code
    WHERE total_sales.User_branch = '$_SESSION[branch]' AND total_sales.institution_code = '$_SESSION[institution_code]' ORDER BY Ids ASC";
}

$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
$data_records = array();
while( $rows = mysqli_fetch_assoc($resultset) ) {
    $data_records[] = $rows;
}



    $filename = "All_sales_".date('Ymd') . ".xls";          
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");  
    $is_coloumn = false;
    if(!empty($data_records)) {
      foreach($data_records as $value) {
        if(!$is_coloumn) {       
          echo implode("\t", array_keys($value)) . "\n";
          $is_coloumn = true;
        }
        echo implode("\t", array_values($value)) . "\n";
      }
    }
    exit;  
}

################### export all pharmacy users #################

if(isset($_POST["export_user"])) {   

$sql_query = "SELECT first_name,last_name,username,email,branch_name,branch_province,
               brannch_district,branch_region,branch_status,inserted_date FROM `login` 
                INNER JOIN `phar_branch` ON login.branch = phar_branch.branch_ID";

$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
$data_records = array();
while( $rows = mysqli_fetch_assoc($resultset) ) {
    $data_records[] = $rows;
}



    $filename = "All_user_".date('Ymd') . ".xls";          
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");  
    $is_coloumn = false;
    if(!empty($data_records)) {
      foreach($data_records as $value) {
        if(!$is_coloumn) {       
          echo implode("\t", array_keys($value)) . "\n";
          $is_coloumn = true;
        }
        echo implode("\t", array_values($value)) . "\n";
      }
    }
    exit;  
}


########### import medicine using excel file #####################
$_SESSION['imported'] = "";
if (isset($_POST["import"]))
{
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $med_name = "";
                if(isset($Row[0])) {
                    $med_name = mysqli_real_escape_string($conn,$Row[0]);
                }
                
                $category = "";
                if(isset($Row[1])) {
                    $category = mysqli_real_escape_string($conn,$Row[1]);
                }

               /* $branch_ID = "";
                if(isset($Row[2])) {
                    $branch_ID = mysqli_real_escape_string($conn,$Row[3]);
                }

                $institution_code = "";
                if(isset($Row[3])) {
                    $institution_code = mysqli_real_escape_string($conn,$Row[1]);
                }*/
                
                if (!empty($med_name) || !empty($category)) {
                    
                    $dat = date('y-m-d');
                    $query = "
                    INSERT INTO medical_product(product_Nmae , category, branch_ID, institution_code, register_date,product_status) 
                    values('".$med_name."','".$category."','".$_SESSION['branch']."','".$_SESSION['institution_code']."','".$dat."','1')";
                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $_SESSION['imported'] = '<strong class="alert alert-success">Excel Data Imported into the Database</strong>'.'<script>
         setTimeout(function(){
            window.location.href = "medical_list";
         }, 5000);
      </script>';;
                       
                        header('location: medical_list');
                    } else {
                        $type = "error";
                        $_SESSION['imported'] ='                        
                                                <strong class="alert alert-success">Problem in Importing Excel Data</strong>
                                              ';
                          header('location: medical_list');                    
                    }
                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
########### import medicine using excel file #####################
$_SESSION['imported_category'] = "";
if (isset($_POST["import_category"]))
{
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $category_name = "";
                if(isset($Row[0])) {
                    $category_name = mysqli_real_escape_string($conn,$Row[0]);
                }
                
                $category_desc = "";
                if(isset($Row[1])) {
                    $category_desc = mysqli_real_escape_string($conn,$Row[1]);
                }

                            
                if (!empty($category_name) || !empty($category_desc)) {
                    
                    $dat = date('y-m-d');
                    $query = " INSERT INTO medical_category values('".$category_name."','".$category_desc."',
                    '".$_SESSION['user_id']."', '".$_SESSION['branch']."','".$_SESSION['institution_code']."','".$dat."','1')";
                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $_SESSION['imported_category'] = '<strong class="alert alert-success">Excel Data Imported into the Database</strong>'.'<script>
                            setTimeout(function(){
                                window.location.href = "medical_list";
                            }, 5000);
                        </script>';
                                        
                          header('location: medical_list');
                    } else {
                        $type = "error";
                        $_SESSION['imported_category'] ='                        
                                                <strong class="alert alert-success">Problem in Importing Excel Data</strong>
                                              ';
                          header('location: medical_list');                    
                    }
                }
            }
        
        }
    }
    else{ 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
    }
}

$_SESSION['med_deleted'] = "";
#################### Delete medicine #######################
if (isset($_GET['delete']) && isset($_GET['med_name'])) {
    # code...
    
    $ID = $_GET['delete'];
    $med_name = $_GET['med_name'];

    $delete_m ="DELETE FROM `medical_product` WHERE product_ID='$ID'";
    $deleted = $conn->query($delete_m);
    if ($deleted) {
        # code...
        $_SESSION['med_deleted'] ='
        <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>'.$med_name.'<?strong> deleted successfully</div>';
        header('Location: medical_list');
    }
    else{
        $_SESSION['med_deleted'] ='
        <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>'.$med_name.'</strong>
        Medecine not deleted, try again</div>';
        header('Location: medical_list');
    }
}

############## GET ALL MEDECINE DETAILS #########################
if (isset($_GET['edit'])) {
    # code...
    $med_detail = "SELECT * FROM  `medical_product` INNER JOIN  `medical_category`
          ON medical_product.category = medical_category.category_ID WHERE product_ID='$_GET[edit]'";
    $med_details = $conn->query($med_detail);
    $med         = $med_details->fetch_assoc();
    
    $_SESSION['med_name'] = $med['product_Nmae'];
    $_SESSION['med_ID']   = $med['product_ID'];
    $_SESSION['category'] = $med['category'];
    $_SESSION['batch_No'] = $med['batch_No'];
    $_SESSION['category_name'] = $med['category_name'];


    header('Location: medicine_d');
    
}



############# UPDATE MEDICINE DETAILS #####################
 
if (isset($_POST['med_update'])) {
    # code...
     $_SESSION['med_updated'] = "";
    $med_up = "UPDATE `medical_product` SET product_Nmae = '$_POST[med_name]', category='$_POST[med_category]' WHERE product_ID='$_POST[med_ID]'";
    $med_updates = $conn->query($med_up);
    if ($med_updates) {
        # code...
        $_SESSION['med_updated'] = '<div class="alert alert-success alert-dismissible">
                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                      <strong>Success!</strong> Medecine Updated.
                                      <i class="spinner-border spinner-border-sm"></i>
                                      <i class="spinner-grow spinner-grow-sm"></i>
                                    </div>
                                      <div class="spinner-grow text-muted"></div>
                                      <div class="spinner-grow text-primary"></div>
                                      <div class="spinner-grow text-success"></div>
                                      <div class="spinner-grow text-info"></div>
                                      <div class="spinner-grow text-warning"></div>
                                      <div class="spinner-grow text-danger"></div>
                                      <div class="spinner-grow text-secondary"></div>
                                      <div class="spinner-grow text-dark"></div>
                                      <div class="spinner-grow text-light"></div>';
        header('Location: medicine_d');
    }

    else{
        $_SESSION['med_updated'] = '<div class="alert alert-danger alert-dismissible">
                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                      <strong>Try again!</strong> Medecine not Updated.
                                    </div>
                                    <div class="spinner-grow text-warning"></div>
                                      <div class="spinner-grow text-danger"></div>
                                      <div class="spinner-grow text-warning"></div>
                                      <div class="spinner-grow text-danger"></div>
                                      <div class="spinner-grow text-warning"></div>
                                      <div class="spinner-grow text-danger"></div>
                                      <div class="spinner-grow text-warning"></div>
                                      <div class="spinner-grow text-danger"></div>
                                      <div class="spinner-grow text-warning"></div>
                                      <div class="spinner-grow text-danger"></div>';
        header('Location: medicine_d');
    }

}
/*=========================================================================
				view users privilege part
==========================================================================*/

################## acc_privilegie ##########################
if (isset($_REQUEST['acc_privilegie'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_privilegie = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_medecine ##########################
if (isset($_REQUEST['acc_medecine'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_medecine = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_purchased ##########################
if (isset($_REQUEST['acc_purchased'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_purchased = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_management ##########################
if (isset($_REQUEST['acc_management'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_management = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_to_serve ##########################
if (isset($_REQUEST['acc_to_serve'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_to_serve = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_all_served ##########################
if (isset($_REQUEST['acc_all_served'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_all_served = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_branches ##########################
if (isset($_REQUEST['acc_branches'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_branches = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_manager_report ##########################
if (isset($_REQUEST['acc_manager_report'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_manager_report = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_pharmacy_user ##########################
if (isset($_REQUEST['acc_pharmacy_user'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_pharmacy_user = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_transaction ##########################
if (isset($_REQUEST['acc_transaction'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_transaction = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_medecine_list ##########################
if (isset($_REQUEST['acc_medecine_list'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_medecine_list = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## acc_medecine_cat ##########################
if (isset($_REQUEST['acc_medecine_cat'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET acc_medecine_cat = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
###########################################################################
################## new medecine ##########################
if (isset($_REQUEST['new_medecine'])) {
    $status = $_REQUEST['status'];
    $col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET new_medecine = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## export medecine ##########################
if (isset($_REQUEST['export_medecine'])) {
    $status = $_REQUEST['status'];
    $col = $_REQUEST['export_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET export_medecine = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## medecine ##########################
if (isset($_REQUEST['remove_medecine'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET remove_medecine = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## new medecine category ##########################
if (isset($_REQUEST['new_medecine_cat'])) {
    $status = $_REQUEST['status'];
    $col = $_REQUEST['new_medecine_cat'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET new_medecine_cat = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## export medecine category ##########################
if (isset($_REQUEST['export_medecine_cat'])) {
    $status = $_REQUEST['status'];
    $col = $_REQUEST['export_medecine_cat'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET export_medecine_cat = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## new expenses ##########################
if (isset($_REQUEST['new_expenses'])) {
    $status = $_REQUEST['status'];
    $col = $_REQUEST['new_expenses'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET new_expenses = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## approve expenses ##########################
if (isset($_REQUEST['approve_expenses'])) {
    $status = $_REQUEST['status'];
    $col = $_REQUEST['approve_expenses'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET approve_expenses = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## new incomes ##########################
if (isset($_REQUEST['new_incomes'])) {
    $status = $_REQUEST['status'];
    $col = $_REQUEST['new_incomes'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET new_incomes = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## approve incomes ##########################
if (isset($_REQUEST['approve_incomes'])) {
    $status = $_REQUEST['status'];
    $col = $_REQUEST['approve_incomes'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET approve_incomes = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## new purchased ##########################
if (isset($_REQUEST['new_purchase'])) {
    $status = $_REQUEST['status'];
    $col = $_REQUEST['new_purchase'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET new_purchase = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## transaction_refound ##########################
if (isset($_REQUEST['transaction_refound'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET transaction_refound = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## loan_recovery ##########################
if (isset($_REQUEST['loan_recovery'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET loan_recovery = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## loan_recovery ##########################
if (isset($_REQUEST['view_current_quantity'])) {
    $status = $_REQUEST['status'];
    //$col = $_REQUEST['new_medecine'];
    $role = $_REQUEST['role'];
    $sql = "UPDATE user_privilegies SET view_current_quantity = '$status' WHERE role_id = '$role'";
    $result = $conn->query($sql);
    if ($result) {
       $url = "user_access?id=".$role."&done";
   }
   else{
       $url = "user_access?id=".$role."&error";
   }
    header('location: '.$url);
}
################## REFOUND THE SERVED MEDECINE ##########################
if (isset($_GET['refound'])) {
    $_SESSION['refounded'] = "";
    $transaction_id = $_GET['refound'];
    $refound_trnsaction = " UPDATE `total_sales` SET payment_mode='Refounded'
    WHERE transaction_ID = '$transaction_id'";

    $refound_sql = $conn->query($refound_trnsaction);
    if($refound_sql){
        echo '<script> alert("Done"); </script>';
        $_SESSION['refounded'] = '
        <div class="alert alert-success">
            <strong>done </strong>
        </div>
        ';
        header('Location: profile');
    }else{
        echo '<script> alert("NOT"); </script>';
        $_SESSION['refounded'] = '
        <div class="alert alert-danger">
            <strong>not done </strong>
        </div>
        ';
    header('Location: profile');
    } 
}
################## ALL SALES REPORT ##########################
if (isset($_GET['remove_expired'])) {
    
    $_SESSION['remove_expired'] = "";
    $batch_number = $_GET['remove_expired'];
    $qty_expired = $_GET['qty_expired'];
    $expired_medecine = " UPDATE `purchase_medical_product` SET purchase_status='0',
    expired_qty = '$qty_expired' WHERE batch_number = '$batch_number'";

    $expired_sql = $conn->query($expired_medecine);
    if($expired_sql){
        echo '<script> alert("Done"); </script>';
        $_SESSION['remove_expired'] = '
        <div class="alert alert-success">
            <strong>done </strong>
        </div>
        ';
        header('Location: medecine_purchase');
    }else{

        echo '<script> alert("NOT"); </script>';
        $_SESSION['remove_expired'] = '
        <div class="alert alert-danger">
            <strong>not done </strong>
        </div>
        ';
    header('Location: medecine_purchase');
    } 
}

###############################  RESET USER PASSWORD #######################
if (isset($_POST['reset_pass'])) {
    $user_email_recovery = $_POST['reset_email'];
    echo $user_email_recovery;
    $sql1 = "UPDATE `login` SET pass_updated = '0' WHERE email = '$user_email_recovery'";
    $result1 = $conn->query($sql1);
    if ($result1) {

    $sql2 = "SELECT * FROM login INNER JOIN `phar_branch` ON login.branch=phar_branch.branch_ID
            WHERE email = '$user_email_recovery'";
    $result2 = $conn->query($sql2);
     while($row = $result2->fetch_assoc()){
     	$_SESSION['reset_password'] = "";
        $_SESSION['user_id']    = $row['user_id'];
        $_SESSION['username']   = $row['username'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name']  = $row['last_name'];
        $_SESSION['phone']      = $row['phone'];
        $_SESSION['email']      = $row['email'];
        //$_SESSION['institution_code'] = $row['institution_code'];
        $_SESSION['branch']     = $row['branch'];
        $_SESSION['role_id']    = $row['role_id'];
        $_SESSION['branch_sta'] = $row['branch_status'];
        $_SESSION['reg_date']   = $row['reg_date'];
        $_SESSION['user_status']= $row['user_status'];
        $_SESSION['pass_updated']=$row['pass_updated'];
        $_SESSION['last_time']  = time();
       }
        

        require 'PHPMailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;

			$mail->isSMTP();                            // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                     // Enable SMTP authentication
			$mail->Username = 'niyongirapatrick29@gmail.com';          // SMTP username
			$mail->Password = 'Patrick321'; // SMTP password
			$mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                          // TCP port to connect to

			$mail->setFrom('niyongirapatrick29@gmail.com', 'UMUCYO Pharmacy managment');
			$mail->addReplyTo('niyongirapatrick29@gmail.com', 'UMUCYO Pharmacy managment');
			$mail->addAddress($user_email_recovery);   // Add a recipient
			$mail->addCC($user_email_recovery);
			$mail->addBCC($user_email_recovery);

			$mail->isHTML(true);  // Set email format to HTML
			$emm = md5($user_email_recovery);
			define('SITE_URL', 'http://localhost/pharmacyApp/action_page.php?user_em='.$emm);
			$bodyContent = '<h1>Password reset link from UMUCYO Pharmacy management system</h1>';
			$bodyContent .= '</p>
							 <a href="'.SITE_URL.'" style="font-size: 1.2em;" class="btn btn-primary btn-sm">Reset password</a>';

			$mail->Subject = 'Email Password reset link from Umucyo Pharmacy management system.';
			$mail->Body    = $bodyContent;

			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			    echo 'Entered email doesnot exist, try another working email';
       $_SESSION['reset_password'] = '<div class="alert alert-danger">try again, verify if email is written correctly <b>'.$user_email_recovery.'</b></div>';

       header('location:forgot-password');
			} else {
			    echo 'Message has been sent';
			     $_SESSION['reset_password'] = 'Reset link has been sent to '.$user_email_recovery;
			     header('location:forgot-password');
			}
   }
}

###############################  RESET USER PASSWORD LINK FROM EMAIL #######################
if (isset($_GET['user_em'])) {
    $user_email_recovery = $_GET['user_em'];
    echo $user_email_recovery;
    /*$sql1 = "UPDATE `login` SET pass_updated = '0' WHERE email = '$user_email_recovery'";
    $result1 = $conn->query($sql1);
    if ($result1) {*/

    $sql2 = "SELECT * FROM login INNER JOIN `phar_branch` ON login.branch=phar_branch.branch_ID
            WHERE md5(email) = '$user_email_recovery'";

    $result2 = $conn->query($sql2);

    if (!empty($result2)) {
    	# code...
    
     while($row = $result2->fetch_assoc()){
     	$_SESSION['reset_password'] = "";
        $_SESSION['user_id']    = $row['user_id'];
        $_SESSION['username']   = $row['username'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name']  = $row['last_name'];
        $_SESSION['phone']      = $row['phone'];
        $_SESSION['email']      = $row['email'];
        //$_SESSION['institution_code'] = $row['institution_code'];
        $_SESSION['branch']     = $row['branch'];
        $_SESSION['role_id']    = $row['role_id'];
        $_SESSION['branch_sta'] = $row['branch_status'];
        $_SESSION['reg_date']   = $row['reg_date'];
        $_SESSION['user_status']= $row['user_status'];
        $_SESSION['pass_updated']=$row['pass_updated'];
        $_SESSION['last_time']  = time();
       }
        
		header('location:passUpdate');		
   }
   
   else{
   	 echo 'Entered email doesnot exist, try another working email';
       $_SESSION['reset_password'] = '<div class="alert alert-danger">reset link has been expired,
       								  reset again</div>';

       header('location:forgot-password');
   }
   /*else{
       echo 'Entered email doesnot exist, try another working email';
       $_SESSION['reset_password'] = '<div class="alert alert-danger">reset link has been expired,
       								  reset again<b>'.$user_email_recovery.'</b></div>';

       header('location:passUpdate');
   }
    //header('location: '.$url);*/
}
########### IMPORT PURCHASE USING EXCEL FILE #####################
$_SESSION['imported_purchased'] = "";
if (isset($_POST["import_purchase"]))
{
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $med_name = "";
                if(isset($Row[0])) {
                    $med_name = mysqli_real_escape_string($conn,$Row[0]);
                }
                $purchase_price = "";
                if(isset($Row[1])) {
                    $purchase_price = mysqli_real_escape_string($conn,$Row[1]);
                }

                $selling_price = "";
                if(isset($Row[2])) {
                    $selling_price = mysqli_real_escape_string($conn,$Row[2]);
                }

                $category = "";
                if(isset($Row[3])) {
                    $category = mysqli_real_escape_string($conn,$Row[3]);
                }
                
                $batch_No = "";
                if(isset($Row[4])) {
                    $batch_No = mysqli_real_escape_string($conn,$Row[4]);
                }

                $product_quantity = "";
                if(isset($Row[5])) {
                    $product_quantity = mysqli_real_escape_string($conn,$Row[5]);
                }

                $expiration_date = "";
                if(isset($Row[6])) {
                    $expiration_date = mysqli_real_escape_string($conn,$Row[6]);
                }

                // $users_id = "";
                // if(isset($Row[6])) {
                //     $branch_ID = mysqli_real_escape_string($conn,$Row[6]);
                // }

                // $branch_ID = "";
                // if(isset($Row[7])) {
                //     $branch_ID = mysqli_real_escape_string($conn,$Row[7]);
                // }
                // $institution_code = "";
                // if(isset($Row[8])) {
                //     $branch_ID = mysqli_real_escape_string($conn,$Row[8]);
                // }
                // $expiration_date = "";
                // if(isset($Row[9])) {
                //     $branch_ID = mysqli_real_escape_string($conn,$Row[9]);
                // }
                // $date_puchased = "";
                // if(isset($Row[10])) {
                //     $branch_ID = mysqli_real_escape_string($conn,$Row[10]);
                // }
                
                if (!empty($med_name) && !empty($batch_No) && !empty($category) ) {
                    
                    $dat = date('y-m-d');
                    $query = "INSERT INTO purchase_medical_product(product_name,purchase_price,selling_price,product_category,batch_number,product_quantity,user_id,branch_ID,institution_code, expired_date,purchase_date,purchase_status) 
                    values('".$med_name."','".$purchase_price."','".$selling_price."','".$category."','".$batch_No."','".$product_quantity."','".$_SESSION['user_id']."','".$_SESSION['branch']."','".$_SESSION['institution_code']."','".$expiration_date."','".$dat."','1')";

                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $query_backup = " INSERT INTO purchase_medical_product_backup(product_name,purchase_price,selling_price,product_category,batch_number,product_quantity,user_id,branch_ID,institution_code,expired_date,purchase_date,purchase_status) 
                        values('".$med_name."','".$purchase_price."','".$selling_price."','".$category."','".$batch_No."','".$product_quantity."','".$_SESSION['user_id']."','".$_SESSION['branch']."','".$_SESSION['institution_code']."','".$expiration_date."','".$dat."','1')";

                        $result_backup = mysqli_query($conn, $query_backup);

                        if (! empty($result_backup)) {
                            $type = "success";
                            $_SESSION['imported_purchased'] = '<strong class="alert alert-success">Excel Data Imported into the Database</strong>'.'<script>
                                 setTimeout(function(){
                                    window.location.href = "medecine_purchase";
                                 }, 5000);
                              </script>';
                           
                            header('location: medecine_purchase');
                        }
                    } else {
                        $type = "error";
                        $_SESSION['imported_purchased'] ='                        
                                                <strong class="alert alert-success">
                                                Problem in Importing Excel Data</strong>
                                              '.$conn->error;;
                          header('location: medecine_purchase');                    
                    }
                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
################################# edit_purchase_medical_product ###########################
if(isset($_POST['edit_purchase_medical_product'])){
    $_SESSION['edited_medecine_purchased'] = "";
    
    $medical_name         = $_POST['product_name'];
    $purchase_price       = $_POST['purchase_price'];
    $purchase_id          = $_POST['purchase_id'];
    $selling_price        = $_POST['selling_price'];
    $medical_category     = $_POST['category'];
    $batch_number         = $_POST['batch_number'];
    $medical_quantity     = $_POST['quantity'];
    $medical_expired_date = $_POST['expiration_date'];
    $user_ids             = $_POST['user_id'];
    $branch_ID            = $_SESSION['branch'];
    $institution_code     = $_SESSION['institution_code'];
    $purchased_date       = date('Y-m-d');
    $purchase_status      = '1';
    $qty_expired          = '';

    $sql = "UPDATE purchase_medical_product SET product_name = '$medical_name',
    purchase_price = '$purchase_price', selling_price = '$selling_price',product_category='$medical_category',batch_number='$batch_number',product_quantity='$medical_quantity',
    user_id='$user_ids',expired_date = '$medical_expired_date' 
    WHERE md5(batch_number)='$_SESSION[batch]' AND branch_ID='$branch_ID '
     AND institution_code='$institution_code' AND md5(product_name)='$purchase_id'";
    $result = $conn->query($sql);
    if($result){
        $ppp = '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Updated</strong>
                </div>';

        $_SESSION['edited_medecine_purchased'] = $ppp;
        echo '
    <script>
     setTimeout(function(){
        window.location.href = "ksjhdjshdjh@@@IUIIUKKkdfr";
     }, 0);
    </script>';
       
    }else{
        echo $conn->error;
        exit();
        $ppp = '<div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Purchase not yet performed in the system</strong>';

        $_SESSION['edited_medecine_purchased'] = $ppp;
        echo '<script>
        setTimeout(function(){
            window.location.href = "ksjhdjshdjh@@@IUIIUKKkdfr";
        }, 0);
        </script>';

    }
    
}
###################export_category all medical category #################

if(isset($_POST["export_category"])) {   
if($_SESSION['role_id']==3){
    $sql_query = "SELECT medical_category.category_name as CATEGORY_NAME,
                medical_category.category_desc as CATEGORY_DESCRIPTION,
                login.first_name as DONE_BY,login.last_name as DONE,
                phar_branch.branch_name as BRANCH, 
                phar_institution.institution_name as INSTITUTION FROM medical_category
                INNER JOIN `login`  ON medical_category.user_id = login.user_id
                INNER JOIN `phar_branch` ON medical_category.branch_ID = phar_branch.branch_ID
                INNER JOIN `phar_institution` ON medical_category.institution_code = phar_institution.institution_code
                WHERE medical_category.institution_code = '$_SESSION[institution_code]' ORDER BY medical_category.category_ID ASC";
}else{
    $sql_query = "SELECT medical_category.category_name as CATEGORY_NAME,
                medical_category.category_desc as CATEGORY_DESCRIPTION,
                login.first_name as DONE_BY,login.last_name as DONE,
                phar_branch.branch_name as BRANCH, 
                phar_institution.institution_name as INSTITUTION FROM medical_category
                INNER JOIN `login`  ON medical_category.user_id = login.user_id
                INNER JOIN `phar_branch` ON medical_category.branch_ID = phar_branch.branch_ID
                INNER JOIN `phar_institution` ON medical_category.institution_code = phar_institution.institution_code
                WHERE medical_category.branch_ID = '$_SESSION[branch]' AND medical_category.institution_code = '$_SESSION[institution_code]' ORDER BY medical_category.category_ID ASC";
}
$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
$data_records = array();
while( $rows = mysqli_fetch_assoc($resultset) ) {
    $data_records[] = $rows;
}



    $filename = "All_Medical_Category_".date('Ymd') . ".xls";          
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");  
    $is_coloumn = false;
    if(!empty($data_records)) {
      foreach($data_records as $value) {
        if(!$is_coloumn) {       
          echo implode("\t", array_keys($value)) . "\n";
          $is_coloumn = true;
        }
        echo implode("\t", array_values($value)) . "\n";
      }
    }
    exit;  
}
/*==========================================================================
                to recover the  loan transaction in the system
============================================================================*/
if (isset($_POST['send_recover_trans'])) {
    $status = 0;
    $transaction   = $_POST['transaction_ID'];
    $paid_amount   = $_POST['paid_amount'];
    $loan_amount   = $_POST['loan_recover_amount'];
    $loan_date     = date('y-m-d');
    //$col = $_REQUEST['user_status'];
    $recover = "SELECT * FROM medical_loan_recovery WHERE transaction_ID = '$transaction' AND branch_ID = '$_SESSION[branch]' AND institution_code = '$_SESSION[institution_code]'";
    $cover_loan = $conn->query($recover);
    echo $conn->error;
    $cover_row = $cover_loan->fetch_assoc();
    $amount = $cover_row['loan_amount'];
    $updated_amount = $amount + $loan_amount; 
    if ($count = $cover_loan->num_rows > 0) {
        $update_loan = "UPDATE medical_loan_recovery SET loan_amount = '$updated_amount' 
                        WHERE transaction_ID = '$transaction'AND branch_ID = '$_SESSION[branch]'AND institution_code = '$_SESSION[institution_code]'";
        $update_result = $conn->query($update_loan);
        if ($update_result) {
            $url = "loan_trans?msg=&done";
        }else{
            $url = "loan_trans?msg=&Error".$conn->error;
            echo $conn->error;
        }
    }else{
        $sql = "INSERT INTO medical_loan_recovery VALUES(null, '$transaction', '$loan_amount', '$_SESSION[branch]', '$_SESSION[institution_code]', '$_SESSION[user_id]', '$loan_date', '$status')";
        $result = $conn->query($sql);
        if ($result) {
            $url = "loan_trans?msg=&done";
        }
        else{
            $url = "loan_trans?msg=&Error".$conn->error;
            echo $conn->error;
        }
    }
    header('location: '.$url);
} 
################## REFOUND THE SERVED MEDECINE ##########################
if (isset($_GET['loan_recovered'])) {
    $_SESSION['loan_recovered'] = "";
    $status = 1;
    $transaction_id = $_GET['loan_recovered'];
    $loan_recover = " UPDATE `medical_loan_recovery` SET loan_status='$status'
    WHERE transaction_ID = '$transaction_id'";

    $recover_sql = $conn->query($loan_recover);
    if($recover_sql){
        $update_sales = " UPDATE `total_sales` SET payment_mode='Paid'
                            WHERE transaction_ID = '$transaction_id'";
        $update_sales_sql = $conn->query($update_sales);
        if($update_sales_sql){
        header('Location: loan_trans');
        }else{  
            header('Location: loan_trans');
        } 
    }else{     
    header('Location: loan_trans');
    } 
}
?>