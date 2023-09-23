<?php
	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once '../includes/inc_usr_functions.php';//Use function for validation and more
	include_once '../includes/inc_folder_path.php';

	if(isset($_POST['btnedtevnt']) && (trim($_POST['btnedtevnt']) != "") &&
	   isset($_POST['txtname']) && ($_POST['txtname'] != "") &&
       isset($_POST['txtdesc']) && ($_POST['txtdesc'] != "") &&

	   isset($_POST['txtstdate']) && ($_POST['txtstdate'] != "") &&
	   isset($_POST['txtprior']) && ($_POST['txtprior'] != "") &&
	   isset($_POST['hdnevntid']) && ($_POST['hdnevntid'] != "")){

		$id 	  = glb_func_chkvl($_POST['hdnevntid']);
		$name     = glb_func_chkvl($_POST['txtname']);
		$lnkval     = glb_func_chkvl($_POST['txtlnk']);
		$desc     = addslashes(trim($_POST['txtdesc']));
		$city	  =	glb_func_chkvl($_POST['txtcity']);
		$venue	  =	glb_func_chkvl($_POST['txtvenue']);
		$dept	  =	glb_func_chkvl($_POST['lstprodcat']);
		$lstacyr  =	glb_func_chkvl(trim($_POST['lstacyr']));
		$dstrct ='0';
		if(isset($_POST['lstdstrct']) && $_POST['lstdstrct'] != ""){
		$dstrct   =	glb_func_chkvl($_POST['lstdstrct']);
		}

		$stdt 	  =	glb_func_chkvl($_POST['txtstdate']);
		$sttm	  = trim($_POST['lststhr']);
		if($_POST['lststmin']!=""){
			$sttm.= ":".trim($_POST['lststmin']);
		}
		if($_POST['lstst'] !=""){
			$sttm.=" ".trim($_POST['lstst']);
		}
		$eddt 	  =	glb_func_chkvl($_POST['txteddt']);
		$edtm	  = trim($_POST['lstethr']);
		if($_POST['lstetmin']!=""){
			$edtm.=":".trim($_POST['lstetmin']);
		}
		if($_POST['lstet']!=""){
			$edtm.=" ".trim($_POST['lstet']);
		}

		$hdnfle_evnt = $id."-".glb_func_chkvl($_REQUEST['hdnevntnm']);
		$hdnimg_evnt = glb_func_chkvl($_REQUEST['hdnsimg']);

		$nvets	    = glb_func_chkvl($_POST['txtnvets']);
		$prior      = glb_func_chkvl($_POST['txtprior']);
		$sts        = glb_func_chkvl($_POST['lststs']);
		$curdt		= date('Y-m-d h:i:s');
		$pg         = glb_func_chkvl($_REQUEST['pg']);
		$ck         = glb_func_chkvl($_REQUEST['chk']);
		$opt        = glb_func_chkvl($_REQUEST['optn']);
		$val        = glb_func_chkvl($_REQUEST['val']);
		$cntstart   = glb_func_chkvl($_REQUEST['countstart']);


		$sqryevnt_mst="	select
							evntm_name
						from
							evnt_mst
						where
							evntm_name='$name' and
							evntm_strtdt = '$stdt' and
							evntm_id !=$id";
		$srsevnt_mst = mysqli_query($conn,$sqryevnt_mst);
		$cnt_evntm	 = mysqli_num_rows($srsevnt_mst);
		if($cnt_evntm < 1){
			$uqryevnt_mst="update evnt_mst set
						   evntm_name='$name',
						   evntm_desc='$desc',
						   evntm_city='$city',
						   evntm_venue='$venue',
						   evntm_dstrctm_id='$dstrct',
						   evntm_strtdt='$stdt',
						   evtnm_strttm='$sttm',
						   evntm_enddt='$eddt',
						   evntm_endtm='$edtm',
						   evntm_lnk='$lnkval',
						   evntm_dept='$dept',
							 evntm_acyr='$lstacyr',
						   evntm_btch='$nvets',
						   evntm_prty='$prior',
						   evntm_sts='$sts',
						   evntm_mdfdon='$curdt',
						   evntm_mdfdby='$sesadmin'";

			/*------------------- Update Event File-----------------*/
					$evntsource = "";
					$evntdest   = "";
					$fle_evnt	= 'evntfle';
					if(isset($_FILES[$fle_evnt]['tmp_name']) && ($_FILES[$fle_evnt]['tmp_name']!="")){
							$dwnldfleval = funcUpldFle($fle_evnt,'');
							if($dwnldfleval != ""){
								$dwnldfleval = explode(":",$dwnldfleval,2);
								$evntdest 		= $dwnldfleval[0];
								$evntsource 	= $dwnldfleval[1];
							}
					 $uqryevnt_mst .= ",evntm_fle='$evntdest'";
					}
			/*-------------------End Update Event File -----------------*/
			/*------------------- Update Event Image-----------------*/
				/*	if(isset($_FILES['fleimg']['tmp_name']) && ($_FILES['fleimg']['tmp_name']!="")){
						$imgval     = funcUpldImg('fleimg','img');
						if($imgval != ""){
							$imgary    = explode(":",$imgval,2);
							$imgdest   = $imgary[0];
							$imgsource = $imgary[1];
						}
						if(($imgsource!='none') && ($imgsource!='') && ($imgdest != "")){
							$uqryevnt_mst .= ",evntm_img='$imgdest'";
						}
					 }
			/*------------------- Update Event Image-----------------*/
			$uqryevnt_mst .=" where evntm_id=$id";
			$ursevnt_mst = mysqli_query($conn,$uqryevnt_mst) or die (mysqli_error($conn));
			if($ursevnt_mst==true){
				if(($evntsource!='none') && ($evntsource!='') && ($evntdest!= "")){
						 $evntflpath      = $gevnt_fldnm.$hdnfle_evnt;
					 	 if(($hdnfle_evnt != '') && file_exists($evntflpath)){
						 unlink($evntflpath);
						 }
						 move_uploaded_file($evntsource,$gevnt_fldnm.$id."-".$evntdest);
					}
				/*	if(($imgsource!='none') && ($imgsource!='') && ($imgdest != "")){
						$imgpth     = $imgevnt_fldnm.$hdnimg_evnt;
						if(($hdnimg_evnt != '') && file_exists($imgpth)){
							unlink($imgpth);
						}
						move_uploaded_file($imgsource,$imgevnt_fldnm.$imgdest);
					}	*/
					$cntcntrl    = glb_func_chkvl($_POST['hdntotcntrl']);
					if($id!="" && $cntcntrl !="" ){
						for($i=1;$i<=$cntcntrl;$i++){
							$cntrlid  	 = glb_func_chkvl("hdnpgdid".$i);
							$pgdtlid  	 = glb_func_chkvl($_POST[$cntrlid]);
							$phtcntrl_nm = glb_func_chkvl("txtphtname1".$i);
							$phtval   	 = glb_func_chkvl($_POST[$phtcntrl_nm]);
							$phtname     = $i."-". $phtval;
							if($phtval ==""){
								$phtname =  $i."-".$name;
							}
							$prtycntrl_nm = glb_func_chkvl("txtphtprior".$i);
							$prtyval 	  = glb_func_chkvl($_POST[$prtycntrl_nm]);
							if(($prtyval == '') || ($prtyval < 1)){
								$prtyval = $i;
							}
							$phtsts 	  = glb_func_chkvl("lstphtsts".$i);
							$sts     	  = glb_func_chkvl($_POST[$phtsts]);

							//**********************IMAGE UPLOADING START*******************************//
							 $simg='flesmlimg'.$i;
							//*------------------------------------Update small image----------------------------*/

							//if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!="")){
								$simgval = funcUpldImg($simg,'simg');
								if($simgval != ""){
									$simgary = explode(":",$simgval,2);
									$sdest 		= $simgary[0];
									$ssource 	= $simgary[1];
								}

								if($pgdtlid != ''){

								  $sqrypg_dtl = "select
													evntimgd_img
												 from
													evntimg_dtl
												 where
													evntimgd_name ='$phtname' and
													evntimgd_id !='$pgdtlid' and
													evntimgd_evntm_id ='$id'";
									$srevntimgd_dtl 	= mysqli_query($conn,$sqrypg_dtl);
									$cntrec_evntimg = mysqli_num_rows($srevntimgd_dtl);
									if($cntrec_evntimg < 1){
									//echo "text";
										$srowevntimgd_dtl  = mysqli_fetch_assoc($srevntimgd_dtl);
										$dbsmlimg 		= $srowevntimgd_dtl['evntimgd_img'];
										$smlimgpth      = $imgevnt_fldnm.$dbsmlimg;
										if(($dbsmlimg != '') && file_exists($smlimgpth)){
											unlink($smlimgpth);
										}
										$uqryevntimgd_dtl ="update evntimg_dtl set
															  evntimgd_name = '$phtname'";
									if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!="")){
										$uqryevntimgd_dtl .=" ,evntimgd_img = '$sdest'";
									}
									$uqryevntimgd_dtl .=" ,evntimgd_sts = '$sts',
															  evntimgd_prty = '$prtyval',
															  evntimgd_mdfdon= '$curdt',
															  evntimgd_mdfdby = '$ses_admin'
														  where
															  evntimgd_evntm_id = '$id' and
															  evntimgd_id='$pgdtlid'";
										$srevntimgd_dtl = mysqli_query($conn,$uqryevntimgd_dtl) or die (mysqli_error($conn));
									}
								}
								else{
									$sqrypg_dtl = "select
														evntimgd_img
												   from
														evntimg_dtl
												   where
														evntimgd_name ='$phtname' and
														evntimgd_evntm_id='$id'";
									$srevntimgd_dtl 	= mysqli_query($conn,$sqrypg_dtl) or die (mysqli_error($conn));
									$cntrec_evntimg = mysqli_num_rows($srevntimgd_dtl);
									if($cntrec_evntimg < 1){
										$iqrypg_dtl ="insert into evntimg_dtl(
													  evntimgd_name,evntimgd_img,evntimgd_sts,evntimgd_prty,
													  evntimgd_evntm_id,evntimgd_typ,evntimgd_crtdon,evntimgd_crtdby)values(
													  '$phtname','$sdest','$sts','$prtyval',
													  '$id','1','$curdt','$ses_admin')";
										$srevntimgd_dtl = mysqli_query($conn,$iqrypg_dtl) or die (mysqli_error($conn));
									}
								}
								if($srevntimgd_dtl){
									if(($ssource!='none') && ($ssource!='') && ($sdest != "")){
										move_uploaded_file($ssource,$imgevnt_fldnm.$sdest);
									}
								}
							//}
						}//End of For Loop
				  }


				?>
					<script>location.href="view_event.php?edit=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&optn=<?php echo $opt;?>&val=<?php echo $val;?>&chk=<?php echo $ck;?>&countstart=<?php echo $cntstart;?>";</script>
				<?php
			}
			else{
				?>
					<script>location.href="view_event.php?edit=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&optn=<?php echo $opt;?>&val=<?php echo $val;?>&chk=<?php echo $ck;?>&countstart=<?php echo $cntstart;?>";</script>
				<?php
			}
		}
		else{
			?>
				<script>location.href="view_event.php?edit=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&optn=<?php echo $opt;?>&val=<?php echo $val;?>&chk=<?php echo $ck;?>&countstart=<?php echo $cntstart;?>";</script>
			<?php
		}
	}
	?>