<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/**********************************************************
Programm : add_product_subcategory.php 
Purpose : For add Sub Category
Created By : Bharath
Created On : 20-01-2022
Modified By : 
Modified On : 
Purpose : 
Company : Adroit
************************************************************/ 
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Product Group";
$pagenm = "Subcategory";
/*****header link********/
global $gmsg;	
if(isset($_POST['btnprodscatsbmt']) && (trim($_POST['btnprodscatsbmt']) != "") && isset($_POST['lstprodmcat']) && (trim($_POST['lstprodmcat']) != "") && isset($_POST['lstprodcat']) && (trim($_POST['lstprodcat']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	include_once "../includes/inc_fnct_fleupld.php"; // For uploading files
	include_once "../database/iqry_prodsubcat_mst.php";
}
$rd_crntpgnm = "view_product_subcategory.php";
$clspn_val   = "4";
?>
<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>	
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
 	var rules=new Array();
	rules[0]='txtname:Name|required|Enter Name';
	rules[1]='lstprodmcat:Main Category|required|Select Main Category';
	rules[2]='lstprodcat:Category|required|Select Category';
	rules[3]='txtprior:Priority|required|Enter Rank';
	rules[4]='txtprior:Priority|numeric|Enter Only Numbers';
	function setfocus()
	{
		document.getElementById('lstprodmcat').focus();
	}
</script>
<?php 
include_once ('script.php');
include_once ('../includes/inc_fnct_ajax_validation.php');	
?>
<script language="javascript" type="text/javascript">
	function funcChkDupName()
	{ 
		var name = document.getElementById('txtname').value;//name for sub category
		var prodmncatid = document.getElementById('lstprodmcat').value;//main link id
		var prodcatid = document.getElementById('lstprodcat').value;//category id
		if(prodmncatid != "" && prodcatid != "" && name != "")
		{
			var url = "chkduplicate.php?prodscatname="+name+"&prodmncatid="+prodmncatid+"&prodcatid="+prodcatid;
			xmlHttp	= GetXmlHttpObject(stateChanged);
			xmlHttp.open("GET", url, true);
			xmlHttp.send(null);
		}
		else
		{
			document.getElementById('errorsDiv_lstprodmcat').innerHTML="";
			document.getElementById('errorsDiv_lstprodcat').innerHTML="";
			document.getElementById('errorsDiv_txtname').innerHTML = "";
		}	
	}
	function stateChanged()
	{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			var temp=xmlHttp.responseText;
			document.getElementById("errorsDiv_txtname").innerHTML = temp;
			if(temp!=0)
			{
				document.getElementById('txtname').focus();
			}
		}
	}
	function get_cat()
  {
  	var mncatval = $("#lstprodmcat").val();
  	$.ajax({
  		type: "POST",
  		url: "../includes/inc_getStsk.php",
  		data:'mncatval='+mncatval,
  		success: function(data){
  			// alert(data)
  			$("#lstprodcat").html(data);
  		}
  	});
  }
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Sub Category</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Add Sub Category</li>
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
			<form name="frmaddprodscat" id="frmaddprodscat" method="post" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" onSubmit="return performCheck('frmaddprodscat', rules, 'inline');">
				<div class="col-md-12">
					<div class="row justify-content-center align-items-center">
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Main Link *</label>
								</div>
								<div class="col-sm-9">
									<?php
									$sqryprodmncat_mst = "select 
									prodmnlnksm_id,prodmnlnksm_name						
							  		 from 
									prodmnlnks_mst 
							  		 where	 
									prodmnlnksm_sts = 'a'
									order by
								   	prodmnlnksm_name";
									$rsprodmncat_mst = mysqli_query($conn,$sqryprodmncat_mst);
									$cnt_prodmncat = mysqli_num_rows($rsprodmncat_mst);	
									?>
									<select name="lstprodmcat" id="lstprodmcat" class="form-control" onchange="get_cat();">
										<option value="">--Select Main Link--</option>
										<?php
										if($cnt_prodmncat > 0)
										{
											while($rowsprodmncat_mst=mysqli_fetch_assoc($rsprodmncat_mst))
											{
												$mncatid = $rowsprodmncat_mst['prodmnlnksm_id'];
												$mncatname = $rowsprodmncat_mst['prodmnlnksm_name'];
												?>
												<option value="<?php echo $mncatid;?>"><?php echo $mncatname;?></option>
												<?php
											}
										}
										?>
									</select>
									<span id="errorsDiv_lstprodmcat"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Category *</label>
								</div>
								<div class="col-sm-9">
									<?php
									$sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name from prodcat_mst order by prodcatm_name";
									$rsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
									$cnt_prodcat = mysqli_num_rows($rsprodcat_mst);	
									?>
									<select name="lstprodcat" id="lstprodcat" class="form-control">
										<option value="">--Select Category--</option>
										<!-- <?php
										if( $cnt_prodcat > 0)
										{
											while($rowsprodcat_mst=mysqli_fetch_assoc($rsprodcat_mst))
											{
												$catid = $rowsprodcat_mst['prodcatm_id'];
												$catname = $rowsprodcat_mst['prodcatm_name'];
												?>
												<option value="<?php echo $catid;?>"><?php echo $catname;?></option>
												<?php
											}
										}
										?> -->
									</select>
									<span id="errorsDiv_lstprodcat"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Name *</label>
								</div>
								<div class="col-sm-9">
									<input name="txtname" type="text" id="txtname" size="45" maxlength="40" onBlur="funcChkDupName()" class="form-control">
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
									<label>Baner Image</label>
								</div>
								<div class="col-sm-9">
									<div class="custom-file">
										<input name="flescatimg" type="file" id="flescatimg" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Status</label>
								</div>
								<div class="col-sm-9">
									<select name="lsttyp" id="lsttyp" class="form-control">
									<option value="1" selected>Page Content</option>
									<option value="2">Photo Gallery</option>
									<option value="3">Video Gallery</option>
									<option value="4">Link</option>  
									</select>
									
								</div>
							</div>
						</div>
					
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Department Title</label>
								</div>
								<div class="col-sm-9">
									<div class="custom-file">
										<input name="txtdpttitle" type="text" id="txtdpttitle" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Head of the Department Name</label>
								</div>
								<div class="col-sm-9">
									<div class="custom-file">
										<input name="txtdpthednm" type="text" id="txtdpthednm" class="form-control" >
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label> Department Name (branch)</label>
								</div>
								<div class="col-sm-9">
									<div class="custom-file">
										<input name="txtdptnm" type="text" id="txtdptnm" class="form-control" >
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO Title</label>
								</div>
								<div class="col-sm-9"> 
									<input type="text" name="txtseotitle" id="txtseotitle" size="45" maxlength="250" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO Description</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseodesc" rows="3" cols="60" id="txtseodesc" class="form-control"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO Keyword</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseokywrd" rows="3" cols="60" id="txtseokywrd" class="form-control"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO H1 </label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="txtseohone" id="txtseohone" size="45" maxlength="250" class="form-control">
								</div>
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO H2 </label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="txtseohtwo" id="txtseohtwo" size="45" maxlength="250" class="form-control">
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
							<input type="Submit" class="btn btn-primary" name="btnprodscatsbmt" id="btnprodscatsbmt" value="Submit">
							&nbsp;&nbsp;&nbsp;
							<input type="reset" class="btn btn-primary" name="btnprodscatreset" value="Clear" id="btnprodscatreset">
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