<?php
error_reporting(0);
	  include_once '../includes/inc_config.php';       //Making paging validation	
	  include_once $inc_nocache;        //Clearing the cache information
	  include_once $adm_session;    //checking for session
	  include_once $inc_cnctn;     //Making database Connection
	  include_once $inc_usr_fnctn;  //checking for session	
	  include_once $inc_fldr_pth;//Floder Path	
	global $rowsphtcat_mst; 
	/**************************************/
	//Programm 	  : edit_photos.php	
	//Company 	  : Adroit
	/**************************************/
  /*****header link********/
$pagemncat = "Gallery";
$pagecat = "Photos";
$pagenm = "Photos";
/*****header link********/
	global $id,$pg,$cntstart,$loc,$a_phtgalspath1,$rd_crntpgnm,$rd_vwpgnm,$clspn_val;	

	$rd_crntpgnm = "edit_photogallery.php";
	$rd_vwpgnm   = "view_detail_photogallery.php";
	$clspn_val   = "4";	
	if(isset($_POST['btnedtpht']) && (trim($_POST['btnedtpht']) != "")){
   
		 include_once '../includes/inc_fnct_fleupld.php'; // For uploading files	
		 include_once '../database/uqry_pht_mst.php';
		
	}
	
		$id         = glb_func_chkvl($_REQUEST['vw']);
		$pg         = glb_func_chkvl($_REQUEST['pg']);
		$cntstart	= glb_func_chkvl($_REQUEST['countstart']);
		$val  		= glb_func_chkvl($_REQUEST['txtsrchval']);
		if($val !=''){
			
			$loc .= "&txtsrchval=$val";
		}
		$chk  		=  glb_func_chkvl($_REQUEST['chkexact']); 
		if($chk!= ""){
			$loc .= "&chkexact=$chk";
		}	
	//  $sqryphtcat_mst="SELECT 
	// 						  phtd_id,phtd_name,phtd_desc,phtd_rank,phtd_sts,
	// 						  phtm_sts,phtcatm_name,phtcatm_id
   	// 					    from    pht_dtl
	// 	                inner join 
	// 		             phtcat_mst on phtcat_mst.phtcatm_id = pht_mst.phtm_phtcatm_id
	// 					    inner join 
	// 		             pht_mst on pht_dtl.phtd_id = pht_mst. 	phtm_phtd_id	
	// 				  	where 
	// 	                  phtm_phtd_id=$id";
	// 	$srsphtcat_mst  = mysqli_query($conn,$sqryphtcat_mst);
	// 	$cntrec =mysqli_num_rows($srsphtcat_mst);
	// 	if($cntrec > 0){
	// 		$rowsphtcat_mst1 = mysqli_fetch_assoc($srsphtcat_mst);
	// 	   }
		  	
	   $imgid      = glb_func_chkvl($_REQUEST['imgid']);	 
	   $pg         = glb_func_chkvl($_REQUEST['pg']);
	   $cntstart   = glb_func_chkvl($_REQUEST['countstart']);
	   
	  // $id         = glb_func_chkvl($_REQUEST['vw']);
	    $sqryprodimgd_dtl="select 
							   phtm_simg
						  from 
							   pht_mst
						  where
							   phtm_id = '$imgid'";				 				 			
		$srsprodimgd_dtl    	= mysqli_query($conn,$sqryprodimgd_dtl);
		$srowprodimgd_dtl    	= mysqli_fetch_assoc($srsprodimgd_dtl);
		$bimg      				= glb_func_chkvl($srowprodimgd_dtl['phtm_simg']);
		$bimgpth   				= $a_phtgalspath1.$bimg;
		
		$delimgsts 		= funcDelAllRec($conn,'pht_mst','phtm_id',$imgid);
		if($delimgsts == 'y'){		
		   if(($bimg != "")) {
					unlink($bimgpth);
		   }				
		}
  	//}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo $pgtl; ?></title>
   <script language="JavaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
   <script language="javascript" src="../includes/yav.js"></script>
	<script language="javascript" src="../includes/yav-config.js"></script>	
   <script language="javascript" type="text/javascript">
    	var rules=new Array();
    	rules[0]='txtname:Name|required|Enter Name';
    	rules[1]='txtprty:Rank|required|Enter Rank';
		rules[2]='txtprty:Rank|numeric|Enter Only Numbers';
	</script>
   <script language="javascript" type="text/javascript">
    function setfocus(){
			document.getElementById('txtname').focus();
	}
	function funcChkDupName(){
		var name;
		id 	 = <?php echo $id;?>;
		name = document.getElementById('txtname').value;		
		if((name != "") && (id != "")){
			var url = "chkvalidname.php?phtname="+name+"&phtid="+id;
			xmlHttp	= GetXmlHttpObject(stateChanged);
			xmlHttp.open("GET", url , true);
			xmlHttp.send(null);
		}
		else{
			document.getElementById('errorsDiv_txtname').innerHTML = "";
		}	
	}
	function stateChanged(){ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 	
			var temp=xmlHttp.responseText;
			document.getElementById("errorsDiv_txtname").innerHTML = temp;
			if(temp!=0){
				document.getElementById('txtname').focus();
			}		
		}
	}
	function rmvimg(imgid){	
		var img_id;
		img_id = imgid;
		if(img_id !=''){
			var r=window.confirm("Do You Want to Remove Image");
			if (r==true){						
				 x="You pressed OK!";
			  }
			else{
				  return false;
			  }	
		}
		document.frmedtpht.action="<?php echo $rd_crntpgnm;?>?vw=<?php echo $id;?>&imgid="+img_id+"&pg=<?php echo $pg;?>&countstart=				<?php echo $cntstart.$loc;?>" 
		document.frmedtpht.submit();	
	}			
	</script>
</head>
<body onLoad="setfocus();">
<?php 
	include_once $inc_adm_hdr;
	include_once $inc_adm_lftlnk;
?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit Photo Gallery</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Photo Gallery</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>




	  <form name="frmedtpht" id="frmedtpht" action="<?php $_SERVER['SCRIPT_FILENAME'];?>" method="post" onSubmit="return performCheck('frmedtpht', rules, 'inline');" enctype="multipart/form-data">

		  <input type="hidden" name="vw" id="vw" value="<?php echo $id;?>">
		  <input type="hidden" name="pg" id="pg" value="<?php echo $pg;?>">
		  <input type="hidden" name="countstart" id="countstart" value="<?php echo $cntstart?>">	 
		  <input type="hidden" name="val" id="val" value="<?php echo $val?>">	  	
		  <input type="hidden" name="chk" id="chk" value="<?php echo $chk?>">	
		   
           <?php 
          $sqryphtcat_mst="SELECT 
							  phtd_id,phtd_name,phtd_desc,phtd_rank,phtd_sts,phtd_phtcatm_id
   						    from    pht_dtl	where phtd_id=$id";
		$srsphtcat_mst  = mysqli_query($conn,$sqryphtcat_mst);
		$cntrec =mysqli_num_rows($srsphtcat_mst);
		if($cntrec > 0){
			$rowsphtcat_mst = mysqli_fetch_assoc($srsphtcat_mst);
			$cat_id=$rowsphtcat_mst['phtd_phtcatm_id'];

		}?>
    <div class="card">
			<div class="card-body">
				<div class="row justify-content-center">

        <div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Category *</label>
							</div>
							<div class="col-sm-9">
             <select name="lstphcat" id="lstphcat"  class="form-control">
                     <option value="">--select--</option>
					<?php
						$sqryphtcat_mst="select phtcatm_id,phtcatm_name
									     from phtcat_mst ";
										//  where phtcatm_id='$cat_id'
						 $srsphtcat_mst=mysqli_query($conn,$sqryphtcat_mst);
						 while($rwcat_mst=mysqli_fetch_assoc($srsphtcat_mst)){	  
							 $catid   =$rwcat_mst['phtcatm_id'];	  
							 $name    =$rwcat_mst['phtcatm_name'];
					 ?>
             <option value="<?php echo $catid;?>"<?php 
			 if($cat_id==$catid)echo 'selected';?>>
                   <?php echo $name;?></option>
                   <?php 
				   	 }	 
					?>
                    </select>

                    <span id="errorsDiv_lstphcat"></span>
							</div>
						</div>
					</div>
					

          <div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Name *</label>
							</div>
							<div class="col-sm-9">
              <input type="text" name="txtname" id="txtname" class="form-control" size="15"  value="<?php echo $rowsphtcat_mst['phtd_name'];?>">
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
								<textarea name="txtdesc" cols="60" rows="3" id="txtdesc"
									class="form-control"><?php echo $rowsphtcat_mst['phtd_desc'];?></textarea>
							</div>
						</div>
					</div>
          <div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Rank *</label>
							</div>
							<div class="col-sm-9">
              <input type="text" name="txtprty" id="txtprty" class="form-control" size="4" maxlength="3" value="<?php echo $rowsphtcat_mst['phtd_rank'];?>">
								
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
								
                <select name="lststs1" id="lststs" class="form-control">
				
        <option value="a"<?php if($rowsphtcat_mst['phtd_sts']=='a') echo 'selected';?>>Active</option>
				<option value="i"<?php if($rowsphtcat_mst['phtd_sts']=='i') echo 'selected';?>>Inactive</option>
					</select>
							</div>
						</div>
					</div>
          <div class="table-responsive">
						<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
							<tr bgcolor="#FFFFFF">
								<td width="5%" align="center"><strong>SL.No.</strong></td>
								<td width="21%" align="center"><strong>Name</strong></td>
								<td width="39%" align="center"><strong>Image</strong></td>
								<td width="10%" align="center"><strong>Rank</strong></td>
								<td width="10%" align="center"><strong>Status</strong></td>
								<td width="10%" align="center"><strong>Remove</strong></td>
							</tr>
						</table>
					</div>
        
        
  


   
	
				<?php
$sqryimg_dtl="SELECT phtm_id,phtm_simgnm,phtm_simg,phtm_sts,phtm_prty from pht_mst where phtm_phtd_id  ='$id'";
	            $srsimg_dtl	= mysqli_query($conn,$sqryimg_dtl);		
		        $cntphtimg_dtl  = mysqli_num_rows($srsimg_dtl);
			  	$nfiles = "";
				if($cntphtimg_dtl> 0 ){
				?>
				<?php				
			  	while($rowsphtimgd_mdtl=mysqli_fetch_assoc($srsimg_dtl)){
					$phtimgdid = $rowsphtimgd_mdtl['phtm_id'];
					$arytitle = explode("-",$rowsphtimgd_mdtl['phtm_simgnm']);
					$nfiles+=1;					
			  ?>
        	<div class="table-responsive">
								<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
									<table width="100%" border="0" cellspacing="3" cellpadding="3">
										<tr bgcolor="#FFFFFF">
						<input type="hidden" name="hdnbgimg<?php echo $nfiles?>" class="form-control" value="<?php echo $rowsphtimgd_mdtl['phtm_id'];?>">
			<input type="hidden" name="hdnproddid<?php echo $nfiles?>" class="form-control" value="<?php echo $phtimgdid;?>">		
     
					<td width='5%'> <?php echo $nfiles; ?>	</td>								              	   
        <td width="15%" align="left">
  <input type="text" name="txtphtname<?php echo $nfiles?>" id="txtphtname" value='<?php echo $rowsphtimgd_mdtl['phtm_simgnm']?>' class="form-control" size="30">
						</td>								
     	<td align="left" width="20%"><input type="file" name="flebgimg<?php echo $nfiles?>"  id="flebgimg" class="form-control" size="5">
						</td>
        <td align="left" width="19%">
							<?php
								 $bgimgnm = $rowsphtimgd_mdtl['phtm_simg'];
								  $bgimgpath = $a_phtgalspath1.$bgimgnm;								   
								  if(($bgimgnm !="")){
										 echo "<img src='$bgimgpath' width='30pixel' height='30pixel'>";
								  }
								  else{
									 echo "No Image";
								  }
							  ?>								
							<span id="errorsDiv_flesmlimg1"></span></td>

                        <td width="10%" align="left">
							   <input type="text" name="txtphtprior<?php echo $nfiles?>" id="txtphtprior" class="form-control" value="<?php echo $rowsphtimgd_mdtl['phtm_prty'];?>" size="4" maxlength="3"><span id="errorsDiv_txtphtprior"></span> 
						</td>            
                   	    <td align="left"  width="10%">		
							<select name="lstphtsts<?php echo $nfiles?>" id="lstphtsts" 	class="form-control">
							 <option value="a"<?php if($rowsphtimgd_mdtl['phtm_sts']=='a') echo 'selected';?>>Active</option>
							 <option value="i"<?php if($rowsphtimgd_mdtl['phtm_sts']=='i') echo 'selected';?>>Inactive</option>
							</select></td>

									
					<td width="10%"><input type="button"  name="btnrmv" 
						 value="REMOVE"  onClick="rmvimg('<?php echo $rowsphtimgd_mdtl['phtm_id']; ?>')"></td>			
             </tr>
									</table>
								</table>
              </div>
			  <?php
			  	}
				}
				else{
					echo "<tr bgcolor='#F2F1F1'><td colspan='9' align='center' >Image not available</td></tr>";
				}
				?>
        	<div id="myDiv">		
        <table width="100%" cellspacing='2' cellpadding='3'>
				<tr>
												<td align="center">
                        <input type="hidden" name="hdntotcntrl" id="hdntotcntrl" value="<?php echo $nfiles;?>">		
													<input name="btnadd" type="button" onClick="expand()" value="Add Another Image" class="btn btn-primary mb-3">
												</td>
											</tr>
                              
										</table>
									</div>
									</div>
								
 

                  <p class="text-center">
                  <input type="hidden" name="hidnid" id="hidnid" value="<?php echo $rowsphtimgd_mdtl['phtm_id'];?> ">  
										<input type="Submit" class="btn btn-primary btn-cst" name="btnedtpht" id="btnedtpht"
											value="Submit">
										&nbsp;&nbsp;&nbsp;
										<input type="reset" class="btn btn-primary btn-cst" name="btnReset" value="Clear"
											id="btnReset">
										&nbsp;&nbsp;&nbsp;
										<input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst"
                    onclick="location.href='view_all_photogallery.php?vw=<?php echo $id;?>&pg=<?php echo $pg."&countstart=".$cntstart.$loc;?>'">
									</p> 
									
          </div>
			</div>
			</div>
			</div>
	</form>
</section>
<?php include_once "../includes/inc_adm_footer.php"; ?>
<script language="javascript" type="text/javascript">
	CKEDITOR.replace('txtdesc');

</script>
<script language="javascript" type="text/javascript">
/********************Multiple Image Upload********************************/
	  var nfiles ="<?php echo $nfiles;?>";
	   function expand () {	   		
			nfiles ++;
            var htmlTxt = '<?php
				echo "<table width=100%  border=0 cellspacing=1 cellpadding=2>"; 
				echo "<tr>";
				echo "<td align=left width=4%>";
				echo "<span class=buylinks>' + nfiles + '</span></td>";
				echo "<td width=25% align=left>";
				echo "<input type=text name=txtphtname' + nfiles + ' id=txtphtname1' +  nfiles + ' class=form-control size=30></td>";
				//echo "<td align=left width=50 colspan=2>";
				//echo "<input type=file name=flesmlimg' + nfiles + ' id=flesmlimg' +                       nfiles + ' class=select size=10></td>";
				echo "<td align=left width=20%>";
				echo "<input type=file name=flebgimg' + nfiles + ' id=flebgimg1' +   nfiles + ' class=form-control size=5></td><td width=11% align=left></td>";
				echo "<td align=left width=9%>";
				echo "<input type=text name=txtphtprior' + nfiles + ' id=txtphtprior1'  + nfiles + ' class=form-control size=4 maxlength=3>";
				echo "</td>"; 
				echo "<td width=10% align=right>";
				echo "<select name=lstphtsts' + nfiles + ' id=lstphtsts1' + nfiles + '                     class=form-control>";
				echo "<option value=a>Active</option>";
				echo "<option value=i>Inactive</option>";
				echo "</select>";
				echo "</td><td></td></tr></table><br>";			
			?>';			
		 var Cntnt = document.getElementById ("myDiv");			
			if (document.createRange) {//all browsers, except IE before version 9 				
			 var rangeObj = document.createRange ();
			 	Cntnt.insertAdjacentHTML('BeforeBegin' , htmlTxt);
				document.frmedtpht.hdntotcntrl.value = nfiles;	
               if (rangeObj.createContextualFragment) { // all browsers, except IE	
			   		 	//var documentFragment = rangeObj.createContextualFragment (htmlTxt);
                 	 	//Cntnt.insertBefore (documentFragment, Cntnt.firstChild);	//Mozilla					 				
				}
                else{//Internet Explorer from version 9
                 	Cntnt.insertAdjacentHTML('BeforeBegin' , htmlTxt);
				}
			}			
			else{//Internet Explorer before version 9
                Cntnt.insertAdjacentHTML ("BeforeBegin", htmlTxt);
			}
			document.frmedtpht.hdntotcntrl.value = nfiles;
        }		
</script>