<?php
error_reporting(0);
	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once '../includes/inc_adm_session.php';//checking for session
	include_once '../includes/inc_connection.php';//Making database Connection
	include_once '../includes/inc_usr_functions.php';//Use function for validation and more	
	include_once '../includes/inc_config.php';
	include_once '../includes/inc_folder_path.php';		

	/***************************************************************/
	//Programm 	  : view_pagecontain_detail.php	
	//Package 	  : 
	//Purpose 	  : View pagecontain details
	//Created By  : Mallikarjuna
	//Created On  :	
	//Modified By : 
	//Modified On : 
	//Company 	  : Adroit
	/************************************************************/
	global $id,$pg,$cntstart,$msg,$loc,$rd_crntpgnm,$rd_edtpgnm,$clspn_val;	
	$rd_crntpgnm = "view_all_pagecontain.php";
	$rd_edtpgnm  = "edit_pagecontain.php";
	$clspn_val   = "6";
	/*****header link********/
$pagemncat = "Page Content";
$pagecat = "Page Contents";
$pagenm = "Page Contents";
/*****header link********/ 
	if(isset($_REQUEST['edtpgcntid']) && trim($_REQUEST['edtpgcntid'])!="" &&
	   isset($_REQUEST['pg']) && trim($_REQUEST['pg'])!="" &&
	   isset($_REQUEST['cntstart']) && trim($_REQUEST['cntstart'])!=""){
		
		$id 	  = glb_func_chkvl($_REQUEST['edtpgcntid']);
		$pg 	  = glb_func_chkvl($_REQUEST['pg']);
		$cntstart = glb_func_chkvl($_REQUEST['cntstart']);
		$optn 	  = glb_func_chkvl($_REQUEST['optn']);
		$val 	  = glb_func_chkvl($_REQUEST['txtsrchval']);
		$lstctone = glb_func_chkvl($_REQUEST['lstcatone']);
		$lstcttwo = glb_func_chkvl($_REQUEST['lstcattwo']);
		$lstdpt   = glb_func_chkvl($_REQUEST['lstdept']);
		$chk	  = glb_func_chkvl($_REQUEST['chkexact']);
				
		if($optn !="" && $val != ""){
			$loc = "&optn=".$optn."&txtsrchval=".$val;	
		}
		if($chk == "y"){
			$loc .= "&chkexact=".$chk;
		}
		if($optn !="" && $lstctone != ""){
			$loc = "&optn=".$optn."&lstcatone=".$lstctone;			
		}
		if($optn !="" && $lstcttwo != ""){
			$loc = "&optn=".$optn."&lstcattwo=".$lstcttwo;			
		}
		if($optn !="" && $lstdpt != ""){
			$loc = "&optn=".$optn."&lstdept=".$lstdpt;			
		}
		
		 $sqrypgcnts_dtl="SELECT 
								pgcntsd_id,pgcntsd_name,pgcntsd_desc,pgcntsd_lnk,
								pgcntsd_sts,pgcntsd_prty,prodcatm_name,prodscatm_name,
								pgcntsd_fle,pgcntsd_typ,pgcntsd_seotitle,pgcntsd_seodesc,
								pgcntsd_seokywrd,pgcntsd_seohone,pgcntsd_seohtwo,pgcntsd_deptm_id,pgcntsd_prodmnlnks_id,
								pgcntsd_bnrimg,prodmnlnksm_name
					  	 from 
								vw_pgcnts_prodcat_prodscat_mst
								
	                  	 where 
								pgcntsd_id=$id";
								// echo $sqrypgcnts_dtl;exit;	
	 	$srspgcnts_dtl = mysqli_query($conn,$sqrypgcnts_dtl);
		$cntrec_pgcnts = mysqli_num_rows($srspgcnts_dtl);
		if($cntrec_pgcnts  > 0){
			
	 	$rowspgcnts_dtl 	 = mysqli_fetch_assoc($srspgcnts_dtl);
		    // $db_deptname	 = $rowspgcnts_dtl['deptm_name'];	
				$db_mnlnksnm	 = $rowspgcnts_dtl['prodmnlnksm_name'];	
			$db_catname		 = $rowspgcnts_dtl['prodcatm_name'];
			$db_scatname	 = $rowspgcnts_dtl['prodscatm_name'];
			$db_pgcntname	 = $rowspgcnts_dtl['pgcntsd_name'];
			$db_pgcntdesc	 = stripslashes($rowspgcnts_dtl['pgcntsd_desc']);
			$db_pgcntlnk	 = $rowspgcnts_dtl['pgcntsd_lnk'];
			$db_pgcntfl		 = $rowspgcnts_dtl['pgcntsd_fle'];
			$db_pgcntseottl	 = $rowspgcnts_dtl['pgcntsd_seotitle'];
			$db_pgcntseodesc = $rowspgcnts_dtl['pgcntsd_seodesc'];
			$db_pgcntseokywrd= $rowspgcnts_dtl['pgcntsd_seokywrd'];
			$db_pgcntseohone = $rowspgcnts_dtl['pgcntsd_seohone'];
			$db_pgcntseohtwo = $rowspgcnts_dtl['pgcntsd_seohtwo'];
			$db_pgcntprty	 = $rowspgcnts_dtl['pgcntsd_prty'];
			$db_pgcntsts	 = $rowspgcnts_dtl['pgcntsd_sts'];
			$db_pgcntstype   = $rowspgcnts_dtl['pgcntsd_typ'];
		}
		else{
			header("Location:".$rd_crntpgnm);
			exit();
		}
	}
	else{
		header("Location:".$rd_crntpgnm);
		exit();
	}	
	if(isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) != "")){	
		$stsval = trim($_REQUEST['sts']);
		if($stsval == 'y'){
			$msg = "<font color=red>Record updated successfully</font>";
		}
		elseif($stsval == 'n'){
			$msg = "<font color=red>Record not updated (Try Again)</font>";
		}
		elseif($stsval == 'd'){
			$msg = "<font color=red>Duplicate Record Name Exists & Record Not updated</font>";
		}				    	
	}
	$rqst_stp      	= $rqst_arymdl[1];
	$rqst_stp_attn     = explode("::",$rqst_stp);
	$rqst_stp_chk      	= $rqst_arymdl[0];
	$rqst_stp_attn_chk     = explode("::",$rqst_stp_chk);
	if($rqst_stp_attn_chk[0] =='2'){
		$rqst_stp      	= $rqst_arymdl[0];
		$rqst_stp_attn     = explode("::",$rqst_stp);
	}	    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- <link href="css/yav-style.css" type="text/css" rel="stylesheet"> -->
<title><?php echo $pgtl; ?></title>	
	<?php include_once ('script.php');?>	
	<script language="javascript" type="text/javascript">
		function update(){
			frmedtpgcntn.action="<?php echo $rd_edtpgnm;?>?edtpgcntid=<?php echo $id;?>&pg=<?php echo $pg;?>&cntstart=<?php echo $cntstart.$loc;?>"
			frmedtpgcntn.submit();
		}
	</script>
</head>
<body>
<?php
  include_once $inc_adm_hdr;
  include_once $inc_adm_lftlnk;
  ?>
  <section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">View Page Content Deatails</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">View Page Content Deatails</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtpgcntn" id="frmedtpgcntn" method="post" action="<?php $_SERVER['SCRIPT_FILENAME'];?>" onSubmit="return performCheck('frmedtpgcntn', rules, 'inline');" enctype="multipart/form-data">
		  <input type="hidden" name="edtpgcntid" id="edtpgcntid" value="<?php echo $id;?>">
		  <input type="hidden" name="pg" id="pg" value="<?php echo $pg;?>">
		  <input type="hidden" name="cntstart" id="cntstart" value="<?php echo $cntstart;?>">
		  <input type="hidden" name="optn" id="optn" value="<?php echo $optn;?>">
		  <input type="hidden" name="txtsrchval" id="txtsrchval" value="<?php echo $val;?>">
		  <input type="hidden" name="lstcatone" id="lstcatone" value="<?php echo $lstctone;?>">
		  <input type="hidden" name="lstcattwo" id="lstcattwo" value="<?php echo $lstcttwo;?>">
		   <input type="hidden" name="lstdept" id="lstdept" value="<?php echo $lstdpt;?>">
		 <input type="hidden" name="hdnsimg" value="<?php echo $rowspgcnts_dtl['prodimgd_img'];?>">
		 
		  <?php
			if($msg != "")
			{
				echo " <tr bgcolor='#FFFFFF'>
				<td align='center' colspan='$clspn_val'><font color='red'>$msg</font></td></tr>";
			}
			?>
 <div class="card">
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-md-12">
          <div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Mainlinks</label>
							<div class="col-sm-8">
              <?php echo $db_mnlnksnm; ?>
							</div>
						</div>
            
            <div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Category</label>
							<div class="col-sm-8">
              <?php echo $db_catname; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Sub Category</label>
							<div class="col-sm-8">
              <?php echo $db_scatname; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Name</label>
							<div class="col-sm-8">
              <?php echo $db_pgcntname; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Description</label>
							<div class="col-sm-8">
              <?php echo $db_pgcntdesc; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Link</label>
							<div class="col-sm-8">
              <?php echo $db_pgcntlnk; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Banner Images</label>
							<div class="col-sm-8">
              <?php
					$imgnm   = $rowspgcnts_dtl['pgcntsd_bnrimg'];
					$imgpath = $a_pgcnt_bnrfldnm.$imgnm;
					if(($imgnm !="") && file_exists($imgpath)){
						echo "<img src='$imgpath' width='80pixel' height='80pixel'>";					
					}
					else{
						echo "N.A.";						 			  
					}
					?>	
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Status</label>
							<div class="col-sm-8">
              <?php
					$evntflnm 	 = $db_pgcntfl;
					    $evntflpath  = $gevnt_fldnm.$id."-".$evntflnm;
						if(($evntflnm !="") && file_exists($evntflpath)){
						echo $evntflnm ;
						}
					  	else{
						 echo "Files not available";
					  	}
					?>	
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO Title</label>
							<div class="col-sm-8">
              <?php echo $db_pgcntseottl; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO Description</label>
							<div class="col-sm-8">
              <?php echo $db_pgcntseodesc; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO Keyword</label>
							<div class="col-sm-8">
              <?php echo $db_pgcntseokywrd; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO H1</label>
							<div class="col-sm-8">
              <?php echo $db_pgcntseohone; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO H2</label>
							<div class="col-sm-8">
              <?php echo $db_pgcntseohtwo; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Rank</label>
							<div class="col-sm-8">
              <?php echo $db_pgcntprty; ?>
							</div>
						</div>
            <div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Status</label>
							<div class="col-sm-8">
              <?php echo funcDispSts($db_pgcntprty); ?>
							</div>
						</div>
						<div class="col-sm-3">
            <label>Images:</label>
							</div>
						<div class="table-responsive">
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
								<td width="5%" align="center"><strong>SL.No.</strong></td>
										<td width="15%" align="center"><strong>Name</strong></td>
                                        <!-- <td width="15%" align="center"><strong>Designation</strong></td> -->
										<td width="15%" align="center"><strong>Image</strong></td>
                                        <!-- <td width="15%" align="center"><strong>File</strong></td> -->
										<td width="10%" align="center"><strong>Rank</strong></td>
										<td width="10%" align="center"><strong>Status</strong></td>
								</tr>
							</table>
						</div>
			
			  <?php
			  $sqryimg_dtl="SELECT 
								  pgimgd_name,pgimgd_desig,pgimgd_pgcntsd_id,pgimgd_img,pgimgd_prty,pgimgd_desig,
								  if(pgimgd_sts = 'a', 'Active','Inactive') as pgimgd_sts,pgimgd_fle
							 from  pgimg_dtl
							 where 
								  pgimgd_pgcntsd_id ='$id' 
							 order by 
								  pgimgd_id";
	               $srsimg_dtl	= mysqli_query($conn,$sqryimg_dtl);		
		           $cntpgimg_dtl  = mysqli_num_rows($srsimg_dtl);
			  	$cnt = $offset;
				if($cntpgimg_dtl> 0 ){				
			  	while($rowpgimg_dtl	  = mysqli_fetch_assoc($srsimg_dtl)){	
						$db_pgimgnm   = $rowpgimg_dtl['pgimgd_name'];
					
						$db_pgimgimg  = $rowpgimg_dtl['pgimgd_img'];
						$db_pgimgprty = $rowpgimg_dtl['pgimgd_prty'];
						$db_pgimgsts  = $rowpgimg_dtl['pgimgd_sts'];
						$db_pgimgdesig  = $rowpgimg_dtl['pgimgd_desig'];
							
					$cnt+=1;
					$clrnm = "";
					if($cnt%2==0){
						$clrnm = "bgcolor='#f1f6fd'";
					}
					else{
						$clrnm = "bgcolor='#f1f6fd'";
					}
			  ?>
 <table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr >
								<td width="5%" align="center"><?php echo $cnt ?></td>
								<td width="15%" align="center"><?php echo $db_pgimgnm; ?></td>
                <!-- <td width="15%" align="center"> <?php echo $db_pgimgdesig; ?></td> -->
                <td width="15%" align="center">
								<?php
					$imgnm   = $db_pgimgimg;
					$imgpath = $a_phtgalspath.$imgnm;					
				  if(($imgnm !="") && file_exists($imgpath)){
					 echo "<img src='$imgpath' width='80pixel' height='80pixel'>";
				  }
				  else{
					 echo "Image not available";
				  }
				?>
	</td>
	<!-- <td width="15%" align="center">
                        
												<?php
												$fle = $rowpgimg_dtl['pgimgd_fle'];
												$flepath = $a_phtgalbpath . $fle;
												if (($fle != "")) {
												 
													echo "<a href='$flepath'  target='_blank' >View</a>";
												} else {
													echo "file not available";
												}
												?>
											</td> -->

											<td width="10%" align="center"> <?php echo $db_pgimgprty; ?></td>
											<td width="10%" align="center"> <?php echo $db_pgimgsts;?></td>
										
										</tr>
										</table>
										<?php
									}
								} else {
									echo "<tr bgcolor='#F2F1F1'>
				<td colspan='6' align='center'>Image not available</td>
			</tr>";
								}
								?>
<div class="col-sm-3">
            <label>Videos:</label>
							</div>
						<div class="table-responsive">
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr>
								<td width="5%" align="center"><strong>SL.No.</strong></td>
										<td width="15%" align="center"><strong>Name</strong></td>
                      <td width="15%" align="center"><strong>Video</strong></td>
									
										<td width="10%" align="center"><strong>Rank</strong></td>
										<td width="10%" align="center"><strong>Status</strong></td>
								</tr>
							</table>
						</div>

				<?php
			  	$sqryvdo_dtl="select 	pgvdod_id,pgvdod_name,pgvdod_pgcntsd_id,pgvdod_vdo,
								pgvdod_prty,pgvdod_sts from  pgvdo_dtl
							 where pgvdod_pgcntsd_id ='$id' 
							 order by  pgvdod_id";
	            $srsvdo_dtl	= mysqli_query($conn,$sqryvdo_dtl);		
		        $cntpgvdo_dtl  = mysqli_num_rows($srsvdo_dtl);
			  	$nfiles = "";
				if($cntpgvdo_dtl> 0 ){
				?>
				<?php				
			  	while($rowspgvdod_mdtl=mysqli_fetch_assoc($srsvdo_dtl))
				{
					$pgvdodid = $rowspgvdod_mdtl['pgvdod_id'];
					$vdonm = $rowspgvdod_mdtl['pgvdod_name'];
					$vdolnk = $rowspgvdod_mdtl['pgvdod_vdo'];
					// $vdopath = $a_phtgalspath.$vdonm;
					$nfiles+=1;
					$clrnm = "";
					if($cnt%2==0){
						$clrnm = "bgcolor='#f1f6fd'";
					}
					else{
						$clrnm = "bgcolor='#f1f6fd'";
					}
			  ?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr >
								<td width="5%" align="center"><?php echo $nfiles ?></td>
							
								<td width="15%" align="center">	<?php echo $vdonm; ?></td>
								<td width="15%" align="center">	<?php echo $vdolnk; ?></td>
							
								<td width="10%" align="center">	 <?php echo $rowspgvdod_mdtl['pgvdod_prty'];?></td>
								<td width="10%" align="center"><?php echo funcDispSts($rowspgvdod_mdtl['pgvdod_sts'])?></td>
							
								</tr>
										</table>
										<?php
									}
								} else {
									echo "<tr bgcolor='#F2F1F1'>
				<td colspan='6' align='center'Videos not available</td>
			</tr>";
								}
								?>
<div class="col-sm-3">
            <label>Questions:</label>
							</div>
<div class="table-responsive">
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
								<td width="10%" align="center"><strong>SL.No.</strong></td>
										<td width="35%" align="center"><strong>Name</strong></td>
										<td width="35%" align="center"><strong>Description</strong></td>
										<td width="10%" align="center"><strong>Rank</strong></td>
										<td width="10%" align="center"><strong>Status</strong></td>
								</tr>
							</table>
						</div>
						<?php
						$sqns="SELECT pgcntqns_id,pgcntqns_name,pgcntqns_pgcntsd_id,pgcntqns_vdo,
						 pgcntqns_prty,pgcntqns_sts from  pgcntqnsm_dtl where pgcntqns_pgcntsd_id='$id' and pgcntqns_name!='' order by pgcntqns_id";
						$srsns = mysqli_query($conn, $sqns);
						$cntqns=mysqli_num_rows($srsns);
						if ($cntqns > 0) {
							
					
						$nfiles = "";
						while ($rowsns = mysqli_fetch_assoc($srsns)) {
							$nfiles+=1;
							?>
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
								<td width="10%" align="center"><?php echo $nfiles ?></td>
								
										<td width="35%" align="center"><?php echo $rowsns['pgcntqns_name']; ?></td>
										<td width="35%" align="center"><?php echo $rowsns['pgcntqns_vdo']; ?></td>
										
										<td width="10%" align="center"><?php echo $rowsns['pgcntqns_prty']; ?></td>
										<td width="10%" align="center"><?php echo $rowsns['pgcntqns_sts']; ?></td>
								</tr>
							</table>
							<?php
						}
					}
					else{
						?>
						<td width="10%"  align="center"><?php echo "No Record Found"; ?></td>
						
				<?php	}
						?>

						<p class="text-center">
						<?php
					if(($rqst_stp_attn[1]=='3') || ($rqst_stp_attn[1]=='4') || $ses_admtyp =='a'){
				?>
						<input type="Submit" class="btn btn-primary btn-cst" name="btnedtphcntn" id="btnedtphcntn" value="Edit" onClick="update();">
						<?php
						}
						?>
						
							&nbsp;&nbsp;&nbsp;
							<input type="button"  name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='<?php echo $rd_crntpgnm;?>?pg=<?php echo $pg;?>&cntstart=<?php echo $cntstart.$loc;?>'">
							
						</p>
					</div>
				</div>
			</div>
		</div>
	</form> 
</section>
<?php include_once "../includes/inc_adm_footer.php";?>















				<tr valign="middle" bgcolor="#FFFFFF">
						<td colspan="<?php echo $clspn_val;?>" align="center" bgcolor="#f1f6fd">
						<?php
					if(($rqst_stp_attn[1]=='3') || ($rqst_stp_attn[1]=='4') || $ses_admtyp =='a'){
				?>
						<input type="Submit" class="textfeild"  name="btnedtphcntn" id="btnedtphcntn" value="Edit" onClick="update();">
						<?php
						}
						?>
						&nbsp;&nbsp;&nbsp;
						<input type="button"  name="btnBack" value="Back" class="textfeild" onclick="location.href='<?php echo $rd_crntpgnm;?>?pg=<?php echo $pg;?>&cntstart=<?php echo $cntstart.$loc;?>'">
						</td>
				</tr>
			  </form> </table>
       </td>
     </tr>
    </table></td>
  </tr>
</table>
<?php include_once "../includes/inc_adm_footer.php";?>
</body>
</html>