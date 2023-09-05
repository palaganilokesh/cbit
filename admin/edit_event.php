<?php
error_reporting(0);
	include_once "../includes/inc_nocache.php"; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once "../includes/inc_connection.php";//Making database Connection
	include_once '../includes/inc_config.php';
	include_once '../includes/inc_usr_functions.php';//Use function for validation and more 
	include_once '../includes/inc_folder_path.php';//Folder Paths	
	include_once 'searchpopcalendar.php';	
	/***************************************************************/  
	//Programm 	  : edit_event.php
	//Package 	  : APVC	 
	//Purpose 	  : Updating new events 
	//Created By  :Lokesh palagani
	//Created On  :	26-06-2023
	//Modified By : 
	//Modified On : 
	//Company 	  : Adroit
	/************************************************************/
	global $id,$pg,$countstart;
    $rd_vwpgnm = "view_event.php";
$rd_crntpgnm = "view_all_events.php";
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Events";
$pagenm = "Events";
/*****header link********/
	if(isset($_POST['btnedtevnt']) && (trim($_POST['btnedtevnt']) != "") && 	
	   isset($_POST['txtname']) && ($_POST['txtname'] != "") && 
       isset($_POST['txtdesc']) && ($_POST['txtdesc'] != "") && 
	 
	   isset($_POST['txtstdate']) && ($_POST['txtstdate'] != "") && 
	   isset($_POST['txtprior']) && ($_POST['txtprior'] != "") && 
	   isset($_POST['hdnevntid']) && ($_POST['hdnevntid'] != "")){	
		
		include_once '../includes/inc_fnct_fleupld.php'; // For uploading files	
		include_once "../database/uqry_evnt_mst.php";
	}
	if(isset($_REQUEST['edit']) && $_REQUEST['edit']!=""
	&& isset($_REQUEST['pg']) && $_REQUEST['pg']!=""
	&& isset($_REQUEST['countstart']) && $_REQUEST['countstart']!="")
	{
		$id 	  = glb_func_chkvl($_REQUEST['edit']);
		$pg 	  = glb_func_chkvl($_REQUEST['pg']);
		$cntstart = glb_func_chkvl($_REQUEST['countstart']);
		$value    = glb_func_chkvl($_REQUEST['val']);
		$opt 	  = glb_func_chkvl($_REQUEST['optn']);
		$ck 	  = glb_func_chkvl($_REQUEST['chk']);	
	}
	else if(isset($_REQUEST['hdnevntid']) && $_REQUEST['hdnevntid']!=""
	&& isset($_REQUEST['hdnpage']) && $_REQUEST['hdnpage']!=""
	&& isset($_REQUEST['hdncnt']) && $_REQUEST['hdncnt']!="")
	{
		$id 	  = glb_func_chkvl($_REQUEST['hdnevntid']);
		$pg 	  = glb_func_chkvl($_REQUEST['hdnpage']);
		$cntstart = glb_func_chkvl($_REQUEST['hdncnt']);
		$value    = glb_func_chkvl($_REQUEST['hdnval']);
		$opt 	  = glb_func_chkvl($_REQUEST['hdnoptn']);
		$ck 	  = glb_func_chkvl($_REQUEST['hdnchk']);
	}
	 $sqryevnt_mst="SELECT 
						evntm_name,evntm_id,evntm_desc,evntm_city,evntm_dstrctm_id,
						evntm_venue,evntm_strtdt,evtnm_strttm,evntm_enddt,
						evntm_endtm,evntm_btch,evntm_fle,evntm_prty,
						evntm_sts,evntm_lnk,evntm_typ,evntm_dept
				    from 
						evnt_mst
	                where 
						evntm_id=$id";
	$srsevnt_mst  = mysqli_query($conn,$sqryevnt_mst);
	$rowsevnt_mst = mysqli_fetch_assoc($srsevnt_mst);
	$ev_typ=$rowsevnt_mst['evntm_typ'];
	if(isset($_REQUEST['imgid']) && (trim($_REQUEST['imgid']) != "") && 	
		   isset($_REQUEST['edit']) && (trim($_REQUEST['edit']) != "") ){
		   
			$imgid      = glb_func_chkvl($_REQUEST['imgid']);
			$pgdtlid    = glb_func_chkvl($_REQUEST['edit']);	   
			$pg         = glb_func_chkvl($_REQUEST['pg']);
			$cntstart   = glb_func_chkvl($_REQUEST['cntstart']);
			$sqryevntimgd_dtl="SELECT 
								  evntimgd_img
							 from 
								  evntimg_dtl
							 where
								  evntimgd_evntm_id='$pgdtlid'  and
								  evntimgd_id = '$imgid'";				 				 				 				 			
			 $srsevntimgd_dtl     = mysqli_query($conn,$sqryevntimgd_dtl);
			 $srowevntimgd_dtl    = mysqli_fetch_assoc($srsevntimgd_dtl);		     			   				
			 $smlimg[$i]      = glb_func_chkvl($srowevntimgd_dtl['evntimgd_img']);
			 $smlimgpth[$i]   = $u_imgevnt_fldnm.$smlimg[$i];
			 $delimgsts = funcDelAllRec($conn,'evntimg_dtl','evntimgd_id',$imgid);
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
<link href="yav-style.css" type="text/css" rel="stylesheet">
<title><?php echo $pgtl; ?></title>
	<script language="javascript" src="../includes/yav.js"></script>
	<script language="javascript" src="../includes/yav-config.js"></script>	
	<script language="javascript" type="text/javascript">
    	var rules=new Array();
    	rules[0]='txtname:Event Name|required|Enter name';
		rules[1]='txtdesc:Event Description|required|Enter Description';
    	rules[2]='txtprior:Priority|required|Enter Priority';
		rules[3]='txtprior:Priority|numeric|Enter Only Numbers';
		//rules[4]='txtcity:City|required|Enter City';
		rules[4]='txtstdate:Start Date|required|Enter Start Date';
	//	rules[6]='txtnvets:Vets|required|Enter No. of Vets/Batches';
	</script>
	<?php
		include_once "../includes/inc_fnct_ajax_validation.php"; //Includes ajax validations				
	?>	
<script language="JavaScript" type="text/javascript" src="wysiwyg.js"></script>
	<script language="javascript">	
		function setfocus()
		{
			document.getElementById('txtname').focus();
		}
	</script>
<script language="javascript" type="text/javascript">
	function funcChkDupName()
	{
		var name,strtdt;
		id= <?php echo $id ;?>;
		name = document.getElementById('txtname').value;
		strtdt 	= document.getElementById('txtstdate').value;				
		if((name != "") && (id != "") && (strtdt !=""))
		{
			var url = "chkduplicate.php?evntname="+name+"&evntstrtdt="+strtdt+"&evntid="+id;
			xmlHttp	= GetXmlHttpObject(stateChanged)
			xmlHttp.open("GET", url , true);
			xmlHttp.send(null);
		}
		else
		{
			document.getElementById('errorsDiv_txtstdate').value = "";
		}	
	}
	function stateChanged() 
	{ 
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{ 	
			var temp=xmlHttp.responseText;
			document.getElementById("errorsDiv_txtstdate").innerHTML = temp;
			if(temp!=0)
			{
				document.getElementById('txtstdate').focus();
			}		
		}
	}	
	
</script>
	<?php 
		include_once ('script.php');
		//include_once ('searchpopcalendar.php');		
	?>
</head>
<body >
<?php 
	include_once '../includes/inc_adm_header.php';
	include_once '../includes/inc_adm_leftlinks.php';?>


<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Events / News</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Events / News</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

          
		  <form name="frmedtevnt" id="frmedtevnt" method="post" action="<?php $_SERVER['PHP_SELF'];?>" onSubmit="return performCheck('frmedtevnt', rules, 'inline');" enctype="multipart/form-data">
		  <input type="hidden" name="hdnevntid" value="<?php echo $id;?>">
		  <input type="hidden" name="hdnpage" value="<?php echo $pg;?>">
		  <input type="hidden" name="hdncnt" value="<?php echo $countstart?>">
		  <input type="hidden" name="hdnsimg" id="hdnsimg" value="<?php echo $rowsevnt_mst['evntm_img'];?>">
		  <input type="hidden" name="hdnevntnm" id="hdnevntnm" value="<?php echo $rowsevnt_mst['evntm_fle']?>">
		 
          <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
								<div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Type *</label>
                            </div>
                            <div class="col-sm-9">
                            <input name="txttyp" disabled type="text" value="<?php  if($rowsevnt_mst['evntm_typ']=='e'){ echo "Event";} else{echo "News";}?>" class="form-control"  id="txttyp" size="45" maxlength="240">
                                <span id="errorsDiv_txttyp"></span>	
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Name *</label>
                            </div>
                            <div class="col-sm-9">
                            <input name="txtname" type="text" value="<?php echo $rowsevnt_mst['evntm_name'];?>" class="form-control"  id="txtname" size="45" maxlength="240" 
						 onBlur="funcChkDupName()">
                                <span id="errorsDiv_txtname"></span>	
                            </div>
                        </div>
                    </div>
					<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Department *</label>
								</div>
								<div class="col-sm-9">
								

									<select name="lstprodcat" id="lstprodcat" class="form-control">
                                        <option value="">--Select Department--</option>
                                        <?php
                                        $sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name from prodcat_mst where prodcatm_typ='d' and prodcatm_admtyp='UG' order by prodcatm_name";
                                        $rsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
                                        $cnt_prodcat = mysqli_num_rows($rsprodcat_mst);
										if( $cnt_prodcat > 0)
										{   ?>
                                            <option disabled>-- UG --</option>
                                            <?php											
                                            while($rowsprodcat_mst=mysqli_fetch_assoc($rsprodcat_mst))
											{
												$catid = $rowsprodcat_mst['prodcatm_id'];
												$catname = $rowsprodcat_mst['prodcatm_name'];
												?>
                                                <option value="<?php echo $catid;?>"<?php if( $rowsevnt_mst['evntm_dept']==$catid) echo 'selected';?>><?php echo $catname;?></option>
												
												<?php
											}
										}
                                        $sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name from prodcat_mst where prodcatm_typ='d' and prodcatm_admtyp='PG' order by prodcatm_name";
                                        $rsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
                                        $cnt_prodcat = mysqli_num_rows($rsprodcat_mst);
										if( $cnt_prodcat > 0)
										{   ?>
                                            <option disabled>-- PG --</option>
                                            <?php	while($rowsprodcat_mst=mysqli_fetch_assoc($rsprodcat_mst))
											{
												$catid = $rowsprodcat_mst['prodcatm_id'];
												$catname = $rowsprodcat_mst['prodcatm_name'];
												?>
                                                 <option value="<?php echo $catid;?>"<?php if($rowsevnt_mst['evntm_dept']==$catid) echo 'selected';?>><?php echo $catname;?></option>
												
												<?php
											}
										}
										?>
									</select>
									<span id="errorsDiv_lstprodcat"></span>
								</div>
							</div>
						</div>
                       
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Description *</label>
                            </div>
                            <div class="col-sm-9">
                            <textarea name="txtdesc" cols="60" rows="5" class="form-control"  id="txtdesc" ><?php echo stripslashes($rowsevnt_mst['evntm_desc']);?></textarea>
                                <span id="errorsDiv_txtdesc"></span>	
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Link</label>
                            </div>
                            <div class="col-sm-9">
                            <input name="txtlnk" type="text" class="form-control"  id="txtlnk"  value="<?php echo $rowsevnt_mst['evntm_lnk'];?>">
                                <span id="errorsDiv_txtlnk"></span>
                            </div>
                        </div>
                    </div>
									<?php if($ev_typ=='e'){
?>
<div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>City</label>
                            </div>
                            <div class="col-sm-9">
                            <input name="txtcity" type="text"class="form-control"  value="<?php echo $rowsevnt_mst['evntm_city'];?>" id="txtcity">
                                <span id="errorsDiv_txtcity"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Venue</label>
                            </div>
                            <div class="col-sm-9">
                            <input name="txtvenue" type="text"class="form-control"  value="<?php echo $$rowsevnt_mst['evntm_venue'];?>" id="txtvenue">
                                <span id="errorsDiv_txtvenue"></span>
                            </div>
                        </div>
                    </div>
				
<?php

									}
									?>	
                    
				
                
<!-- 				
				<tr bgcolor="#FFFFFF">
					<td bgcolor="#f1f6fd"><strong>District</strong></td>
					<td bgcolor="#f1f6fd"><strong>:</strong></td>
					<td bgcolor="#f1f6fd">
						<select name="lstdstrct" id="lstdstrct">
						<option value="" selected>--Select--</option>
						<?php 
							$sqrydstrct_mst = "select 
											ctym_id,ctym_name
										from 
											cty_mst";
							$srsdstrct_mst=mysqli_query($conn,$sqrydstrct_mst);
							while($rowsdstrct_mst=mysqli_fetch_assoc($srsdstrct_mst)){
							?>
                                <option value="<?php echo $rowsdstrct_mst['ctym_id'];?>"
                                <?php 
                                if($rowsdstrct_mst['ctym_id'] == $rowsevnt_mst['evntm_dstrctm_id']){
                                	echo 'selected';
								}
                                ?>><?php echo stripslashes($rowsdstrct_mst['ctym_name']);?>
                                </option>
							<?php
							}
						?>
						</select>
					<td bgcolor="#f1f6fd" ><span id="errorsDiv_txtvenue" style="color:#FF0000"></span></td>
				</tr> -->
                <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Start Date </label>
								</div>
								<div class="col-sm-9">
								<input type="text" name="txtstdate" id="txtstdate" readonly class="form-control" value="<?php echo $rowsevnt_mst['evntm_strtdt'];?>" >
								<script language='javascript'>
                            if(!document.layers){	
                                document.write("<img src='images/calendar.gif' onclick='popUpCalendar(this,frmedtevnt.txtstdate, \"yyyy-mm-dd\")'  style='font-size:11px' style='cursor:pointer'>")
                            }
                        </script>
									<span id="errorsDiv_txtstdate"></span>
								
								</div>
							</div>
						</div>
						<?php if($ev_typ=='e'){
?>
            <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Start Time</label>
								</div>
								<div class="col-sm-2">
								<select name="lststhr" id="lststhr" class="form-control" >
									<option value="" selected>HH</option>
									<?php
					$sttm			= $rowsevnt_mst['evtnm_strttm'];
					$sttmarr 		= explode(":",$sttm);
					$sthrs          = $sttmarr[0];
					$stminarr		= explode(" ",$sttmarr[1]);
					$stmin			= $stminarr[0];
					$stmina			= $stminarr[1];
						for($i=0;$i<=12;$i++)
						{
						if($i < 10){
							$i='0'.$i;
						}
						//$i_dgt = sprintf("%02s", $i);	
					?>
					<option value="<?php echo $i;?>" <?php if($sthrs == $i) echo "selected";?>><?php echo $i;?></option>
					<?php
					}
					?>
                    </select>
										

								</div>
								<div class="col-sm-2">
								<select name="lststmin" id="lststmin" class="form-control" >
									<option value="" selected>MM</option>
                                    <?php
						for($j=0;$j<=60;$j=$j+5)
						{
						//$j_dgt = sprintf("%02s", $j);
						if($j < 10){
							$j='0'.$j;
						}	
					?>
					<option value="<?php echo $j;?>" <?php if($stmin == $j) echo "selected";?>><?php echo $j;?></option>
					<?php
					}
					?>
                      </select>
										

								</div>
								<div class="col-sm-2">
								<select name="lstst" id="lstst" class="form-control" >
								<option value=""selected>Select Format</option>
								<option value="AM" <?php if($stmina == "AM") echo "selected";?>>AM</option>
                        <option value="PM" <?php if($stmina == "PM") echo "selected";?>>PM</option>
									
                      </select>
										

								</div>

							</div>
						</div>
						
          
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>End Date</label>
								</div>
								<div class="col-sm-9">
                                <?php
                $end_dtval = $rowsevnt_mst['evntm_enddt'];
				if($rowsevnt_mst['evntm_enddt'] =='0000-00-00'){
               		$end_dtval ='';
			    }
                ?>
				
								<input type="text" name="txteddt" id="txteddt" readonly class="form-control" value="<?php echo $end_dtval;?>" >
							
								<script language='javascript'>
							if(!document.layers){	
								document.write("<img src='images/calendar.gif' onclick='popUpCalendar(this,frmedtevnt.txteddt, \"yyyy-mm-dd\")'  style='font-size:11px' style='cursor:pointer'>")
							}
                        </script>	
									<span id="errorsDiv_txteddt"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Edit Time</label>
								</div>
								<div class="col-sm-2">
								<select name="lstethr" id="lstethr" class="form-control" >
									<option value="" selected>HH</option>
									<?php
					$edtm			= $rowsevnt_mst['evntm_endtm'];
					$edtmarr 		= explode(":",$edtm);
					$edhrs          = $edtmarr[0];
					$edminarr		= explode(" ",$edtmarr[1]);
					$edmin			= $edminarr[0];
					$edmina			= $edminarr[1];
					for($k=0;$k<=12;$k++){
					   if($k < 10){
							$k='0'.$k;
						}
					//$k_dgt = sprintf("%02s", $k);					
					?>
					<option value="<?php echo $k;?>" <?php if($edhrs == $k) echo "selected";?>><?php echo $k;?></option>
					<?php
					}
					?>
                     
                    </select>
										

								</div>
								<div class="col-sm-2">
								<select name="lstetmin" id="lstetmin" class="form-control" >
									<option value="" selected>MM</option>
                                    <?php
						for($l=0;$l<=60;$l=$l+5)
						{
						 if($l < 10){
							$l='0'.$l;
						}
						//$l_dgt = sprintf("%02s", $l);	
					?>
					<option value="<?php echo $l;?>" <?php if($edmin == $l) echo "selected";?>><?php echo $l;?></option>
					<?php
					}?>
                      </select>
										

								</div>
								<div class="col-sm-2">
								<select name="lstet" id="lstet" class="form-control" >
								<option value=""selected>Select Format</option>
								<option value="AM"  <?php if($edmina == "AM") echo "selected";?>>AM</option>
					    <option value="PM"  <?php if($edmina == "PM") echo "selected";?>>PM</option>
									
                      </select>
										

								</div>

							</div>
						</div>
					

                        <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>No. of seats</label>
								</div>
								<div class="col-sm-9">
                                <input name="txtnvets" type="text" class="form-control"  value="<?php echo $rowsevnt_mst['evntm_btch'];?>" class="select" id="txtnvets">
									<span id="errorsDiv_txtnvets"></span>
								</div>
							</div>
						</div>
			
						<div class="col-md-12">
            <div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>File</label>
								</div>
								<div class="col-sm-9">
									<input type="file" name="evntfle" id="evntfle" class="form-control">
                                    <?php
					  $evntflnm 	= $rowsevnt_mst['evntm_fle'];
					  $evntflpath 	= $gevnt_fldnm.$id."-".$evntflnm;
					 if(($evntflnm !="") && file_exists($evntflpath)){
						echo $evntflnm;
						
					  }
					  else{
						 echo "File not available";
					  }
					 
					?>	
									<span id="errorsDiv_evntfle"></span>
								</div>
							</div>
						</div>
						<?php }?>	
               <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Rank *</label>
								</div>
								<div class="col-sm-9">
                                <input type="text" name="txtprior" id="txtprior" value="<?php echo $rowsevnt_mst['evntm_prty'];?>"class="form-control" >
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
                                    <option value="a"<?php if($rowsevnt_mst['evntm_sts']=='a') echo 'selected';?>>Active</option>
						<option value="i"<?php if($rowsevnt_mst['evntm_sts']=='i') echo 'selected';?>>Inactive</option>
									</select>

								</div>
							</div>
						</div>
				
				
		
				
                        <div class="table-responsive">
									<table width="100%"  border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
										<tr bgcolor="#FFFFFF">
											<td width="1%"  align="center" ><strong>S.No.</strong></td>
											<td width="10%" align="center" ><strong>Name</strong></td>
											<td width="35%"  align="center" ><strong> Image</strong></td>
												<td width="10%"  align="center" ><strong>Priority</strong></td>
											<td width="10%"  align="center" ><strong>Status</strong></td>
                                            <td width="10%"  align="center" ><strong>Remove</strong></td>
										</tr>
									</table>
								</div> 
              
			 
				<?php
			  	$sqryimg_dtl="SELECT 
								evntimgd_id,evntimgd_name,evntimgd_evntm_id,evntimgd_img,
								evntimgd_prty,evntimgd_sts
							 from 
								  evntimg_dtl
							 where 
								 evntimgd_evntm_id ='$id' 
							 order by 
								 evntimgd_id";
	            $srsimg_dtl	= mysqli_query($conn,$sqryimg_dtl);		
		        $cntevntimg_dtl  = mysqli_num_rows($srsimg_dtl);
			  	$nfiles = "";
				if($cntevntimg_dtl> 0 ){
				?>
				<?php				
			  	while($rowsevntimgd_mdtl=mysqli_fetch_assoc($srsimg_dtl)){				
					$evntimgdid 	  = $rowsevntimgd_mdtl['evntimgd_id'];
					$db_evntimgnm   = $rowsevntimgd_mdtl['evntimgd_name'];
					$arytitle     = explode("-",$db_evntimgnm);
					$db_evntimgimg  = $rowsevntimgd_mdtl['evntimgd_img'];
					$db_evntimgprty = $rowsevntimgd_mdtl['evntimgd_prty'];
					$db_evntimgsts  = $rowsevntimgd_mdtl['evntimgd_sts'];
					
					$imgnm = $db_evntimgimg;					
					$imgpath = $imgevnt_fldnm.$imgnm;
					$nfiles+=1;
					$clrnm = "";
					if($cnt%2==0){
						$clrnm = "bgcolor='#f1f6fd'";
					}
					else{
						$clrnm = "bgcolor='#f1f6fd'";
					}
			  ?>
<div class="table-responsive">
									<table width="100%"  border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered" >
										<table width="100%" border="0" cellspacing="3" cellpadding="3">
											<tr bgcolor="#FFFFFF">
                                            <input type="hidden" name="hdnpgdid<?php echo $nfiles?>" class="select" value="<?php echo $evntimgdid;?>">
                                            <td width='5%'><?php echo  $nfiles;?></td>
												
												<td width="15%"  align="center">
													<input type="text" name="txtphtname1<?php echo $nfiles?>" id="txtphtname1<?php echo $nfiles?>" placeholder="Name" class="form-control" size="15" value='<?php echo  $arytitle[1]?>'><br>
													<span id="errorsDiv_txtphtname1" style="color:#FF0000"></span>
												</td>
												<td width="30%"  align="center" >
													
                                                    <input type="file" name="flesmlimg<?php echo $nfiles?>"class="form-control" id="flesmlimg" ><br/>
								</td>
								<td bgcolor="#f1f6fd"  align="left" width='10%'>
								<?php						   
									  if(($imgnm !="") && file_exists($imgpath)){
											 echo "<img src='$imgpath' width='30pixel' height='30pixel'>";
									  }
									  else{
										 echo "No Image";
									  }
								  ?>
													<span id="errorsDiv_flesmlimg" style="color:#FF0000"></span>
												</td>
												<td width="10%"  align="center">
												<input type="text" name="txtphtprior<?php echo $nfiles?>" id="txtphtprior1" class="form-control" value="<?php echo $db_evntimgprty;?>" size="4" maxlength="3">                     
												<br>
													<span id="errorsDiv_txtphtprior" style="color:#FF0000"></span>
												</td>
												<td width="10%" align="center" >					
													<select name="lstphtsts<?php echo $nfiles?>" id="lstphtsts<?php echo $nfiles?>" class="form-control">
													<option value="a" <?php if($db_evntimgsts =='a') echo 'selected'; ?>>Active</option>
									<option value="i" <?php if($db_evntimgsts =='i') echo 'selected'; ?>>Inactive</option>
													</select>
												</td>
												<td width='10%' align="center">
													<!-- <input type="button" name="test" value="test" onclick="test_fnc();"> -->
												<input type="button"  name="btnrmv"  value="REMOVE"  onclick="rmvimg('<?php echo $evntimgdid; ?>')"></td>

											</tr>
											<?php
			  	}
				}
				else{
					echo "<tr bgcolor='#FFFFFF'><td colspan='7' align='center' bgcolor='#f1f6fd'>Image not available</td></tr>";
				}
				?>
										</table>
									</table>
									<input type="hidden" name="hdntotcntrl" value="<?php echo $nfiles;?>">
									<div id="myDiv">
										<table width="100%" cellspacing='2' cellpadding='3'>
											<tr>
												<td align="center">
													<input name="btnadd" type="button" onClick="expand()" value="Add Another Image" class="btn btn-primary mb-3">
												</td>
											</tr>
											
										</table>
									</div>
								</div>
								<p class="text-center">
                        <input type="Submit" class="btn btn-primary btn-cst" name="btnedtevnt" id="btnedtevnt" value="Submit">
                        &nbsp;&nbsp;&nbsp;
                        <input type="reset" class="btn btn-primary btn-cst" name="btnecatrst" value="Clear" id="btnecatrst">
                        &nbsp;&nbsp;&nbsp;
												<?php
						$val = $_REQUEST['val'];
					?>
                        <input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm; ?>'">
												<!-- <input type="button"  name="btnBack" value="Back" class="textfeild" onclick="location.href='events.php?pg=<?php echo $pg."&countstart=".$cntstart;?>&val=<?php echo $value;?>&optn=<?php echo $opt;?>&chk=<?php echo $ck;?>'"> -->
                    </p>

			 
								</div></div></div>
		  </form>
</section>

<?php include_once "../includes/inc_adm_footer.php";?>
</body>
</html>
 <script language="JavaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>	
<script language="javascript" type="text/javascript">
	 var nfiles ="<?php echo $nfiles;?>";
	   function expand () {	   		
			nfiles ++;


		



            var htmlTxt = '<?php
					echo "<table width=100%  border=0 cellspacing=1 cellpadding=1 >"; 
					echo "<tr>";
					echo "<td align=left width=5%>";
					echo "<span class=buylinks> ' + nfiles + '</span></td>";
					echo "<td  width=27% >";
					echo "<input type=text name=txtphtname1' + nfiles + ' id=txtphtname1' + nfiles + ' class=form-control size=10><br>";
					echo "<td align=left width=30% colspan=2>";
					echo "<input type=file name=flesmlimg' + nfiles + ' id=flesmlimg' + nfiles + ' class=form-control><br>";
					echo "<td align=center width=20%>";
					echo "<input type=text name=txtphtprior' + nfiles + ' id=txtphtprior' + nfiles + ' class=form-control size=4 maxlength=3>";
					echo "</td>"; 
					echo "<td  width=20% align=right colspan=2>";
					echo "<select name=lstphtsts' + nfiles + ' id=lstphtsts' + nfiles + ' class=form-control>";
					echo "<option value=a>Active</option>";
					echo "<option value=i>Inactive</option>";
					echo "</select>";
					echo "</td></tr></table><br>";			
				?>';			
            var Cntnt = document.getElementById ("myDiv");			
			if (document.createRange) {//all browsers, except IE before version 9 				
			 var rangeObj = document.createRange ();
			 	Cntnt.insertAdjacentHTML('BeforeBegin' , htmlTxt);
				document.frmedtevnt.hdntotcntrl.value = nfiles;	
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
			document.frmedtevnt.hdntotcntrl.value = nfiles;
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
			document.frmedtevnt.action="edit_event.php?edit=<?php echo $id;?>&imgid="+img_id+"&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart.$loc;?>" 
			document.frmedtevnt.submit();	
		}
	CKEDITOR.replace('txtdesc');
	
</script>