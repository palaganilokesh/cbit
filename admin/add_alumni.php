<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
include_once '../includes/inc_adm_dept_session.php'; //department sessions
/**********************************************************
Programm : add_alumni.php
Purpose :
Created By :
Created On :
Modified By :
Modified On :
Purpose :
Company : Adroit
************************************************************/
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Alumni";
$pagenm = "Alumni";
/*****header link********/
global $gmsg;
if(isset($_POST['btnalumnisbmt']) && (trim($_POST['btnalumnisbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
  include_once "../includes/inc_fnct_fleupld.php"; // For uploading files
  include_once "../database/iqry_alumni_mst.php";
}
$rd_crntpgnm = "view_all_alumni.php";
$clspn_val = "4";
?>
<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
 	var rules=new Array();
 	rules[0]='txtname:Name|required|Enter Name';
  // rules[1]='txtname:Name|alphaspace|Name only characters and numbers';
  rules[1]='txtprior:Priority|required|Enter Rank';
  rules[2]='txtprior:Priority|numeric|Enter Only Numbers';
  rules[3]='txtalin:Alignment|required|Select The Text Alignment';
  rules[4]='txtbatch:Priority|required|Enter Batch and Department';
  rules[5]='txtjob:job|required|Enter Job Name';
	// rules[4]='txtbtnname:Alignment|required|Enetr The Button Name';

	function setfocus()
	{
		document.getElementById('txtname').focus();
	}
</script>
<?php
include_once ('script.php');
include_once ('../includes/inc_fnct_ajax_validation.php');
?>
<script language="javascript" type="text/javascript">
	function funcChkDupName()
	{
		var name = document.getElementById('txtname').value;
		if(name != "")
		{
			var url = "chkduplicate.php?alumniname="+name;
			xmlHttp = GetXmlHttpObject(stateChanged);
			xmlHttp.open("GET", url , true);
			xmlHttp.send(null);
		}
		else
		{
			document.getElementById('errorsDiv_txtname').innerHTML = "";
  	}
  }
  function stateChanged()
  {
  	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
  	{
  		var temp = xmlHttp.responseText;
  		document.getElementById("errorsDiv_txtname").innerHTML = temp;
  		if(temp!=0)
  		{
  			document.getElementById('txtname').focus();
  		}
  	}
  }
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add alumni</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Add alumni</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- Default box -->
	<div class="card">
		<?php
		if($gmsg != "")
		{
			echo "<center><div class='col-12'>
			<font face='Arial' size='2' color = 'red'>$gmsg</font>
			</div></center>";
		}
		if(isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y"))
		{ ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert" id="delids">
				<strong>Deleted Successfully !</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<?php
		}
		?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert" id="updid" style="display:none">
			<strong>Updated Successfully !</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="alert alert-info alert-dismissible fade show" role="alert" id="sucid" style="display:none">
			<strong>Added Successfully !</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="card-body p-0">
			<form name="frmaddvehbrnd" id="frmaddvehbrnd" method="post" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" onSubmit="return performCheck('frmaddvehbrnd', rules, 'inline');">
				<div class="col-md-12">
					<div class="row justify-content-center align-items-center">
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Name *</label>
								</div>
								<div class="col-sm-9">
									<input name="txtname" type="text" id="txtname" size="560" class="form-control"  onBlur="funcChkDupName()">
									<!-- -->
									<span id="errorsDiv_txtname"></span>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Description</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtdesc" cols="60" rows="3" id="txtdesc" class="form-control"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Image</label>
								</div>
								<div class="col-sm-9">
									<div class="custom-file">
										<input name="flealumniimg" type="file" class="form-control" id="flealumniimg" maxlength="250">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Link</label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="txtlnk" id="txtlnk" size="45" maxlength="250" class="form-control">
								</div>
							</div>
						</div>
                        <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Batch</label>
								</div>
								<div class="col-sm-9">
									<input type="text" placeholder="BE 2005, Civil" name="txtbatch" id="txtbatch" size="45" maxlength="250" class="form-control">
                                    <span id="errorsDiv_txtbatch"></span>
								</div>
							</div>
						</div>
                        <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Job</label>
								</div>
								<div class="col-sm-9">
									<input type="text" placeholder="Actor,Software.." name="txtjob" id="txtjob" size="45" maxlength="250" class="form-control">
                                    <span id="errorsDiv_txtjob"></span>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Rank *</label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="txtprior" id="txtprior" class="form-control" size="4" maxlength="3">
									<span id="errorsDiv_txtprior"></span>
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
						<p class="text-center">
							<input type="Submit" class="btn btn-primary" name="btnalumnisbmt" id="btnalumnisbmt" value="Submit">
							&nbsp;&nbsp;&nbsp;
							<input type="reset" class="btn btn-primary" name="btnalumnireset" value="Clear" id="btnalumnireset">
							&nbsp;&nbsp;&nbsp;
							<input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm ;?>'">
						</p>
					</div>
				</div>
			</form>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</section>
<?php include_once "../includes/inc_adm_footer.php";?>
<script language="javascript" type="text/javascript">
	CKEDITOR.replace('txtdesc');
</script>