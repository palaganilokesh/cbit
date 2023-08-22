<?php	
	include_once "../includes/inc_connection.php"; //conneciton
	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	
	if(isset($_POST['btnaddphcat']) && (trim($_POST['btnaddphcat']) != "") && 	
	   isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && 
	   isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "")){
		   
		$name     = glb_func_chkvl($_POST['txtname']);
		$type     = glb_func_chkvl($_POST['addtype']);
		$dept      = glb_func_chkvl($_POST['lstprodcat']);
		$desc     = glb_func_chkvl($_POST['txtdesc']);
		$prior    = glb_func_chkvl($_POST['txtprior']);
		$sts      = glb_func_chkvl($_POST['lststs']);
		$img      = glb_func_chkvl($_POST['flebnrimg']);
		
		$dt       = date('Y-m-d');;

		$sqryphtcat_mst="SELECT 
							phtcatm_name
					     from 
						 	phtcat_mst
					     where 
						 	phtcatm_name='$name'";
		$srsphtcat_mst = mysqli_query($conn,$sqryphtcat_mst);
		$rows       = mysqli_num_rows($srsphtcat_mst);
		// if($rows > 0){
		// 	$gmsg = "Duplicate name. Record not saved";
		// }

		if($rows < 1){

			if(isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name']!=""))
		{
			$bnrimgval = funcUpldImg('flebnrimg','bnrimg');
			if($bnrimgval != "")
			{
				$bnrimgary = explode(":",$bnrimgval,2);
				$bnrdest = $bnrimgary[0];
				$bnrsource = $bnrimgary[1];
			}
		}

		
		
			
			$iqryphtcat_mst="INSERT into phtcat_mst(phtcatm_typ,phtcatm_deprtmnt,phtcatm_name,phtcatm_img,phtcatm_desc,phtcatm_prty,phtcatm_sts,phtcatm_crtdon,
phtcatm_crtdby)values('$type','$dept','$name','$bnrdest','$desc','$prior','$sts','$dt','$ses_admin')";
$irsphtcat_mst = mysqli_query($conn,$iqryphtcat_mst);
			if($irsphtcat_mst==true){
				if(($bnrsource!='none') && ($bnrsource!='') && ($bnrdest != ""))
			{ 			
				move_uploaded_file($bnrsource,$galry_fldnm.$bnrdest);					
			}
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