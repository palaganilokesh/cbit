<?php
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once "../includes/inc_connection.php";//Making database Connection
	include_once "../includes/inc_usr_functions.php";//Making database Connection
	include_once  "../includes/inc_config.php";
	include_once '../includes/inc_folder_path.php';	
	/***************************************************************
	Programm 	  : edit_prod_dtl.php	
	Purpose 	  : For Edit Product Details
	Created By    : Kiran N
	Created On    :	4th May 2013
	Modified By   : 
	Modified On   :
	Purpose 	  : 
	Company 	  : Adroit
	************************************************************/
	global $id,$pg,$countstart;
	if(isset($_POST['btnedtprod']) && (trim($_POST['btnedtprod']) != "") && 	
	   isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
	   isset($_POST['lstprodcat']) && (trim($_POST['lstprodcat']) != "") &&
	   isset($_POST['hdnid']) && (trim($_POST['hdnid']) != "") && 
	   isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "")){
		
		include_once "../includes/inc_fnct_fleupld.php"; // For uploading files	
		include_once "../database/uqry_prod_mst.php";
		
	}
	if(isset($_REQUEST['vw']) && (trim($_REQUEST['vw'])!="") &&
	   isset($_REQUEST['pg']) && (trim($_REQUEST['pg'])!="") &&
	   isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart'])!="")){
		$id = glb_func_chkvl($_REQUEST['vw']);
		$pg = glb_func_chkvl($_REQUEST['pg']);
		$cntstrt = glb_func_chkvl($_REQUEST['countstart']);
		$loc= "vw=$id&pg=$pg&countstart=$cntstrt";
		$srchval = glb_func_chkvl($_REQUEST['val']);
		$chk = glb_func_chkvl($_REQUEST['chk']);
		$optn = glb_func_chkvl($_REQUEST['optn']);
		if($srchval!=""){
			$loc .= "&val=$srchval&chk=$chk&optn=$optn";
		}
	}
	elseif(isset($_POST['hdnid']) && (trim($_POST['hdnid'])!="") &&
		isset($_POST['hdnpage']) && (trim($_POST['hdnpage'])!="") &&
		isset($_POST['hdncnt']) && (trim($_POST['hdncnt'])!="")){
	  	   
		$id  = glb_func_chkvl($_POST['hdnid']);
		$pg  = glb_func_chkvl($_POST['hdnpage']);
		$cntstrt = glb_func_chkvl($_POST['hdncnt']);
		$loc = "vw=$id&pg=$pg&countstart=$cntstrt";
		$srchval = glb_func_chkvl($_POST['hdnval']);
		$chk = glb_func_chkvl($_POST['hdnchk']);
		$optn = glb_func_chkvl($_POST['hdnoptn']);
	    if($srchval != ""){
			$loc .= "&val=$srchval&chk=$chk&optn=$optn";
		}
	}
	else{
		header("Location:products.php");
			exit();
	}
	$sqryprod_mst="select
							prodm_id,prodm_name,prodm_desc,prodm_prodcatm_id,
							prodm_prodscatm_id,prodm_sts,prodm_seotitle,prodm_seodesc,
							prodm_seokywrd,prodm_prty
						from 
							prod_mst
						where
							prodm_id=$id";
	$srsprod_mst  = mysqli_query($conn,$sqryprod_mst);
	//$cntrecprod_mst = mysqli_num_rows($srsprod_mst);
	//if($cntrecprod_mst  > 0){
		$rowsprod_mst = mysqli_fetch_assoc($srsprod_mst);
		
	/*}
	else{
		header("Location:products.php");
		exit();
	}*/
	if(isset($_REQUEST['imgid']) && (trim($_REQUEST['imgid']) != "") && 	
	   isset($_REQUEST['vw']) && (trim($_REQUEST['vw']) != "") ){
	   
		$imgid         = glb_func_chkvl($_REQUEST['imgid']);
		$prodid         = glb_func_chkvl($_REQUEST['edit']);	   
		$pg         = glb_func_chkvl($_REQUEST['pg']);
		$countstart = glb_func_chkvl($_REQUEST['countstart']);
		
	   $sqryprodimgd_dtl="select 
							   prodimgd_img
							from 
							   prodimg_dtl
							where
								prodimgd_prodm_id='$prodid'  and
								prodimgd_id = '$imgid'";				 				 				 				 			
			     $srsprodimgd_dtl     = mysqli_query($conn,$sqryprodimgd_dtl);
			     $srowprodimgd_dtl    = mysqli_fetch_assoc($srsprodimgd_dtl);		     			   				
		         $smlimg[$i]      = glb_func_chkvl($srowprodimgd_dtl['prodimgd_img']);
		       	 $smlimgpth[$i]   = $a_phtgalspath.$smlimg[$i];
				$delimgsts = funcDelAllRec($conn,'prodimg_dtl','prodimgd_id',$imgid);
				if($delimgsts == 'y'  ){
				 if(($smlimg[$i] != "") && file_exists($smlimgpth[$i])) {
						unlink($smlimgpth[$i]);
				 }			
			}
  	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="docstyle.css" rel="stylesheet" type="text/css">
<link href="yav-style.css" type="text/css" rel="stylesheet">
<title><?php echo $pgtl; ?></title>
    <script language="JavaScript" type="text/javascript" src="wysiwyg.js"></script>
    <script language="javascript" src="../includes/yav.js"></script>
	<script language="javascript" src="../includes/yav-config.js"></script>	
	<script language="javascript" src="../includes/js/util.js"></script>
	<script language="javascript" type="text/javascript">
    	var rules=new Array();
    	rules[0]='txtname:Name|required|Enter Name';
		rules[1]='txtprior:Priority|required|Enter Priority';
		rules[2]='txtprior:Priority|numeric|Enter Only Numbers';
	</script>
	<script language="javascript">	
		function setfocus(){
			document.getElementById('lstprodcat').focus();
			/* funcDspdropdwn('selpcatid','lstprodcat','lstprodscat');
			document.getElementById('lstprodcat').value = "<?php echo $rowsprod_mst['prodm_prodcatm_id'];?>"; */
		}
	</script>
	<?php
	include_once ('../includes/inc_fnct_ajax_validation.php');	
?>
<script language="javascript" type="text/javascript">
//**************************************************
//Function for removing options from select control
//**************************************************	
function funcRmvOptn(prmtrCntrlnm)
{			
	if(prmtrCntrlnm!= '')
	{			
		var lstCntrlNm, optnLngth;
		lstCntrlNm = prmtrCntrlnm;
		optnLngth = document.getElementById(lstCntrlNm).options.length;
		for(incrmnt = optnLngth-1; incrmnt > 0; incrmnt--){
			document.getElementById(lstCntrlNm).options.remove(incrmnt);
		}
	}
}
//**************************************************
//Function for adding options from select control
//**************************************************			
function funcAddOptn(prmtrCntrlnm,prmtrOptn){
	tempary 	= Array();
	tempary	 	= prmtrOptn.split(",");						
	cntrlary  	= 0;
	var id 	  	= "";
	var name  	= "";
	var selstr 	= "";
	var optn   	= "";	
	for(var inc = 0; inc < (tempary.length); inc++){
		cntryary 	= tempary[inc].split(":");
		id 		 	= cntryary[0];
		name 	 	= cntryary[1];
		optn 	 	= document.createElement("OPTION");					
		optn.value 	= id;					
		optn.text 	= name;
		var newopt	= new Option(name,id);
		document.getElementById(prmtrCntrlnm).options[inc+1] = newopt;
	}		
}	
//**************************************************		
function funcDspdropdwn(reqstnm, idcntrl, cntrltochng){       
	var id;
	id = document.getElementById(idcntrl).value;			
	if(id != ""){
		var url = "chkvalidname.php?cntrlnm="+cntrltochng+"&"+reqstnm+"="+id;
		xmlHttp	= GetXmlHttpObject(funval);
		xmlHttp.open("GET", url , true);
		xmlHttp.send(null);
	}
	else{
		funcRmvOptn(cntrltochng);				
	}
}	
function funval(){ 	
	if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
		var temp = xmlHttp.responseText;
		var temparry=temp.split('<->');
		funcRmvOptn(temparry[1]);
		if(temparry[0] != ""){
			funcAddOptn(temparry[1], temparry[0]);
		}			
	}
}
</script>
<script language="javascript" type="text/javascript">
function funcChkDupName(){
	var catid,name;
	name = document.getElementById('txtname').value;
	catid= document.getElementById('lstprodcat').value;
	var id = "<?php echo $id;?>";
	if(name != "" && catid!="" && id!=""){
		var url = "chkvalidname.php?value="+name+","+catid+","+id+"&tblnm=prod_mst&colnm=prodm_name,prodm_prodcatm_id,prodm_id&idset=yes";
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
		else
		  {
			  return false;
		  }	
	}
		document.frmedtprod.action="edit_prod_dtl.php?vw=<?php echo $id;?>&imgid="+img_id+"&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$loc;?>" 
		document.frmedtprod.submit();	
	}
</script>
</head>
<body onload="setfocus()">
<?php 
	include_once ('../includes/inc_adm_header.php');
	include_once ('../includes/inc_adm_toplinks.php');	
?>
<table width="977"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="7" height="30" valign="top" background="images/left_box_left_line.gif"><img src="images/content_corow_top_l.gif" width="7" height="8"></td>
        <td  height="325" rowspan="2" valign="top" background="images/content_topbg.gif" bgcolor="#FFFFFF" class="contentpadding" style="background-position:top; background-repeat:repeat-x; ">
		<span class="maintitles"><font color="#660000">Edit Products</font></span><br>
          <br>
	<form name="frmedtprod" id="frmedtprod" method="POST" action="<?php $_SERVER['PHP_SELF'];?>"  enctype="multipart/form-data"
	   onSubmit="return performCheck('frmedtprod', rules, 'inline');" >	   
		<table width="95%"  border="0" cellspacing="1" cellpadding="3">
	<input type="hidden" name="hdnid"   value="<?php echo $id;?>"/>
	<input type="hidden" name="hdnpage" value="<?php echo $pg;?>"/>
	<input type="hidden" name="hdncnt"  value="<?php echo $cntstrt;?>"/>
	<input type="hidden" name="hdnval"  value="<?php echo $srchval;?>"/>
	<input type="hidden" name="hdnoptn" value="<?php echo $optn;?>"/>
	<input type="hidden" name="hdnchk"  value="<?php echo $chk;?>"/>
	
   
	<tr bgcolor="#FFFFFF">
		<td width="13%" height="19" valign="middle" bgcolor="#E7F3F7"><strong>Category</strong> </td>
		<td width="2%" bgcolor="#E7F3F7"><strong>:</strong></td> 
		<td width="42%" align="left" valign="middle" bgcolor="#E7F3F7">
			<select id="lstprodcat" name="lstprodcat" onchange="funcDspdropdwn('selpcatid','lstprodcat','lstprodscat');" onblur="funcChkDupName();">
				<option value="">---Select Category---</option>
				<?php
					$sqryprodcat = "select 
										prodcatm_id,prodcatm_name
									from 
										prodcat_mst
									where 
										prodcatm_sts='a'
									order by prodcatm_name";
					$srsprodcat  = mysqli_query($conn,$sqryprodcat);
					$prodcatrcnt = mysqli_num_rows($srsprodcat);
					if($prodcatrcnt > 0){
						$dispsoptns="";
						while($rwprodcat = mysqli_fetch_assoc($srsprodcat)){
							$selected = "";
							if($rwprodcat['prodcatm_id'] == $rowsprod_mst['prodm_prodcatm_id']){
								$selected="selected";
							}
							$dispsoptns .= "<option value='$rwprodcat[prodcatm_id]' $selected>$rwprodcat[prodcatm_name]</option>";
						}
						echo $dispsoptns;
					}
				?>
			</select>
		</td>
       <td width="43%" align="left" valign="middle" bgcolor="#E7F3F7" style="color:#FF0000">
			<span id="errorsDiv_lstprodcat"></span></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td width="13%" height="19" valign="middle" bgcolor="#E7F3F7"><strong>Subcategory</strong> </td>
		<td width="2%" bgcolor="#E7F3F7"><strong>:</strong></td> 
		<td width="42%" align="left" valign="middle" bgcolor="#E7F3F7" colspan="2">
			<select id="lstprodscat" name="lstprodscat">
			<option value="">--Select Subcategory--</option>
			<?php
					$sqryprodscat = "select 
										prodscatm_id,prodscatm_name
									from 
										prodscat_mst
									where 
										prodscatm_sts='a'
									order by prodscatm_name";
					$srsprodscat  = mysqli_query($conn,$sqryprodscat);
					$prodscatrcnt = mysqli_num_rows($srsprodscat);
					if($prodscatrcnt > 0){
						$dispsoptns="";
						while($rwprodscat = mysqli_fetch_assoc($srsprodscat)){
							$selected = "";
							if($rwprodscat['prodscatm_id'] == $rowsprod_mst['prodm_prodscatm_id']){
								$selected="selected";
							}
							$dispsoptns .= "<option value='$rwprodscat[prodscatm_id]' $selected>$rwprodscat[prodscatm_name]</option>";
						}
						echo $dispsoptns;
					}
				?>
			</select>
			</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td width="13%" height="19" valign="middle" bgcolor="#E7F3F7"><strong>Name*</strong> </td>
		<td width="2%" bgcolor="#E7F3F7"><strong>:</strong></td> 
		<td width="42%" align="left" valign="middle" bgcolor="#E7F3F7">
			<input name="txtname" type="text" class="select" id="txtname" size="45" maxlength="240" onBlur="funcChkDupName()" value="<?php echo $rowsprod_mst['prodm_name'];?>">
		</td>
       <td width="43%" align="left" valign="middle" bgcolor="#E7F3F7" style="color:#FF0000">
			<span id="errorsDiv_txtname"></span></td>
	</tr>			  
	<tr bgcolor="#FFFFFF">
		<td valign="top" bgcolor="#E7F3F7"><strong>Description</strong></td>
		<td align="center" valign="top" bgcolor="#E7F3F7"><strong>:</strong></td>
		<td colspan="2" align="left" valign="middle" bgcolor="#E7F3F7"><textarea name="txtdesc" cols="60" rows="15" class="select" id="txtdesc"><?php echo $rowsprod_mst['prodm_desc'];?></textarea></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td bgcolor="#E7F3F7"> <strong>SEO Title</strong>  </td>
		<td bgcolor="#E7F3F7"><strong>:</strong></td>
		<td bgcolor="#E7F3F7" colspan="2">
			<input type="text" name="txtseotitle" id="txtseotitle" class="select" size="45" maxlength="250" value="<?php echo $rowsprod_mst['prodm_seotitle'];?>">	</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td bgcolor="#E7F3F7"> <strong>SEO Description</strong>  </td>
		<td bgcolor="#E7F3F7"><strong>:</strong></td>
		<td bgcolor="#E7F3F7" colspan="2">
			<textarea name="txtseodesc" rows="10" cols="60" class="" id="txtseodesc"><?php echo $rowsprod_mst['prodm_seodesc'];?></textarea>
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td bgcolor="#E7F3F7"> <strong>SEO Keyword</strong> </td>
		<td bgcolor="#E7F3F7"><strong>:</strong></td>
		<td bgcolor="#E7F3F7" colspan="2">
			<textarea name="txtseokywrd" rows="5" cols="60" class="" id="txtseokywrd"><?php echo $rowsprod_mst['prodm_seokywrd'];?></textarea>
		</td>
	</tr>
   <tr bgcolor="#FFFFFF">
		<td bgcolor="#E7F3F7" > <strong>Priority *</strong> </td>
		<td bgcolor="#E7F3F7"><strong>:</strong></td>
		<td bgcolor="#E7F3F7">
		<input type="text" name="txtprior" id="txtprior" class="select" size="4" maxlength="3" value="<?php echo $rowsprod_mst['prodm_prty'];?>"/>	</td>
		<td bgcolor="#E7F3F7" style="color:#FF0000"><span id="errorsDiv_txtprior"></span></td>
    </tr>	   
    <tr bgcolor="#FFFFFF">
		<td width="13%" height="19" valign="middle" bgcolor="#E7F3F7"><strong>Status</strong></td>
		<td bgcolor="#E7F3F7"><strong>:</strong></td>
		<td width="42%" align="left" valign="middle" bgcolor="#E7F3F7">					
		<select name="lststs" id="lststs">
		<option value="a" <?php if($rowsprod_mst['prodm_sts'] == 'a') echo "selected";?>>Active</option>
		<option value="i" <?php if($rowsprod_mst['prodm_sts'] == 'i') echo "selected";?>>Inactive</option>
		</select></td>
		<td width="43%" align="left" valign="middle" bgcolor="#E7F3F7">&nbsp;</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td colspan="5">
		<table width="100%" border="0" cellspacing="1" cellpadding="3">
	<tr>
			<td width="5%"  bgcolor="#E7F3F7"><strong>SL.No.</strong></td>
			<td width="10%" bgcolor="#E7F3F7"><strong>Name</strong></td>
			<td width="45%" bgcolor="#E7F3F7" align='center' colspan='2'><strong>Image</strong></td>
			<td width="20%" bgcolor="#E7F3F7" ><strong>Priorty</strong></td>
			<td width="10%"  bgcolor="#E7F3F7"><strong>Status</strong></td>
			<td width="10%"  bgcolor="#E7F3F7"><strong>Remove</strong></td>
		  </tr>
			<?php
			$sqryimg_dtl="select 
							prodimgd_id,prodimgd_name,prodimgd_prodm_id,prodimgd_img,
							prodimgd_prty,if(prodimgd_sts = 'a', 'Active','Inactive') as prodimgd_sts
						 from 
							  prodimg_dtl
						 where 
							 prodimgd_sts='a'  and
							 prodimgd_prodm_id ='$id' 
						 order by 
							 prodimgd_id";
			$srsimg_dtl	= mysqli_query($conn,$sqryimg_dtl);		
			$cntprodimg_dtl  = mysqli_num_rows($srsimg_dtl);
			$nfiles = "";
			if($cntprodimg_dtl> 0 ){
			?>
			<?php				
			while($rowsprodimgd_mdtl=mysqli_fetch_assoc($srsimg_dtl))
			{
				$prodimgdid = $rowsprodimgd_mdtl['prodimgd_id'];
				$imgnm = $rowsprodimgd_mdtl['prodimgd_img'];
				$imgpath = $a_phtgalspath.$imgnm;
				$nfiles+=1;
				$clrnm = "";
				if($cnt%2==0){
					$clrnm = "bgcolor='#E7F3F7'";
				}
				else{
					$clrnm = "bgcolor='#E7F3F7'";
				}
		  ?>
		  <tr bgcolor="#FFFFFF">
					<td colspan="7" align="center" bgcolor="#E7F3F7">
						<table width="100%" border="0" cellspacing="1" cellpadding="1">								
						<input type="hidden" name="hdnproddid<?php echo $nfiles?>" class="select" value="<?php echo $prodimgdid;?>">
							<tr bgcolor="#FFFFFF">
							<td bgcolor="#E7F3F7" width='5%' ><?php echo  $nfiles;?></td>
							<td bgcolor="#E7F3F7" width='10%' align='center'>
							<input type="text" name="txtphtname1<?php echo $nfiles?>" id="txtphtname1<?php echo $nfiles?>" value='<?php echo  $rowsprodimgd_mdtl['prodimgd_name']?>' class="select" size="10">
					</td>
							<td bgcolor="#E7F3F7"  align="right" width='35%'><input type="file" name="flesmlimg<?php echo $nfiles?>" class="select" id="flesmlimg" >
							</td>
							<td bgcolor="#E7F3F7"  align="center" width='10%'>
							<?php						   
								  if(($imgnm !="") && file_exists($imgpath)){
										 echo "<img src='$imgpath' width='30pixel' height='30pixel'>";
								  }
								  else{
									 echo "No Image";
								  }
							  ?>
							
							<span id="errorsDiv_flesmlimg1"></span></td>
							<td bgcolor="#E7F3F7" width='20%' align="center" >
						   <input type="text" name="txtphtprior<?php echo $nfiles?>" id="txtphtprior1" class="select" value="<?php echo $rowsprodimgd_mdtl['prodimgd_prty'];?>" size="4" maxlength="3"><span id="errorsDiv_txtphtprior1"></span></td>
					
							<td  valign="middle" bgcolor="#E7F3F7" width='10%' >					
							<select name="lstphtsts<?php echo $nfiles?>" id="lstphtsts<?php echo $nfiles?>">
								<option value="a" <?php if($rowsprodimgd_mdtl['prodimgd_sts']=='a') echo 'selected'; ?>>Active</option>
								<option value="i" <?php if($rowsprodimgd_mdtl['prodimgd_sts']=='i') echo 'selected'; ?>>Inactive</option>
							</select></td>
							<td bgcolor="#E7F3F7" width='10%'><input type="button"  name="btnrmv" 
							 value="REMOVE"  onClick="rmvimg('<?php echo $prodimgdid; ?>')"></td>
						</table>
					</td>			
				</tr>
		  <?php
			}
			}
			else{
				echo "<tr bgcolor='#FFFFFF'><td colspan='7' align='center' bgcolor='#E7F3F7'>Image not available</td></tr>";
			}
			?>
				<tr bgcolor="#FFFFFF">
				<td colspan="6" align="center" bgcolor="#E7F3F7">
				<?php echo $str_tab; ?>
					<div id="myDiv">						
					  <table width="100%">						  
						<input type="hidden" name="hdntotcntrl" id="hdntotcntrl" value="<?php echo $nfiles;?>">					  
						<tr>
							<td align="center">
							<input name="btnadd" type="button" onClick="expand()" value="Add Another Image" class="subtitles">												                                </td>
						</tr>
						<tr>
							<td align="center">
							<span id="errorsDiv_hdntotcntrl"></span></td>
						</tr>
					</table>
					</div>
				</td>
				<td align="center" bgcolor="#E7F3F7"></td>
			</tr>
			</table>
			</td>
			</tr>			 
	<?php
			 if($gmsg != ""){			 
					echo "<tr bgcolor='#FFFFFF'>
							<td align='center' valign='middle' bgcolor='#E7F3F7' colspan='4' >
								<font face='Arial' size='2' color = 'red'>
									$gmsg
								</font>							
							</td>
			  			</tr>";
				}	
		 ?>		
		<tr valign="middle" bgcolor="#FFFFFF">
		<td colspan="4" align="center" bgcolor="#E7F3F7">
		<input type="Submit" class="textfeild"  name="btnedtprod" id="btnedtprod" value="Update" >
		&nbsp;&nbsp;&nbsp;
		<input type="button" class="textfeild"  name="btnrst" value="Reset" id="btnrst" onclick="location.href='edit_prod_dtl.php?<?php echo $loc;?>'">
		&nbsp;&nbsp;&nbsp;
		<input type="button"  name="btnBack" value="Back" class="textfeild" onclick="location.href='view_prod_dtl.php?<?php echo $loc;?>'"></td>
		</tr>

        </table>
        </td>
        <td width="6" valign="top" background="images/content_right_line.gif">
		<img src="images/content_corow_top_r.gif" width="6" height="8"></td>
        </tr>		
		<tr>
        <td background="images/left_box_left_line.gif">&nbsp;</td>
        <td background="images/content_right_line.gif"></td>
        </tr>
		<tr>
        <td><img src="images/content_footer_l.gif" width="7" height="56"></td>
        <td align="right" background="images/content_footer_bg.gif">&nbsp;</td>
        <td><img src="images/content_footer_r.gif" width="6" height="56"></td>
        </tr>
        </table>
</td>
</tr>
</table>	
</form>
<?php include_once '../includes/inc_adm_footer.php';?>
</body>
</html>
<script language="javascript" type="text/javascript">
	generate_wysiwyg('txtdesc');
</script>
<script language="javascript" type="text/javascript">
/********************Multiple Image Upload********************************/
	  var nfiles ="<?php echo $nfiles;?>";
	   function expand () {	   		
			nfiles ++;
            var htmlTxt = '<?php
					echo "<table width=100%  border=0 cellspacing=1 cellpadding=1 >"; 
					echo "<tr>";
					echo "<td align=left width=5%>";
					echo "<span class=buylinks> ' + nfiles + '</span></td>";
					echo "<td  width=10% align=center>";
					echo "<input type=text name=txtphtname1' + nfiles + ' id=txtphtname1' + nfiles + ' class=select size=10><br>";
					echo "<td align=center width=45% colspan=2>";
					echo "<input type=file name=flesmlimg' + nfiles + ' id=flesmlimg' + nfiles + ' class=select><br>";
					echo "<td align=center width=20%>";
					echo "<input type=text name=txtphtprior' + nfiles + ' id=txtphtprior' + nfiles + ' class=select size=4 maxlength=3>";
					echo "</td>"; 
					echo "<td  width=10% align=center colspan=2>";
					echo "<select name=lstphtsts' + nfiles + ' id=lstphtsts' + nfiles + ' class=select>";
					echo "<option value=a>Active</option>";
					echo "<option value=i>Inactive</option>";
					echo "</select>";
					echo "</td></tr></table><br>";			
				?>';			
            var Cntnt = document.getElementById ("myDiv");
			
			if (document.createRange) {//all browsers, except IE before version 9 
				
			 var rangeObj = document.createRange ();
			 	Cntnt.insertAdjacentHTML('BeforeBegin' , htmlTxt);
				document.frmedtprod.hdntotcntrl.value = nfiles;	
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
			document.frmedtprod.hdntotcntrl.value = nfiles;
        }		
</script>