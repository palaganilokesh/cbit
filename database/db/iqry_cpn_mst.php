<?php
include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once "../includes/inc_adm_session.php"; //checking for session
include_once "../includes/inc_connection.php";
if(isset($_POST['btncpnsbmt']) && (trim($_POST['btncpnsbmt']) != "") && isset($_POST['txtcpncde']) && (trim($_POST['txtcpncde']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$txtcde = glb_func_chkvl($_POST['txtcpncde']);
	$txtname = glb_func_chkvl($_POST['txtname']);
	$lstappon = glb_func_chkvl($_POST['lstcpnapp']);
	$lstmncat = glb_func_chkvl($_POST['lstprodmcat']);
	$lstcat = glb_func_chkvl($_POST['lstprodcat']);
	$lstscat = glb_func_chkvl($_POST['lstprodscat']);
	$lstbrnd = glb_func_chkvl($_POST['lstprodbrnd']);
	$lstapptyp = glb_func_chkvl($_POST['lstcpnapptyp']);
	$lstntamt = glb_func_chkvl($_POST['lstntamt']);
	$txtntamt = glb_func_chkvl($_POST['txtnetamt']);
	$lstusrtyp = glb_func_chkvl($_POST['lstusrtyp']);
	$lstusr = glb_func_chkvl($_POST['lstusr']);
	$lstuse = glb_func_chkvl($_POST['lstuse']);
	$txtusglmt = glb_func_chkvl($_POST['txtusglmt']);
	$lstdisctyp = glb_func_chkvl($_POST['lstdisctyp']);
	$txtdiscperc = glb_func_chkvl($_POST['txtdiscperc']);
	$txtdiscamt = glb_func_chkvl($_POST['txtdiscamt']);
	$expdt = glb_func_chkvl($_POST['expdt']);
	$txtdesc = glb_func_chkvl($_POST['txtdesc']);
	$prty = glb_func_chkvl($_POST['txtprior']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$dt = date('Y-m-d');
	$sqrycpn_mst = "SELECT cpnm_cde from cpn_mst where cpnm_cde = '$txtcde'";
	$srscpn_mst = mysqli_query($conn,$sqrycpn_mst);
	$rows = mysqli_num_rows($srscpn_mst);	
	if($rows < 1)
	{
		$iqrycpn_mst = "INSERT into cpn_mst(cpnm_cde, cpnm_name, cpnm_applon,cpnm_mncat, cpnm_cat, cpnm_scat, cpnm_brnd, cpnm_aptyp, cpnm_ntamttyp, cpnm_ntamt, cpnm_memtyp,cpnm_mbrm_id, cpnm_usetyp, cpnm_uselmt, cpnm_disctyp, cpnm_discamt, cpnm_discper, cpnm_exdt, cpnm_desc, cpnm_sts, cpnm_prty, cpnm_crtdon, cpnm_crtdby) values('$txtcde','$txtname', '$lstappon','$lstmncat', '$lstcat','$lstscat', '$lstbrnd','$lstapptyp','$lstntamt','$txtntamt','$lstusrtyp', '$lstusr','$lstuse', '$txtusglmt','$lstdisctyp','$txtdiscamt', '$txtdiscperc', '$expdt', '$txtdesc', '$sts', '$prty', '$dt','$ses_admin')";
		//echo $iqrycpn_mst;exit;
		$irscpn_mst=mysqli_query($conn,$iqrycpn_mst);
		if($irscpn_mst==true)
		{
			$gmsg = "Record saved successfully";
		}
		else
		{
			$gmsg = "Record not saved";
		}
	}
	else
	{
		$gmsg = "Duplicate Code, Record not saved";
	}
}
?>