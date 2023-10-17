<?php
include_once "../includes/inc_adm_session.php"; //checking for session
include_once "../includes/inc_connection.php"; //Making database Connection
include_once "../includes/inc_usr_functions.php"; //Use function for validation and more

/***************************************************************
Programm 	  : chkduplicate.php
Purpose 	  : For Checking Duplicate
Created By    : Mallikarjuna
Created On    :	20/03/2012
Modified By   :
Modified On   :
Purpose 	  :
Company 	  : Adroit
 ************************************************************/
/************************************************************/
// ----------------------- to check duplicate main link name -----------------
if (isset($_REQUEST['prodmnlnksname']) && (trim($_REQUEST['prodmnlnksname']) != "")) {
	$name = glb_func_chkvl($_REQUEST['prodmnlnksname']);
	$sqryprodmncat_mst = "SELECT prodmnlnksm_name from prodmnlnks_mst where prodmnlnksm_name='$name'";
	if (isset($_REQUEST['prodmncatid']) && ($_REQUEST['prodmncatid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['prodmncatid']);
		$sqryprodmncat_mst .= " and prodmnlnksm_id != $id";
	}
	// echo $sqryprodmncat_mst; exit;
	$srsprodmncat_mst = mysqli_query($conn, $sqryprodmncat_mst);
	$cnt = mysqli_num_rows($srsprodmncat_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Name</strong></font>";
	}
}
// -----------------------END to check duplicate main link name -----------------
// ----------------------- to check duplicate Category name -----------------
if (isset($_REQUEST['prodcatname']) && (trim($_REQUEST['prodcatname']) != "") && isset($_REQUEST['prodmcatid']) && (trim($_REQUEST['prodmcatid']) != "")) {
	$name = glb_func_chkvl($_REQUEST['prodcatname']);
	$prodmcat = glb_func_chkvl($_REQUEST['prodmcatid']);

	$sqryprodcat_mst = "SELECT prodcatm_name from prodcat_mst where prodcatm_prodmnlnksm_id='$prodmcat' and prodcatm_name = '$name'";
	if (isset($_REQUEST['prodcatid']) && ($_REQUEST['prodcatid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['prodcatid']);
		$sqryprodcat_mst .= " and prodcatm_id != $id";
	}
	$srsprodcat_mst = mysqli_query($conn, $sqryprodcat_mst);
	$cnt = mysqli_num_rows($srsprodcat_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Combination Of Main Link & Category Name</strong></font>";
	}
}
// -----------------------END to check duplicate Category name -----------------
// ----------------------- to check duplicate Sub Category name -----------------
if (isset($_REQUEST['prodscatname']) && (trim($_REQUEST['prodscatname']) != "") && isset($_REQUEST['prodmncatid']) && (trim($_REQUEST['prodmncatid']) != "") && isset($_REQUEST['prodcatid']) && (trim($_REQUEST['prodcatid']) != "")) {
	$name = glb_func_chkvl($_REQUEST['prodscatname']);
	$prodmncat = glb_func_chkvl($_REQUEST['prodmncatid']);
	$prodcat = glb_func_chkvl($_REQUEST['prodcatid']);
	$sqryprodscat_mst	= "select prodscatm_name from prodscat_mst where prodscatm_prodcatm_id='$prodcat' and prodscatm_prodmnlnksm_id='$prodmncat' and prodscatm_name='$name'";
	if (isset($_REQUEST['subcatid']) && ($_REQUEST['subcatid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['subcatid']);
		$sqryprodscat_mst .= " and prodscatm_id!=$id";
	}
	$srsprodscat_mst = mysqli_query($conn, $sqryprodscat_mst);
	$cnt = mysqli_num_rows($srsprodscat_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Combination Of Main Category, Category & Name</strong></font>";
	}
}
// ----------------------- to check duplicate Sub Category name -----------------

if (isset($_REQUEST['bnrname']) && (trim($_REQUEST['bnrname']) != "")) {
	// checking Duplicate name for Categoryone
	$result = "";
	$bnrname = glb_func_chkvl($_REQUEST['bnrname']);
	$sqrybnr_mst = "select
								bnrm_name
							from
								bnr_mst
						   	where
						   		bnrm_name = '" . $bnrname . "'";
	if (isset($_REQUEST['bnrid']) && (trim($_REQUEST['bnrid']) != "")) {
		$bnrid = glb_func_chkvl($_REQUEST['bnrid']);
		$sqrybnr_mst .= " and bnrm_id != $bnrid";
	}
	$srsbnr_mst  = mysqli_query($conn, $sqrybnr_mst);
	$reccnt_bnr  = mysqli_num_rows($srsbnr_mst);
	if ($reccnt_bnr > 0) {
		$result = "<font color ='red'><b>Duplicate Name</b></font>";
	}
	echo $result;
}
if (
	isset($_REQUEST['evntname']) && (trim($_REQUEST['evntname']) != "") &&
	isset($_REQUEST['evntstrtdt']) && (trim($_REQUEST['evntstrtdt']) != "")
) {
	$result = "";
	$name = glb_func_chkvl($_REQUEST['evntname']);
	$strtdt = glb_func_chkvl($_REQUEST['evntstrtdt']);
	$sqryevnt_mst = "select evntm_name from evnt_mst
						 where evntm_name = '". $name ."' and
						 evntm_strtdt = '$strtdt'";

	if (isset($_REQUEST['evntid']) && (trim($_REQUEST['evntid']) != "")) {
		$evntid = glb_func_chkvl($_REQUEST['evntid']);
	$sqryevnt_mst .= " and evntm_id != $evntid";
	}
	$srsevnt_mst  = mysqli_query($conn, $sqryevnt_mst);
	$reccnt		   = mysqli_num_rows($srsevnt_mst);
	if ($reccnt > 0) {
		$result = "<font color ='red'><b>Duplicate Name And Date</b></font>";
	}

	echo $result;
}
if (isset($_REQUEST['newsname']) && (trim($_REQUEST['newsname']) != "")) {
	$result = "";
	$newsname = glb_func_chkvl($_REQUEST['newsname']);
	$sqrynew_mst = "select
								nwsm_name
						   from
								nws_mst
						   where
								nwsm_name = '" . $newsname . "'";
	if (isset($_REQUEST['newsid']) && (trim($_REQUEST['newsid']) != "")) {
		$newsid = glb_func_chkvl($_REQUEST['newsid']);
		$sqrynew_mst .= " and nwsm_id != $newsid";
	}
	$srsnew_mst  = mysqli_query($conn, $sqrynew_mst);
	$reccnt		   = mysqli_num_rows($srsnew_mst);
	if ($reccnt > 0) {
		$result = "<font color ='red'><b>Duplicate name</b></font>";
	}
	echo $result;
}


if (isset($_REQUEST['exmname']) && (trim($_REQUEST['exmname']) != "")) {
	$result = "";
	$exmsname = glb_func_chkvl($_REQUEST['exmname']);
	$sqryexm_mst = "select
								exmsm_name
						   from
								exms_mst
						   where
								exmsm_name = '" . $exmsname . "'";
	if (isset($_REQUEST['exmid']) && (trim($_REQUEST['exmid']) != "")) {
		$exmid = glb_func_chkvl($_REQUEST['exmid']);
		$sqryexm_mst .= " and nwsm_id != $exmid";
	}
	$srsexm_mst  = mysqli_query($conn, $sqryexm_mst);
	$reccnt		   = mysqli_num_rows($srsexm_mst);
	if ($reccnt > 0) {
		$result = "<font color ='red'><b>Duplicate name</b></font>";
	}
	echo $result;
}

if (isset($_REQUEST['brndname']) && (trim($_REQUEST['brndname']) != ""))	// checking Duplicate name for Brand name
{
	$result 	  = "";
	$name 		  = glb_func_chkvl($_REQUEST['brndname']);
	$sqrybrnd_mst = "select
							 brndm_name
						 from
						 	brnd_mst
						 where
						 	brndm_name = '" . $name . "'";
	if (isset($_REQUEST['brndid']) && (trim($_REQUEST['brndid']) != "")) {
		$brndid = $_REQUEST['brndid'];
		$sqrybrnd_mst .= " and brndm_id != $brndid";
	}
	$srsbrnd_mst  = mysqli_query($conn, $sqrybrnd_mst);
	$reccnt		   = mysqli_num_rows($srsbrnd_mst);

	if ($reccnt > 0) {
		$result = "<font color ='red'><b>Duplicate name</b></font>";
	}
	echo $result;
}

if (isset($_REQUEST['stdtestmnl']) && (trim($_REQUEST['stdtestmnl']) != ""))	// checking Duplicate name for Student Testimonial Name

{
	$result 	  = "";
	$name 		  = glb_func_chkvl($_REQUEST['stdtestmnl']);
	$sqrybrnd_mst = "select
	std_testmnlm_name
						 from
						 std_testmnl_mst
						 where
						 std_testmnlm_name = '" . $name . "'";
	if (isset($_REQUEST['stdtest']) && (trim($_REQUEST['stdtest']) != "")) {
		$stdtest = $_REQUEST['stdtest'];
		$sqrybrnd_mst .= " and std_testmnlm_id != $stdtest";
	}
	$srsbrnd_mst  = mysqli_query($conn, $sqrybrnd_mst);
	$reccnt		   = mysqli_num_rows($srsbrnd_mst);

	if ($reccnt > 0) {
		$result = "<font color ='red'><b>Duplicate name</b></font>";
	}
	echo $result;
}

if (isset($_REQUEST['product']) && (trim($_REQUEST['product']) != ""))	// checking Duplicate name for Downloads Category Name

{
	$result 	  = "";
	$name 		  = glb_func_chkvl($_REQUEST['product']);
	$sqrybrnd_mst = "select
	prodm_name
						 from
						 prod_mst
						 where
						 prodm_name = '" . $name . "'";
	if (isset($_REQUEST['prod']) && (trim($_REQUEST['prod']) != "")) {
		$prod = $_REQUEST['prod'];
		$sqrybrnd_mst .= " and prodm_id != $prod";
	}
	$srsbrnd_mst  = mysqli_query($conn, $sqrybrnd_mst);
	$reccnt		   = mysqli_num_rows($srsbrnd_mst);

	if ($reccnt > 0) {
		$result = "<font color ='red'><b>Duplicate name</b></font>";
	}
	echo $result;
}

if (isset($_REQUEST['abtus']) && (trim($_REQUEST['abtus']) != ""))	// checking Duplicate name for About Us Name

{
	$result 	  = "";
	$name 		  = glb_func_chkvl($_REQUEST['abtus']);
	$sqrybrnd_mst = "select
	abtusm_name
						 from
						 abtus_mst
						 where
						 abtusm_name = '" . $name . "'";
	if (isset($_REQUEST['abt']) && (trim($_REQUEST['abt']) != "")) {
		$abt = $_REQUEST['abt'];
		$sqrybrnd_mst .= " and abtusm_id != $abt";
	}
	$srsbrnd_mst  = mysqli_query($conn, $sqrybrnd_mst);
	$reccnt		   = mysqli_num_rows($srsbrnd_mst);

	if ($reccnt > 0) {
		$result = "<font color ='red'><b>Duplicate name</b></font>";
	}
	echo $result;
}


// if (isset($_REQUEST['prodname']) && (trim($_REQUEST['prodname']) != ""))	// checking Duplicate name for Downloads Category Name

// {
// 	$result 	  = "";
// 	$name 		  = glb_func_chkvl($_REQUEST['prodname']);
// 	$sqrybrnd_mst = "select
// 	prodm_name
// 						 from
// 						 prod_mst
// 						 where
// 						 prodm_name = '" . $name . "'";
// 	if (isset($_REQUEST['prod']) && (trim($_REQUEST['prod']) != "")) {
// 		$prod = $_REQUEST['prod'];
// 		$sqrybrnd_mst .= " and prodm_id != $prod";
// 	}
// 	$srsbrnd_mst  = mysqli_query($conn, $sqrybrnd_mst);
// 	$reccnt		   = mysqli_num_rows($srsbrnd_mst);

// 	if ($reccnt > 0) {
// 		$result = "<font color ='red'><b>Duplicate name</b></font>";
// 	}
// 	echo $result;
// }


if (isset($_REQUEST['prodname']) && (trim($_REQUEST['prodname']) != "") && isset($_REQUEST['prodm_id']) && (trim($_REQUEST['prodm_id']) != "")) { // Download Category And Download Name
	$name = glb_func_chkvl($_REQUEST['prodname']);
	$prodmcat = glb_func_chkvl($_REQUEST['prodm_id']);

	$sqrydownload_mst = "select dwnld_name from dwnld_dtl where dwnld_prodm_id='$prodmcat' and dwnld_name = '$name'";
	if (isset($_REQUEST['prodid']) && ($_REQUEST['prodid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['prodid']);
		$sqrydownload_mst .= " and dwnld_id != $id";
	}
	$srsprodcat_mst = mysqli_query($conn, $sqrydownload_mst);
	$cnt = mysqli_num_rows($srsprodcat_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Combination Of Downloads Category & Downloads Name</strong></font>";
	}
}


if (isset($_REQUEST['prodcatname']) && (trim($_REQUEST['prodcatname']) != "")) {
	$name	= glb_func_chkvl($_REQUEST['prodcatname']);

	$sqryprodcat_mst	= "select
									prodcatm_name
							   from
									prodcat_mst
							   where
									prodcatm_name='$name'";
	exit;
	if (isset($_REQUEST['prodid']) && ($_REQUEST['prodid'] != "")) {

		$id = glb_func_chkvl($_REQUEST['prodid']);
		$sqryprodcat_mst .= " and prodcatm_id!=$id";
	}

	$srsprodcat_mst = mysqli_query($conn, $sqryprodcat_mst);
	$cnt           = mysqli_num_rows($srsprodcat_mst);
	if ($cnt > 0) {

		echo "<font color=red><strong>Duplicate Name</strong></font>";
	}
}

if (
	isset($_REQUEST['prodname']) && (trim($_REQUEST['prodname']) != "") &&
	isset($_REQUEST['prodcatid']) && (trim($_REQUEST['prodcatid']) != "")
) {
	$name	     	= glb_func_chkvl($_REQUEST['prodname']);
	$prodcat	   	= glb_func_chkvl($_REQUEST['prodcatid']);

	$sqryprodcat_mst	= "select
									prodm_name
							   from
									prod_mst
							   where
									prodm_prodcatm_id='$prodcat' and
									prodm_name='$name'";
	if (isset($_REQUEST['prodid']) && ($_REQUEST['prodid'] != "")) {

		$id = glb_func_chkvl($_REQUEST['prodid']);
		$sqryprodcat_mst .= " and prodm_id!=$id";
	}

	$srsprodcat_mst = mysqli_query($conn, $sqryprodcat_mst);
	$cnt           = mysqli_num_rows($srsprodcat_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Combination Of Category&Name</strong></font>";
	}
}
if (
	isset($_REQUEST['pagcntnname']) && (trim($_REQUEST['pagcntnname']) != "") &&
	isset($_REQUEST['catname']) && (trim($_REQUEST['catname']) != "")
) {
	// checking Duplicate name for page contain
	$result = "";
	$pagcntnname = glb_func_chkvl($_REQUEST['pagcntnname']);
	$arycatid 		 = glb_func_chkvl($_REQUEST['catname']);
	$mnlnks 		 = glb_func_chkvl($_REQUEST['lstprodmcat']);
	$catid = explode('-', $arycatid);
	$sqrypgcnts_dtl = "SELECT pgcntsd_name from
							  	vw_pgcnts_prodcat_prodscat_mst
						  	 where
							 	pgcntsd_name = '" . $pagcntnname . "' and
								pgcntsd_prodmnlnks_id='".$mnlnks ."' and
								prodcatm_id = '" . $catid[0] . "'";

	if (isset($_REQUEST['deptid']) && (trim($_REQUEST['deptid']) != '')) {
		$dept     = glb_func_chkvl($_REQUEST['deptid']);
		$sqrypgcnts_dtl  .= " and pgcntsd_deptm_id=$dept";
	} else {
		$dept = 'NULL';
		$sqrypgcnts_dtl  .= " and pgcntsd_deptm_id IS NULL";
	}

	if (isset($_REQUEST['scatname']) && (trim($_REQUEST['scatname']) != '')) {
		$cattwo   = glb_func_chkvl($_REQUEST['scatname']);
		$sqrypgcnts_dtl  .= " and pgcntsd_prodscatm_id=$cattwo";
	} else {
		$cattwo = 'NULL';
		$sqrypgcnts_dtl  .= " and pgcntsd_prodscatm_id IS NULL";
	}
	if (isset($_REQUEST['pgcntid']) && (trim($_REQUEST['pgcntid']) != "")) {
		$pgcntsid = glb_func_chkvl($_REQUEST['pgcntid']);
		$sqrypgcnts_dtl .= " and pgcntsd_id != $pgcntsid";
	}

	$srspgcnts_dtl  = mysqli_query($conn, $sqrypgcnts_dtl);
	$reccnt_pgcnts  = mysqli_num_rows($srspgcnts_dtl);
	if ($reccnt_pgcnts > 0) {
		$result = "<font color ='red'><b>Duplicate Name</b></font>";
	}
	echo $result;
}




if (
	isset($_REQUEST['acadname']) && (trim($_REQUEST['acadname']) != "") &&
	isset($_REQUEST['dept']) && (trim($_REQUEST['dept']) != "")
) {
	// checking Duplicate name for page contain
	$result = "";
	$acadname = glb_func_chkvl($_REQUEST['acadname']);
	$arycatid 		 = glb_func_chkvl($_REQUEST['dept']);
	$catid = explode('-', $arycatid);
	$sqrypgcnts_dtl = "select
								acadm_name,acadm_deptm_id,acadm_depsemm_id,acadm_id
							  from
							  	acad_mst
						  	 where
							 	acadm_name = '" . $acadname . "' and
								acadm_deptm_id = '" . $catid[0] . "'";



	if (isset($_REQUEST['sem']) && (trim($_REQUEST['sem']) != '')) {
		$sem   = glb_func_chkvl($_REQUEST['sem']);


		$sqrypgcnts_dtl  .= " and acadm_depsemm_id = $sem";
	} else {
		$sem = 'NULL';
		$sqrypgcnts_dtl  .= " and acadm_depsemm_id IS NULL";
	}
	if (isset($_REQUEST['acadid']) && (trim($_REQUEST['acadid']) != "")) {
		$acadid = glb_func_chkvl($_REQUEST['acadid']);
		$sqrypgcnts_dtl .= " and acadm_id = $acadid";
	}
	//	echo $sqrypgcnts_dtl;//exit;
	$srspgcnts_dtl  = mysqli_query($conn, $sqrypgcnts_dtl);

	$reccnt_pgcnts  = mysqli_num_rows($srspgcnts_dtl);
	if ($reccnt_pgcnts == 1) {

		$result = "<font color ='red'><b>Duplicate Name</b></font>";
	}
	echo $result;
}







if (isset($_REQUEST['userid']) && (trim($_REQUEST['userid']) != "")) {
	$result = "";
	$usrid = strip_tags(substr(trim($_REQUEST['userid']), 0, 249));
	$sqrylgn_mst  = "select lgnm_uid  from lgn_mst
						 where lgnm_uid = '" . $usrid . "'";
	if (isset($_REQUEST['usertype']) && (trim($_REQUEST['usertype']) != "")) {
		$usertype = $_REQUEST['usertype'];
		$sqrylgn_mst .= " and lgnm_typ= '" . $usertype . "'";
	}
	if (isset($_REQUEST['userdept']) && (trim($_REQUEST['userdept']) != "")) {
		$userdept = $_REQUEST['userdept'];
		$sqrylgn_mst .= " and lgnm_dept_id= $userdept";
	}
	// echo $sqrylgn_mst;
	$srslgn_mst  = mysqli_query($conn, $sqrylgn_mst);
	$reccnt		 = mysqli_num_rows($srslgn_mst);
	if ($reccnt > 0) {
		$result = "<font color ='red'><b>Duplicate name</b></font>";
	}
	echo $result;
}

if (isset($_REQUEST['usrdepartment']) && (trim($_REQUEST['usrdepartment']) != "")) {
	$result = "";
	$usrdepartment = strip_tags(substr(trim($_REQUEST['usrdepartment']), 0, 249));
	$sqrylgn_mst  = "select lgnm_uid,lgnm_dept_id  from lgn_mst
						 where lgnm_dept_id = '" . $usrdepartment . "'";

	// echo $sqrylgn_mst;
	$srslgn_mst  = mysqli_query($conn, $sqrylgn_mst);
	$reccnt		 = mysqli_num_rows($srslgn_mst);
	if ($reccnt > 0) {
		$result = "<font color ='red'><b>Alredy This Department User Added.</b></font>";
	}
	echo $result;
}

if (isset($_REQUEST['deptname']) && (trim($_REQUEST['deptname']) != "")) {
	$name	      = glb_func_chkvl($_REQUEST['deptname']);
	$sqrydept_mst = "select
							deptm_name
						 from
							dept_mst
						 where
							deptm_name='$name'";
	if (isset($_REQUEST['deptid']) && ($_REQUEST['deptid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['deptid']);
		$sqrydept_mst .= " and deptm_id!=$id";
	}
	$srsdept_mst = mysqli_query($conn, $sqrydept_mst);
	$cnt         = mysqli_num_rows($srsdept_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Name</strong></font>";
	}
}


if (isset($_REQUEST['depsemname']) && (trim($_REQUEST['depsemname']) != "")) {
	$name	      = glb_func_chkvl($_REQUEST['depsemname']);
	$sqrydept_mst = "select
							depsemm_name
						 from
							depsem_mst

						 where
							depsemm_name='$name'";
	if (isset($_REQUEST['depsemid']) && ($_REQUEST['depsemid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['depsemid']);
		$sqrydept_mst .= " and depsemm_id!=$id";
	}
	$srsdept_mst = mysqli_query($conn, $sqrydept_mst);
	$cnt         = mysqli_num_rows($srsdept_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Name</strong></font>";
	}
}




if (isset($_REQUEST['facname']) && (trim($_REQUEST['facname']) != "")) {
	$name	      = glb_func_chkvl($_REQUEST['facname']);
	$sqrydept_mst = "select
							 	factym_name
						 from
							facty_mst

						 where
							factym_name='$name'";
	if (isset($_REQUEST['facid']) && ($_REQUEST['facid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['facid']);
		$sqrydept_mst .= " and factym_id!=$id";
	}
	$srsdept_mst = mysqli_query($conn, $sqrydept_mst);
	$cnt         = mysqli_num_rows($srsdept_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Name</strong></font>";
	}
}


if (isset($_REQUEST['depsemcode']) && (trim($_REQUEST['depsemcode']) != "")) {
	$code	      = glb_func_chkvl($_REQUEST['depsemcode']);
	$sqrydept_mst = "select
							depsemm_code
						 from
							depsem_mst

						 where
							depsemm_code='$code'";
	if (isset($_REQUEST['depsemid']) && ($_REQUEST['depsemid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['depsemid']);
		$sqrydept_mst .= " and depsemm_id!=$id";
	}
	$srsdept_mst = mysqli_query($conn, $sqrydept_mst);
	$cnt         = mysqli_num_rows($srsdept_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Code</strong></font>";
	}
}

if (isset($_REQUEST['acadcode']) && (trim($_REQUEST['acadcode']) != "")) {
	$code	      = glb_func_chkvl($_REQUEST['acadcode']);
	$sqrydept_mst = "select
							acadm_code
						 from
							acad_mst

						 where
							acadm_code='$code'";
	if (isset($_REQUEST['acadid']) && ($_REQUEST['acadid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['acadid']);
		$sqrydept_mst .= " and acadm_id!=$id";
	}
	$srsdept_mst = mysqli_query($conn, $sqrydept_mst);
	$cnt         = mysqli_num_rows($srsdept_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Code</strong></font>";
	}
}


if (isset($_REQUEST['mdlname']) && (trim($_REQUEST['mdlname']) != "")) {
	$name	      = glb_func_chkvl($_REQUEST['mdlname']);
	$sqrymdl_mst = "select
							mdlm_name
						 from
							mdl_mst
						 where
							mdlm_name='$name'";
	if (isset($_REQUEST['mdlid']) && ($_REQUEST['mdlid'] != "")) {
		$id = glb_func_chkvl($_REQUEST['mdlid']);
		$sqrymdl_mst .= " and mdlm_id!=$id";
	}
	$srsmdl_mst = mysqli_query($conn, $sqrymdl_mst);
	$cnt        = mysqli_num_rows($srsmdl_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Name</strong></font>";
	}
}
// ----------------------- to check duplicate placement year name -----------------
if (isset($_REQUEST['plcmtname']) && (trim($_REQUEST['plcmtname']) != "")) {
	$name = glb_func_chkvl($_REQUEST['plcmtname']);
	$sqryplcmt_mst = "SELECT plcmtm_name from plcmt_mst where plcmtm_name='$name'";
	if (isset($_REQUEST['plcmtm_id']) && ($_REQUEST['plcmtm_id'] != "")) {
		$id = glb_func_chkvl($_REQUEST['plcmtm_id']);
		$sqryplcmt_mst .= " and plcmtm_id != $id";
	}
	// echo $sqryprodmncat_mst; exit;
	$srsplcmt_mst = mysqli_query($conn, $sqryplcmt_mst);
	$cnt = mysqli_num_rows($srsplcmt_mst);
	if ($cnt > 0) {
		echo "<font color=red><strong>Duplicate Name</strong></font>";
	}
}
// -----------------------END to check duplicate placement name -----------------

// -----------------------START to check duplicate Achievements name -----------------
if (isset($_REQUEST['achmntname']) && (trim($_REQUEST['achmntname']) != "")) {

	$result = "";
	$achmntname = glb_func_chkvl($_REQUEST['achmntname']);
	$sqryach_mst = "SELECT
								achmntm_name
							from
							achmnt_mst
						   	where
							   achmntm_name = '" . $achmntname . "'";
	if (isset($_REQUEST['achmntid']) && (trim($_REQUEST['achmntid']) != "")) {
		$achmntid = glb_func_chkvl($_REQUEST['achmntid']);
		$sqryach_mst .= " and achmntm_id != $achmntid";
	}
	$srsach_mst  = mysqli_query($conn, $sqryach_mst);
	$reccnt_ach  = mysqli_num_rows($srsach_mst);
	if ($reccnt_ach > 0) {
		$result = "<font color ='red'><b>Duplicate Name</b></font>";
	}
	echo $result;
}
// -----------------------END to check duplicate Achievements name -----------------
if(isset($_REQUEST['deptid1']) && (trim($_REQUEST['deptid1']) != ""))
	{
		$result = "";
		$deptid1 = glb_func_chkvl($_REQUEST['deptid1']);
		 $sqrydept_dtl = "SELECT
								faculty_dept_id
							  from
							  	faculty_mst
						  	 where
							   faculty_dept_id = '".$deptid1."'" ;
		$srsdept_dtl  = mysqli_query($conn,$sqrydept_dtl);

		$reccnt_dept  = mysqli_num_rows($srsdept_dtl);
		if($reccnt_dept == 1){

			$result = "<font color ='red'><b>Duplicate Department</b></font>";
		}
		echo $result;
	}
// -----------------------START to check duplicate Events and News name -----------------
if(isset($_REQUEST['evntname']) && (trim($_REQUEST['evntname']) != "") &&
		isset($_REQUEST['evntstrtdt']) && (trim($_REQUEST['evntstrtdt']) != "")){
		$result = "";
		$name = glb_func_chkvl($_REQUEST['evntname']);
		$strtdt = glb_func_chkvl($_REQUEST['evntstrtdt']);
		$sqryevnt_mst = "SELECT evntm_name from evnt_mst
						 where evntm_name = '".$name."' and
						 evntm_strtdt = '$strtdt'";

		if(isset($_REQUEST['evntid']) && (trim($_REQUEST['evntid']) != ""))
		{
			$evntid = glb_func_chkvl($_REQUEST['evntid']);
			$sqryevnt_mst .= " and evntm_id != $evntid";
		}
		$srsevnt_mst  = mysqli_query($conn,$sqryevnt_mst);
		$reccnt		   = mysqli_num_rows($srsevnt_mst);
		if($reccnt > 0)
		{
			$result = "<font color ='red'><b>Duplicate Name And Date</b></font>";
		}
		echo $result;
	}

// -----------------------End to check duplicate Events and News name -----------------