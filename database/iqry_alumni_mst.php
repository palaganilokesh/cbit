<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnalumnisbmt']) && (trim($_POST['btnalumnisbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$link= glb_func_chkvl($_POST['txtlnk']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$alumniimg = glb_func_chkvl($_POST['flealumniimg']);

	$sts = glb_func_chkvl($_POST['lststs']);
    $batch = glb_func_chkvl($_POST['txtbatch']);
	    $job = glb_func_chkvl($_POST['txtjob']);
	
	
	$curdt = date('Y-m-d h-i-s');
	$sqryalumni_mst = "SELECT alumnim_name from alumni_mst where alumnim_name ='$name'";
	$srsalumni_mst = mysqli_query($conn,$sqryalumni_mst);
	$rows = mysqli_num_rows($srsalumni_mst);
	if($rows < 1)
	{
		if(isset($_FILES['flealumniimg']['tmp_name']) && ($_FILES['flealumniimg']['tmp_name']!=""))
		{
			$alumniimgval = funcUpldImg('flealumniimg','alumniimg');
			if($alumniimgval != "")
			{
				$alumniimgary = explode(":",$alumniimgval,2);
				$alumnidest = $alumniimgary[0];
				$alumnisource = $alumniimgary[1];
			}
		}
		$iqryalumni_mst="INSERT into alumni_mst(alumnim_name,alumnim_desc, alumnim_lnk,alumnim_batch,alumnim_job, alumnim_prty, alumnim_sts, alumnim_imgnm, alumnim_crtdon, alumnim_crtdby) values ('$name', '$desc', '$link','$batch','$job', '$prior', '$sts', '$alumnidest', '$curdt', '$ses_admin')";
		$irsalumni_mst= mysqli_query($conn,$iqryalumni_mst) or die(mysqli_error($conn));
		if($irsalumni_mst==true)
		{
			if(($alumnisource!='none') && ($alumnisource!='') && ($alumnidest != ""))
			{ 			
				move_uploaded_file($alumnisource,$galumni_fldnm.$alumnidest);					
			}
			$gmsg = "Record saved successfully";
		}
		else
		{
			$gmsg = "Record not saved";
		}
	}
	else
	{		
		$gmsg = "Duplicate name. Record not saved";
	}
}
?>