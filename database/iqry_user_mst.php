<?php
	include_once "../includes/inc_connection.php"; //conneciton
	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session

	if(isset($_POST['btnadduser']) && (trim($_POST['btnadduser']) != "") &&
	   isset($_POST['txtname']) && (trim($_POST['txtname']) != "")){

		$name     = glb_func_chkvl($_POST['txtname']);
		$type     = glb_func_chkvl($_POST['addtype']);
		$dept      = glb_func_chkvl($_POST['lstprodcat']);
		$pwd    =md5("Cbit@123");
		$sts      = glb_func_chkvl($_POST['lststs']);
	$dt       = date('Y-m-d');

		$sqrylgn_mst="SELECT lgnm_dept_id from	lgn_mst where	lgnm_dept_id='$dept '";
		$srslgn_mst = mysqli_query($conn,$sqrylgn_mst);
		$rows       = mysqli_num_rows($srslgn_mst);
		// if($rows > 0){
		// 	$gmsg = "Duplicate name. Record not saved";
		// }

		if($rows < 1)
    {

	$iqrylgn_mst="INSERT into lgn_mst(lgnm_typ,lgnm_dept_id,lgnm_uid,lgnm_pwd,lgnm_sts,lgnm_crtdon,
lgnm_crtdby)values('$type','$dept','$name','$pwd','$sts','$dt','$ses_admin')";
$irslgn_mst = mysqli_query($conn,$iqrylgn_mst);
			if($irslgn_mst==true){

			$gmsg = "Record saved successfully";

			}
			else{
				$gmsg = "Record not saved";
			}
		}
		else
	{
		$gmsg = "Duplicate name. Record not saved";
	}
	}

?>