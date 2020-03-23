<?php
session_start();
include 'includes/config.php';

if($_SESSION['role_id'] == 3){
	$sql_query = "SELECT medical_product.product_ID as N_O, medical_product.product_Nmae as Medical_Name,
	medical_category.category_name as Medical_Category, phar_branch.branch_name as Branch_Name,
	phar_institution.institution_name as Institution, medical_product.register_date as Registered_Date
	FROM medical_product 
	INNER JOIN medical_category ON medical_product.category = medical_category.category_ID
	INNER JOIN phar_branch ON medical_product.branch_ID = phar_branch.branch_ID
	INNER JOIN phar_institution ON medical_product.institution_code = phar_institution.institution_code
	WHERE  medical_product.institution_code = '$_SESSION[institution_code]'
	ORDER BY product_ID ASC";
}else{
	$sql_query = "SELECT medical_product.product_ID as N_O, medical_product.product_Nmae as Medical_Name,
	medical_category.category_name as Medical_Category, phar_branch.branch_name as Branch_Name,
	phar_institution.institution_name as Institution, medical_product.register_date as Registered_Date
	FROM medical_product 
	INNER JOIN medical_category ON medical_product.category = medical_category.category_ID
	INNER JOIN phar_branch ON medical_product.branch_ID = phar_branch.branch_ID
	INNER JOIN phar_institution ON medical_product.institution_code = phar_institution.institution_code
	WHERE medical_product.branch_ID = '$_SESSION[branch]' AND medical_product.institution_code = '$_SESSION[institution_code]'
	ORDER BY product_ID ASC";
}
$resultset = mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
$data_records = array();
while( $rows = mysqli_fetch_assoc($resultset) ) {
	$data_records[] = $rows;
}


//if(isset($_POST["export"])) {	
	$filename = "Medicine_list_".date('Ymd') . ".xls";			
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
//}



?>

