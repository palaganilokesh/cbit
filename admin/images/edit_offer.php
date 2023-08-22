<?php
	include_once '../includes/inc_nocache.php';      //Clearing the cache information
    include_once '../includes/inc_adm_session.php';  //Check the session is created or not
    include_once '../includes/inc_connection.php';   //making the connection with database table
	include_once '../includes/inc_usr_functions.php';//Use function for validation and more	
	include_once '../includes/inc_folder_path.php'; 		
	include_once '../includes/inc_config.php';
	/**************************************/
	  //Programm 	  : edit_offer.php	
	  //Company 	  : Adroit
	/**************************************/
	global $id,$pg,$countstart;	
	if(isset($_POST['btnedteventsbmt']) && (trim($_POST['btnedteventsbmt']) != "") && 
	  isset($_POST['txtname']) && (trim($_POST['txtname']) != "")               &&	
	   isset($_POST['txtfrmdate']) && (trim($_POST['txtfrmdate']) != "")         &&	
	   isset($_POST['txttodate']) && (trim($_POST['txttodate']) != "")          &&	
	   isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")   &&
	   isset($_POST['hdneventid']) && (trim($_POST['hdneventid']) != "")){ 	   
		
		 include_once '../includes/inc_fnct_fleupld.php'; // For uploading files	
		 include_once '../database/uqry_ofr_mst.php';
	}
	if(isset($_REQUEST['vw']) && trim($_REQUEST['vw'])!=""
	&& isset($_REQUEST['pg']) && trim($_REQUEST['pg'])!=""
	&& isset($_REQUEST['countstart']) && trim($_REQUEST['countstart'])!="")
	{
	
		$id         = glb_func_chkvl($_REQUEST['vw']);
		$pg         = glb_func_chkvl($_REQUEST['pg']);
		$countstart = glb_func_chkvl($_REQUEST['countstart']);
		$val        = glb_func_chkvl($_REQUEST['val']);
		$chk        = glb_func_chkvl($_REQUEST['chk']);
	}
	elseif(isset($_POST['hdneventid']) && (trim($_POST['hdneventid'])!="") && 
		   isset($_POST['hdnpage']) && 	 (trim($_POST['hdnpage'])!="") && 
		   isset($_POST['hdncount']) &&  (trim($_POST['hdncount'])!="")){
		   
		$id    = glb_func_chkvl($_POST['hdneventid']);
		$pg    = glb_func_chkvl($_POST['hdnpage']);
		$countstart = glb_func_chkvl($_POST['hdncount']);
		$chk   = glb_func_chkvl($_POST['hdnchk']);
	}
	
	if(isset($_POST['hdnoptn']) && (trim($_POST['hdnoptn'])!="") && 
	   isset($_POST['hdnval']) &&  (trim($_POST['hdnval'])!="")){
		$optn = glb_func_chkvl($_POST['hdnoptn']);
		$val  = glb_func_chkvl($_POST['hdnval']);
	}
	elseif(isset($_POST['optn']) && (trim($_POST['optn'])!="") && 
		   isset($_POST['val']) && (trim($_POST['val'])!="")){
	    $countstart = glb_func_chkvl($_REQUEST['countstart']);
		$optn = glb_func_chkvl($_POST['optn']);
		$val  = glb_func_chkvl($_POST['val']);
	}	
	$sqryofr_mst =   "select 
							ofrm_code,ofrm_name,ofrm_desc,ofrm_smlimg,
							date_format(ofrm_frm,'%d-%m-%Y') as ofrm_frm,
							date_format(ofrm_to,'%d-%m-%Y') as ofrm_to,ofrm_lnknm,ofrm_typ,
							ofrm_val,ofrm_prodcatm_id,ofrm_prodscatm_id,ofrm_prodm_id,
							ofrm_sts,ofrm_prty
							
					   from  
							vw_ofr_prodcat_prodscat_mst
					   where 
							ofrm_id='$id'";
	$srsofr_mst  =  mysqli_query($conn,$sqryofr_mst);
	$cntrec 	  =  mysqli_num_rows($srsofr_mst);
	if($cntrec > 0){
		$srowsofr_mst = mysqli_fetch_assoc($srsofr_mst);		
	}
	else{
	 	header("Location:vw_all_offers.php");
		exit();
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>...:: <?php echo $pgtl; ?> ::...</title>
<link href="style_admin.css" rel="stylesheet" type="text/css">
<link href="yav-style.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript" type="text/javascript" src="wysiwyg.js"></script>
	<script language="javascript" src="../js_compact/yav.js"></script>
    <script language="javascript" src="../js_compact/yav-config.js"></script>	
	<script language="javascript" type="text/javascript">
    	var rules=new Array();
		rules[0]='txtname:Name|required|Enter Name';
		rules[1]='txtfrmdate:From Date|required|Enter From Date';
		rules[2]='txttodate:To Date|required|Enter To Date';				
		rules[3]='txttodate|custom|funcCheckDate()';			
		rules[4]='txtprty:Priority|required|Enter Priority';
	</script>
<script language="javascript" type="text/javascript">
	/*function funcChkDupEvent(){
		var name,date,id;
		name    = document.getElementById('txtname').value;
		frmdate = document.getElementById('txtfrmdate').value;
		ofrid  = <?php echo $id; ?>;	
		if(name!="" && frmdate!=""){
			var url = "chkvalidname.php?eventname="+name+"&eventdate="+frmdate+"&ofrid="+ofrid;
			xmlHttp	= GetXmlHttpObject(scProdCode);
			xmlHttp.open("GET", url , true);
			xmlHttp.send(null);
		}
		else{
			document.getElementById('errorsDiv_txtname').value = "";
		}	
	}
	function scProdCode() 
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
</script>

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
				//optn.value 	= id;					
				//optn.text 	= name;
				hdncntyid=document.getElementById('hdncntyid').value;
				hdnctyid =document.getElementById('hdnctyid').value;
				//alert(prmtrCntrlnm);
				if(prmtrCntrlnm=='lstcnty')
				{
				  var newopt=new Option(name,id);
				  if(id==hdncntyid)
				  {
				    newopt.selected="selected";
					
				  }
				   funcDspCty();
				}
				if(prmtrCntrlnm=='lstcty')
				{
				  var newopt=new Option(name,id);
				  if(id==hdnctyid)
				  {
				    newopt.selected="selected";
				  }
				}
				
				//var newopt	= new Option(name,id);
				document.getElementById(prmtrCntrlnm).options[inc+1] = newopt;
			}		
		}	
		//**************************************************		
		function funcDspCnty(){       
			var selcntryid;
			selcntryid = document.getElementById('lstcntry').value;
			if(selcntryid != ""){
				var url = "chkvalidate.php?selcntryid="+selcntryid;
				xmlHttp	= GetXmlHttpObject(funcntyval);
				xmlHttp.open("GET", url , true);
				xmlHttp.send(null);
			}
			else{
				funcRmvOptn('lstcnty');
				funcRmvOptn('lstcty');
			}
		}	
		function funcntyval(){ 	
			if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 									
				funcRmvOptn('lstcnty');
				funcRmvOptn('lstcty');				
				var temp = xmlHttp.responseText;
				if(temp != ""){
					funcAddOptn('lstcnty',temp)																														
				}			
			}
		}  			
		function funcDspCty(){       
			var selcntyid;
			selcntyid = document.getElementById('lstcnty').value;								
			if(selcntyid!=""){
				var url = "chkvalidate.php?selcntyid="+selcntyid;
				xmlHttp	= GetXmlHttpObject(functyval);
				xmlHttp.open("GET", url , true);
				xmlHttp.send(null);
			}
			else{
				funcRmvOptn('lstcty');			
			}
		}	
		function functyval(){ 	
			if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 			
				var temp=xmlHttp.responseText;
				funcRmvOptn('lstcty'); // Removing existing values							
				if(temp != ""){
					funcAddOptn('lstcty',temp)								
				}
			}
		}
		    
</script>
<script language="javascript">	
		function funcCheckDate()
		{
		  var frmdate,todate;
		  frmdate = document.getElementById('txtfrmdate').value.split('-');
		  todate  = document.getElementById('txttodate').value.split('-');
		  if(frmdate!="" && todate!="")
		  {
			  var frm = new Date(frmdate[2]+'/'+frmdate[1]+'/'+frmdate[0]);
			  var to  = new Date(todate[2]+'/'+todate[1]+'/'+todate[0]);
			  if(frm <= to){	
				 return null;
			  }
			  else{	    
				 msg="FromDate should be less than or equal to ToDate"
				 return msg;			 
			  }
		   }
		     		
		}
		function funcCheckTime()
		{
			  var frmhr,frmmnt,frmtime,tohr,tomnt,totime;
			  frmhr   = document.getElementById('lstfrmhr').value;
			  frmmnt  = document.getElementById('lstfrmmnt').value;
			  tohr    = document.getElementById('lsttohr').value;
			  tomnt   = document.getElementById('lsttomnt').value;
			  if(frmhr!=""  &&  tohr!="")
			  {
				  frmhr   = (frmhr*60);
				  if(frmmnt!="")
				  {
				    frmtime = parseInt(frmhr)+parseInt(frmmnt);
				  }
				  else
				  {
				    frmtime = parseInt(frmhr);
				  }	
				  tohr    = tohr*60;
				  if(tomnt!="")
				  {
				    totime  = parseInt(tohr)+parseInt(tomnt);
				  }
				  else
				  {
				    totime  = parseInt(tohr);
				  }
				  if(frmtime <= totime)
				  {
					 return null;
				  }
				  else
				  {
					 msg="FromTime should be less than or equal to ToTime";
					 return msg;
				  }	
			  }	  	  	  	  
		} */
			function funcChkDupcode()
		{
			var ofrcode;
			var ofrid= <?php echo $id ;?>;
			ofrcode = document.getElementById('txtcode').value;		
			if(ofrcode != "" && ofrid != "")
			{
				var url = "chkvalidname.php?ofrcode="+ofrcode+"&ofrid="+ofrid;
				xmlHttp	= GetXmlHttpObject(funcstchngcode);
				xmlHttp.open("GET", url , true);
				xmlHttp.send(null);
			}
			else
			{
				document.getElementById('errorsDiv_txtcode').value = "";
			}	
		}
		function funcstchngcode() 
		{ 
			if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
			{ 	
				var temp=xmlHttp.responseText;
				document.getElementById("errorsDiv_txtcode").innerHTML = temp;
				if(temp!=0)
				{
					document.getElementById('txtcode').focus();
				}		
			}
		}
		
</script>
<script language="javascript" type="text/javascript" src="datetimepicker.js"></script>	
</head>
<body onLoad="setfocus()">
<?php include_once ('../includes/inc_fnct_ajax_validation.php');
include_once ('../includes/inc_adm_header.php');?>
<table width="977"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="230" valign="top"><?php include_once('leftlinks.php');?></td>
    <td valign="top" class="admcnt_bdr"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="700" height="325" valign="top" background="images/content_topbg.gif" bgcolor="#FFFFFF" class="contentpadding" style=" background-repeat:repeat-x; ">
          <span class="maintitles">Edit Offer </span><br>
          <br>
          <table width="95%"  border="0" cellspacing="1" cellpadding="3">
            <form name="frmedtevent" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return performCheck('frmedtevent', rules,'inline');" enctype="multipart/form-data">
			<input type="hidden" name="hdneventid" id="hdneventid" value="<?php echo $id; ?>">
		  <!-- <input type="hidden" name="hdncntyid"  id="hdncntyid"  value="<?php echo $srowsofr_mst['prodcatm_id']; ?>">
		   <input type="hidden" name="hdnctyid"   id="hdnctyid"   value="<?php echo $srowsofr_mst['prodscatm_id']; ?>">-->
		   <input type="hidden" name="hdnpage"    id="hdnpage"    value="<?php echo $pg;?>" >
		   <input type="hidden" name="hdncount"   id="hdncount"   value="<?php echo $countstart;?>">		  
		   <input type="hidden" name="hdnsimgnm"  id="hdnsimgnm"  value="<?php echo $srowsofr_mst['ofrm_smlimg']?>">		  
		   <input type="hidden" name="hdnoptn" value="<?php echo $optn;?>">
		   <input type="hidden" name="hdnval" value="<?php echo $val;?>">
		   <input type="hidden" name="hdnchk" value="<?php echo $chk;?>">
		   					
		   <!--<tr >
		   	<td colspan="4" align="center">&nbsp;
				<strong><font color="#fda33a">
				<?php
					if(isset($gmsg) && $gmsg!="")
					{
						echo $gmsg;
					}
				  ?>
				  </font></strong></td>
	      </tr>--> 
		   <tr > 
            <td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">Code *</td>
			<td width="2%" align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
         <input name="txtcode" type="text" class="select" id="txtcode" size="30" maxlength="50"  onBlur="funcChkDupEvent()" tabindex="1" value="<?php echo $srowsofr_mst['ofrm_code'];?>"></td>
			<td width="44%" bgcolor="#F3F3F3">&nbsp;</td>												
		 </tr>
		   <tr > 
            <td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">Name *</td>
			<td width="2%" align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
         <input name="txtname" type="text" class="select" id="txtname" size="30" maxlength="50"  tabindex="1" value="<?php echo $srowsofr_mst['ofrm_name'];?>"></td>
			<td width="44%" bgcolor="#F3F3F3"><span id="errorsDiv_txtname"></span></td>												
		 </tr>
		  <tr > 
            <td width="24%" align="left" valign="top" bgcolor="#F3F3F3">Description</td>
			<td width="2%" align="center" valign="top" background="#F3F3F3" bgcolor="#F3F3F3">:</td>
            <td colspan="2" align="left" valign="middle" bgcolor="#F3F3F3">
			<textarea name="txtdesc" id="txtdesc" cols="45" rows="7" class="select"><?php echo $srowsofr_mst['ofrm_desc'];?></textarea></td>
		 </tr> 
		<tr > 
            <td width="16%" align="left" valign="top" bgcolor="#F3F3F3">Image</td>
			<td width="2%" align="center" valign="top" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
			<input name="flesmlimg" type="file" class="select" id="flesmlimg"></td>
			<td width="44%" bgcolor="#F3F3F3">
				<?php
				  $imgnm = $srowsofr_mst['ofrm_smlimg'];
				  $imgpath = $gsmlofr_fldnm.$imgnm;
     			  if(($imgnm !="") && file_exists($imgpath)){
					 echo "<img src='$imgpath' width='60pixel' height='60pixel'>";
				  }
				  else{
					 echo "Image not available";
				  }
			?>	
			</td>												
		 </tr>
		  <tr > 
            <td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">From Date</td>
			<td width="2%"  align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
     <input name="txtfrmdate" type="text" class="select" id="txtfrmdate" size="12" maxlength="10"  readonly="readonly" tabindex="2" value="<?php echo $srowsofr_mst['ofrm_frm'];?>"/>
		    <a href="javascript:NewCal('txtfrmdate','ddmmyyyy');focus();funcChkDupEvent()" ><img src="images/calendar.gif" width="19" height="18" border="0" alt="Pick a date"      />            </a>			</td>
			<td width="44%" bgcolor="#F3F3F3"><span id="errorsDiv_txtfrmdate"></span></td>												
		 </tr>
		 <tr > 
            <td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">To Date</td>
			<td width="2%" align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
        <input name="txttodate" type="text" class="select" id="txttodate" size="12" maxlength="10"  readonly="readonly" tabindex="3" value="<?php echo $srowsofr_mst['ofrm_to'];?>">
					<a href="javascript:NewCal('txttodate','ddmmyyyy');focus()" ><img src="images/calendar.gif" width="19" height="18" border="0" alt="Pick a date"      /></a>
						</td>
			<td width="44%" bgcolor="#F3F3F3"><span id="errorsDiv_txttodate"></span></td>												
		 </tr>	 
		<tr > 
            <td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">Link</td>
			<td width="2%"  align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
         <input name="txtlnk" type="text" class="select" id="txtlnk" size="30" maxlength="50" value="<?php echo $srowsofr_mst['ofrm_lnknm']?>"></td>
			<td width="44%" bgcolor="#F3F3F3"></td>												
		 </tr>
		 <tr >
		  	<td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">Type *</td>
			<td width="2%" align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
				<select name="lsttyp" id="lsttyp">
					<option value="r" <?php if($srowsofr_mst['ofrm_typ'] == 'r') {echo "selected";} ?>>Rs/-</option>
					<option value="p" <?php if($srowsofr_mst['ofrm_typ'] == 'p') {echo "selected";} ?>>Persentage</option>
				</select></td>
			<td width="44%" bgcolor="#F3F3F3"></td>	
		  </tr>
		  <tr > 
            <td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">Value *</td>
			<td width="2%"  align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
         <input name="txtval" type="text" class="select" id="txtval" size="30" maxlength="50" value="<?php 
				if($srowsofr_mst['ofrm_typ'] =='p'){
					 echo $srowsofr_mst['ofrm_val'];
				}
				else{
					echo $srowsofr_mst['ofrm_val'];
				}
				?>"></td>
			<td width="44%" bgcolor="#F3F3F3"><span id="errorsDiv_txtval"></span></td>												
		 </tr>
		 <tr > 
            <td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">Category</td>
			<td width="2%"  align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
			<select name="lstcat1"  id="lstcat1" style="width:197px" >
              <!--<option value="">Select</option>-->
              <?php 
				$sqrycat_mst = "select 
				  					prodcatm_id,prodcatm_name 
							      from 
								  	prodcat_mst
								  where 
								  	prodcatm_sts='a'";
				  $srcat_mst   = mysqli_query($conn,$sqrycat_mst) or die(mysqli_error());
				  $cntrec_cat  = mysqli_num_rows($srcat_mst);
				  if($cntrec_cat > 0){
				  echo "<option value=''>Select</option>";
				  while($srowcat_mst = mysqli_fetch_assoc($srcat_mst)){
				  //echo "<option value='$srowcat_mst[prodcatm_id]'>$srowcat_mst[prodcatm_name]</option>";
					  $catnm = '';
							  if($srowcat_mst['prodcatm_id']==$srowsofr_mst['ofrm_prodcatm_id']){
									$catnm ='selected';
							  }
							 echo "<option value='$srowcat_mst[prodcatm_id]' $catnm>$srowcat_mst[prodcatm_name]</option>";
						  }
				}
			?>
            </select></td>
			 <td width="44%" bgcolor="#F3F3F3"><span id="errorsDiv_lstcntry"></span></td>												
		 </tr>
		 <tr > 
            <td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">Sub Category</td>
			<td width="2%"  align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
            <select name="lstcat2"  id="lstcat2" style="width:197px" >
              
              <?php 
				  $sqryscat_mst = "select 
				  					prodscatm_id,prodscatm_name 
							      from 
								  	prodscat_mst
								  where 
								  	prodscatm_sts='a'
									order by prodscatm_name";
				  $srscat_mst   = mysqli_query($conn,$sqryscat_mst) or die(mysqli_error());
				  $cntrec_scat  = mysqli_num_rows($srscat_mst);
				  if($cntrec_scat > 0){
				 echo "<option value=''>Select</option>";
				  while($srowscat_mst = mysqli_fetch_assoc($srscat_mst)){
					 //echo "<option value='$srowcat_mst[prodscatm_id]'>$srowcat_mst[prodscatm_name]</option>";
					$scatnm = '';
							  if($srowscat_mst['prodscatm_id']==$srowsofr_mst['ofrm_prodscatm_id']){
									$scatnm ='selected';
							  }
							 echo "<option value='$srowscat_mst[prodscatm_id]' $scatnm>$srowscat_mst[prodscatm_name]</option>";
						  }
					  } 
				  ?>
            </select></td>
			<td width="44%" bgcolor="#F3F3F3"><span id="errorsDiv_lstcnty"></span></td>												
		 </tr>
		 <tr > 
            <td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">Code-Name</td>
			<td width="2%"  align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
            <select name="lstprod" id="lstprod"  style="width:150px" >
			<?php 
				 $sqryprod_mst = "select 
				  					prodm_id,prodm_name,prodm_code 
							      from 
								  	prod_mst
								  where 
								  	prodm_sts='a'
									order by prodm_name";
				  $srsprod_mst   = mysqli_query($conn,$sqryprod_mst) or die(mysqli_error());
				  $cntrec_prd  = mysqli_num_rows($srscat_mst);
				  if($cntrec_prd > 0){
				  echo "<option value=''>Select</option>";
				  while($srowprod_mst = mysqli_fetch_assoc($srsprod_mst)){
					 //echo "<option value='$srowprod_mst[prodm_id]'>$srowprod_mst[prodm_code]-$srowprod_mst[prodm_name]</option>";
					$prodnm = '';
							  if($srowprod_mst['prodm_id']==$srowsofr_mst['ofrm_prodm_id']){
									$prodnm ='selected';
							  }
							 echo "<option value='$srowprod_mst[prodm_id]' $prodnm>$srowprod_mst[prodm_code]-$srowprod_mst[prodm_name]</option>";
						  }
					  }  
				 ?>

			</select></td>
			<td width="44%" bgcolor="#F3F3F3"></td>												
		 </tr>
        <tr > 
            <td width="16%" align="left" valign="top" bgcolor="#F3F3F3">Priority *</td>
			<td width="2%" align="center" valign="top" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
			<input name="txtprty" type="text" class="select" id="txtprty" size="30" maxlength="50" value="<?php echo $srowsofr_mst['ofrm_prty'];?>"></td>
			<td width="44%" bgcolor="#F3F3F3"><span id="errorsDiv_txtprty"></span></td>												
		 </tr>      
		 <tr >
		  	<td width="16%" align="left" valign="middle" bgcolor="#F3F3F3">Status *</td>
			<td width="2%" align="center" bgcolor="#F3F3F3">:</td>
            <td width="38%" align="left" valign="middle" bgcolor="#F3F3F3">
				<select name="lststs" id="lststs">
					<option value="a"<?php if($srowsofr_mst['ofrm_sts'] =='a') echo 'selected';?>>Active</option>
						<option value="i"<?php if($srowsofr_mst['ofrm_sts'] =='i') echo 'selected';?>>Inactive</option>	
				</select></td>
			<td width="44%" bgcolor="#F3F3F3"></td>	
		  </tr>
          <tr > 
            <td colspan="5"  align="right" valign="middle" bgcolor="#F3F3F3">&nbsp;</td>
          </tr>
          <tr valign="middle" > 
           		<td colspan="4" align="center" bgcolor="#F3F3F3">
						<input type="Submit" class="textfeild"  name="btnedteventsbmt" id="btnedteventsbmt" value="Update">
						&nbsp;&nbsp;&nbsp;
						<input type="reset" class="textfeild"  name="btnprodrst" value="Clear" id="btnprodrst" >
						&nbsp;&nbsp;&nbsp;
						  <INPUT type="button"  name="btnBack" value="Back" class="textfeild" onclick="location.href='vw_all_offers.php?vw=<?php echo $id;?>&pg=<?php echo $pg."&countstart=".$countstart;?>'"></td>           
          </tr>          
        </form>
            </table>
        </td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include_once "../includes/inc_adm_footer.php";?>
</body>
</html>
<script language="javascript" type="text/javascript">
	generate_wysiwyg('txtdesc');
</script>
