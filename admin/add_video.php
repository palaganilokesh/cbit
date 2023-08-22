<?php
error_reporting(0);
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************/
//Programm 	  : add_pagecontain.php
//Package 	  : 
//Purpose 	  : For adding Page
//Created By  : lokesh palagani
//Created On  :	
//Modified By : 
//Modified On : 
//Company 	  : Adroit
/************************************************************/
/*****header link********/
$pagemncat = "Gallery";
$pagecat = "Videos";
$pagenm = "Videos";
/*****header link********/
global $gmsg;	
if(isset($_POST['btnadprodsbmt']) && (trim($_POST['btnadprodsbmt']) != "") &&
   isset($_POST['txtname']) && (trim($_POST['txtname'])!='') &&
   isset($_POST['txtprty']) && ($_POST['txtprty'])!=''){

   include_once '../includes/inc_fnct_fleupld.php'; // For uploading files	
   include_once '../database/iqry_video_mst.php';
}


$rd_crntpgnm = "view_all_video.php";
$clspn_val   = "4";

$rqst_stp      	= $rqst_arymdl[1];
$rqst_stp_attn     = explode("::", $rqst_stp);
$rqst_stp_chk      	= $rqst_arymdl[0];
$rqst_stp_attn_chk     = explode("::", $rqst_stp_chk);
if ($rqst_stp_attn_chk[0] == '2') {
	$rqst_stp      	= $rqst_arymdl[0];
	$rqst_stp_attn     = explode("::", $rqst_stp);
}
$sesvalary = explode(",", $_SESSION['sesmod']);
if (!in_array(2, $sesvalary) || ($rqst_stp_attn[1] == '1')) {
	if ($ses_admtyp != 'a') {
		header("Location:main.php");
		exit();
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	
	<title><?php echo $pgtl; ?></title>
	<?php
	include_once('script.php');
	include_once '../includes/inc_fnct_ajax_validation.php'; //Includes ajax validations				
	?>
	<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">

	<script language="javascript" type="text/javascript">
		var rules = new Array();
    rules[1]='txtname:Name|required|Enter Name';
		rules[2]='txtprty:Priority|required|Enter Priority';
		rules[3]='txtprty:Priority|numeric|Enter Only Numbers';

	</script>
	<script language="javascript">	
		function setfocus()
		{
			document.getElementById('txtname1').focus();
		}
	</script>
   <script language="javascript" type="text/javascript">
    var nfiles=1;
	 function expand () {
			nfiles ++;
            var htmlTxt = '<?php
					echo "<table border=\'0\' cellpadding=\'1\' cellspacing=\'1\' width=\'100%\'>"; 
					echo "<tr>";
					echo "<td align=\'center\' width=\'5%\'> ' + nfiles + '</td>";					
					echo "<td align=\'left\' width=\'35%\'>";
					echo "<input type=text name=txtphtname' + nfiles + ' id=txtphtname1' + nfiles + ' class=form-control                            size=\'50\'>";
					echo "</td>"; 
					
			    	echo "<td align=\'left\' width=\'35%\'>";
					echo "<input type=text name=txtvidur' + nfiles + ' id=txtvidur' + nfiles + ' class=form-control><br>";
					echo "</td>";
					
				    echo "<td align=\'left\' width=\'10%\'>";
					echo "<input type=\'text\' name=txtphtprior' + nfiles + ' id=txtphtprior' + nfiles + ' class=form-control size=5 maxlength=3>";
					echo "</td>"; 
					
					echo "<td align=center width=\'10%\'>";
					echo "<select name=lstphtsts' + nfiles + ' id=lstphtsts' + nfiles + ' class=form-control>";
					echo "<option value=a>Active</option>";
					echo "<option value=i>Inactive</option>";
					echo "</select>";
					echo "</td></tr></table>";						
				?>';
			
           	 var Cntnt = document.getElementById ("myDiv");         
		 	 							 
			 if (document.createRange) {//all browsers, except IE before version 9 
					
				 var rangeObj = document.createRange ();
					Cntnt.insertAdjacentHTML('BeforeBegin' , htmlTxt);					
					document.frmaddprod.hdntotcntrl.value = nfiles;	
				   if (rangeObj.createContextualFragment) { // all browsers, except IE	
					}
					else{//Internet Explorer from version 9
						Cntnt.insertAdjacentHTML('BeforeBegin' , htmlTxt);
					}
				}			
				else{//Internet Explorer before version 9
					Cntnt.insertAdjacentHTML ("BeforeBegin", htmlTxt);
				}
				document.getElementById('hdntotcntrl').value = nfiles;						
				document.frmaddprod.hdntotcntrl.value = nfiles;
			}
	
	
	//**************************************************		
		
	</script>


</head>

<body onLoad="setfocus();">
	<?php
	include_once('../includes/inc_adm_header.php');

	?>

	<section class="content">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">Add Videos</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Add Videos</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>

		<div class="card-body p-0">
    <form name="frmaddprod" id="frmaddprod" method="post" action="<?php $_SERVER['PHP_SELF'];?>" 
          enctype="multipart/form-data" onSubmit="return performCheck('frmaddprod', rules, 'inline');">
          <input type="hidden" name="hdnlstszid" id="hdnlstszid">	

							<div class="col-md-12">
					<div class="row justify-content-center align-items-center">
						<?php
						if ($gmsg != "") {
							echo "<tr bgcolor='#f1f6fd'>
							<td align='center' valign='middle' bgcolor='#f1f6fd' colspan='$clspn_val' >
								<font face='Arial' size='2' color = 'red'>
									$gmsg
								</font>							
							</td>
			  			</tr>";
						}
						?>
						
						

						<?php /*?><tr bgcolor="#f1f6fd">
				<td width="18%" align="left" valign="top" bgcolor="#f1f6fd"><strong>Department</strong></td>
				<td width="2%" align="left" valign="center" bgcolor="#f1f6fd"><strong>:</strong></td> 
				<td width="40%" align="left" valign="top" bgcolor="#f1f6fd">
				<select name="lstdept" id="lstdept" style="width:150px" >
				  <option value="">--Select--</option>
				 <?php
					$sqrydept_mst="select 
										  deptm_id,deptm_name
									  from 
										  dept_mst
									  where 
										  deptm_sts='a'"; 
										  
					if($ses_admtyp =='u'){
						$sqrydept_dtl ="select 
											deptd_deptm_id
										from
											lgn_mst
											inner join dept_dtl on lgnm_id  = deptd_lgnm_id
										where
											deptd_lgnm_id ='$ses_adminid'";
							
						$srrsdept_dtl = mysqli_query($conn,$sqrydept_dtl);
						$cntrec_deptdtl = mysqli_num_rows($srrsdept_dtl);
						if($cntrec_deptdtl > 0){
							$srodept_drl = mysqli_fetch_assoc($srrsdept_dtl);
							$deptid = $srodept_drl['deptd_deptm_id'];
							$sqrydept_mst .=" and deptm_id = $deptid";
						}
					}
					$sqrydept_mst .=" order by deptm_name";
					$srsdept_mst=mysqli_query($conn,$sqrydept_mst);
					while($rowsdept_mst=mysqli_fetch_assoc($srsdept_mst)){
					?>
						<option value="<?php echo $rowsdept_mst['deptm_id'];?>"><?php echo $rowsdept_mst['deptm_name'];?></option>
						<?php
					 }						 
					 ?>
					 </select>
				</td>
				<td width="40%" align="left" valign="middle" bgcolor="#f1f6fd" style="color:#FF0000">
					<div id="errorsDiv_lstdept"></div>
				</td>
          </tr><?php */ ?>

						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Name *</label>
								</div>
								<div class="col-sm-9">
									<input name="txtname" type="text" id="txtname" size="45" maxlength="250" class="form-control" >
									<!-- onBlur="funcChkDupName()" -->
									<span id="errorsDiv_txtname"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Description </label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtdesc" id="txtdesc" cols="60" rows="3" class="form-control"></textarea>
									<span id="errorsDiv_txtdesc"></span>
								</div>
							</div>
						</div>
					
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Rank *</label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="txtprty" id="txtprty" class="form-control" size="4" maxlength="3">
									<span id="errorsDiv_txtprty"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Status</label>
								</div>
								<div class="col-sm-9">
									<select name="lststs" id="lststs" class="form-control">
										<option value="a" selected>Active</option>
										<option value="i">Inactive</option>
									</select>
								</div>
							</div>
						</div>


						

						
						
						<!-- Start Video Session -->
						<div class="table-responsive">
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
								<td width="5%" align="center"><strong>SL.No.</strong></td>
										<td width="35%" align="center"><strong>Name</strong></td>
										<td width="35%" align="center"><strong>Video</strong></td>
										<td width="10%" align="center"><strong>Rank</strong></td>
										<td width="10%" align="center"><strong>Status</strong></td>
								</tr>
							</table>
						</div>
						<div class="table-responsive">
									<table width="100%"  border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered" >
										<table width="100%" border="0" cellspacing="3" cellpadding="3">
											<tr bgcolor="#FFFFFF">
											<td width="5%" align="center">1</td>
												<td width="35%"  align="center">
													<input type="text" name="txtphtname1" id="txtphtname1" placeholder="Name" class="form-control" size="15"><br>
													<span id="errorsDiv_txtphtname1" style="color:#FF0000"></span>
												</td>
												<td width="35%"  align="center">
                        <input type="text" name="txtvidur1" id="txtvidur1" placeholder="video link" class="form-control" size="50"><br>
											
													<span id="errorsDiv_txtvidur1" style="color:#FF0000"></span>
												</td>
												
												<td width="10%"  align="center">
													<input type="text" name="txtphtprior1" id="txtphtprior1" class="form-control" size="15"><br>
													<span id="errorsDiv_txtphtprior1" style="color:#FF0000"></span>
												</td>
												<td width="10%" align="center" >					
													<select name="lstphtsts1" id="lstphtsts1" class="form-control">
														<option value="a" selected>Active</option>
														<option value="i">Inactive</option>
													</select>
												</td>
											</tr>
										</table>
									</table>
									<div id="myDiv">
										<table width="100%" cellspacing='2' cellpadding='3'>
											<tr>
												<td align="center">
													<input name="btnadd" type="button" onClick="expand()" value="Add Another Video" class="btn btn-primary mb-3">
												</td>
											</tr>
										</table>
									</div>
								</div>
									<!-- end Video Session -->

                  <input type="hidden" name="hdntotcntrl" value="1" >
							

						
								<p class="text-center">
							<input type="Submit" class="btn btn-primary" name="btnadprodsbmt" id="btnadprodsbmt" value="Submit">
							&nbsp;&nbsp;&nbsp;
							<input type="reset" class="btn btn-primary" name="btnreset" value="Clear" id="btnreset">
							&nbsp;&nbsp;&nbsp;
              <!-- <input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="window.location='videogallery.php'">	 -->
							<input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm; ?>'">
						</p>	
				
			</form>
		</div>
	</section>
	
	<?php include_once "../includes/inc_adm_footer.php"; ?>
</body>

</html>




<script language="javascript" type="text/javascript">
	//CKEDITOR.replace('txtdesc');
	CKEDITOR.replace('txtdesc', {
		'filebrowserImageUploadUrl': 'js/plugins/imgupload/imgupload.php'
	});
</script>