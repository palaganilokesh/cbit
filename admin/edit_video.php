<?php
error_reporting(0);
include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once "../includes/inc_adm_session.php"; //checking for session
include_once "../includes/inc_connection.php"; //Making database Connection
include_once "../includes/inc_usr_functions.php"; //checking for session
include_once '../includes/inc_config.php';       //Making paging validation
include_once '../includes/inc_folder_path.php'; //Floder Path	
/***************************************************************/
//Programm 	  		: edit_brand.php	
//Purpose 	  			: Updating new brand
//Created By  		:Lokesh palagani
//Created On  		:	27-07-2023
//Modified By 		: 
//Modified On   	:
//Company 	  		: Adroit
/************************************************************/
global $id, $pg, $countstart, $fldnm;
$fldnm = $gbrnd_upldpth;
$rd_crntpgnm = "view_all_video.php";
$rd_vwpgnm = "view_detail_video.php";
$page="edit_video.php";
/*****header link********/
$pagemncat = "Gallery";
$pagecat = "Videos";
$pagenm = "Videos";
/*****header link********/
if (
    isset($_POST['btnedtpht']) && ($_POST['btnedtpht'] != "") &&
    isset($_POST['txtname']) && ($_POST['txtname'] != "") &&

    isset($_POST['txtprty']) && ($_POST['txtprty'] != "")
) {

    include_once "../includes/inc_fnct_fleupld.php"; // For uploading files		
    include_once '../database/uqry_video_mst.php';
}
if (
    isset($_REQUEST['edit']) && $_REQUEST['edit'] != "" &&
    isset($_REQUEST['pg']) && $_REQUEST['pg'] != "" &&
    isset($_REQUEST['countstart']) && $_REQUEST['countstart'] != ""
) {
    $id         = $_REQUEST['edit'];
    $pg         = $_REQUEST['pg'];
    $countstart = $_REQUEST['countstart'];
} else if (
    isset($_REQUEST['vw']) && $_REQUEST['vw'] != "" &&
    isset($_REQUEST['pg']) && $_REQUEST['pg'] != "" &&
    isset($_REQUEST['countstart']) && $_REQUEST['countstart'] != ""
) {
    $id         = $_REQUEST['vw'];
    $pg         = $_REQUEST['pg'];
    $countstart = $_REQUEST['countstart'];
}
$sqrybrnd_mst = "select 
videom_id,videom_name,videom_desc,videom_prty,videom_sts,
videod_sts
 from  
vw_videod_videom_mst
where 
         videom_id=$id";
$srsbrnd_mst  = mysqli_query($conn, $sqrybrnd_mst);
$cntbrnd_mst  = mysqli_num_rows($srsbrnd_mst);
if ($cntbrnd_mst > 0) {
    $rowsbrnd_mst = mysqli_fetch_assoc($srsbrnd_mst);
} else {
    header('Location: view_all_video.php');
    exit;
}
if(isset($_REQUEST['vidid']) && (trim($_REQUEST['vidid']) != "")){ 
  $vidid      = glb_func_chkvl($_REQUEST['vidid']);	 
  $pg         = glb_func_chkvl($_REQUEST['pg']);
  $cntstart   = glb_func_chkvl($_REQUEST['countstart']);
   $sqryprodimgd_dtl="select 
              videod_video
           from 
              video_dtl
           where
              videod_id = '$vidid'";				 				 			
 $srsprodimgd_dtl    	= mysqli_query($conn,$sqryprodimgd_dtl);
 $srowprodimgd_dtl    	= mysqli_fetch_assoc($srsprodimgd_dtl);
 $delimgsts 		= funcDelAllRec($conn,'video_dtl','videod_id',$vidid);
 
 }
?>
<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
    var rules = new Array();

    rules[0] = 'txtname:Name|required|Enter Name';
    rules[1] = 'txtprty:Priority|required|Enter Rank';
    rules[2] = 'txtprty:Priority|numeric|Enter Only Numbers';

    function setfocus() {
        document.getElementById('txtname').focus();
    }


</script>
<?php
include_once('script.php');
include_once('../includes/inc_fnct_ajax_validation.php');
?>
<script language="javascript" type="text/javascript">
    function funcChkDupName() {
        var name;
        name = document.getElementById('txtname').value;
        var prodmcatid = document.getElementById('lstprdctcat').value;
        id = <?php echo $id; ?>;
        if (name != "" && prodmcatid != "" && id != "") {
            var url = "chkduplicate.php?prodcatname=" + name + "&prodmcatid=" + prodmcatid + "&prodcatid=" + id;
            xmlHttp = GetXmlHttpObject(stateChanged);
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
        } else {
            document.getElementById('errorsDiv_txtname').innerHTML = "";
        }
    }

    function stateChanged() {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
            var temp = xmlHttp.responseText;
            document.getElementById("errorsDiv_txtname").innerHTML = temp;
            if (temp != 0) {
                document.getElementById('txtname').focus();
            }
        }
    }
    function rmvvideo(imgid){
     
     var vid_id;
     vid_id = imgid;
     
     if(vid_id !=''){
       var r=window.confirm("Do You Want to Remove Video");
       if (r==true){
          x="You pressed OK!";
         }
       else{
           return false;
         }	
     }
     document.frmedtpht.action="<?php echo $page;?>?vw=<?php echo $id;?>&vidid="+vid_id+"&pg=<?php echo $pg;?>&countstart=	<?php echo $cntstart; ?>"; 
     document.frmedtpht.submit();	
   }
</script>
<?php
include_once $inc_adm_hdr;
include_once $inc_adm_lftlnk;
?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Videos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Videos</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <form name="frmedtpht" id="frmedtpht" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onSubmit="return performCheck('frmedtpht', rules, 'inline');">
        <input type="hidden" name="vw" value="<?php echo $id; ?>">
        <input type="hidden" name="pg" value="<?php echo $pg; ?>">
        <input type="hidden" name="val" value="<?php echo $srchval; ?>">
        <input type="hidden" name="chk" value="<?php echo $chk; ?>">
        <input type="hidden" name="countstart" value="<?php echo $countstart ?>">
        
       <!--  <input type="hidden" name="vw" id="vw" value="<?php echo $id;?>">
		  <input type="hidden" name="pg" id="pg" value="<?php echo $pg;?>">
		  <input type="hidden" name="countstart" id="countstart" value="<?php echo $cntstart?>">	
		  <input type="hidden" name="val" id="val" value="<?php echo $val?>">	  	
		  <input type="hidden" name="chk" id="chk" value="<?php echo $chk?>">	 -->
     
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                   
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Name *</label>
                            </div>
                            <div class="col-sm-9">
                                <input name="txtname" type="text" id="txtname" size="45" maxlength="40" onBlur="funcChkDupName()" class="form-control" value="<?php echo $rowsbrnd_mst['videom_name']; ?>">
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
                                <textarea name="txtdesc" cols="60" rows="3" id="txtdesc" class="form-control"><?php echo $rowsbrnd_mst['videom_desc']; ?></textarea>
                            </div>
                        </div>
                    </div>
      
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Priority*</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="txtprty" id="txtprty" class="form-control" size="4" maxlength="3" value="<?php echo $rowsbrnd_mst['videom_prty']; ?>">
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
                                    <option value="a" <?php if ($rowsbrnd_mst['videom_sts'] == 'a') echo 'selected'; ?>>Active</option>
                                    <option value="i" <?php if ($rowsbrnd_mst['videom_sts'] == 'i') echo 'selected'; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
						<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
							<tr bgcolor="#FFFFFF">
								<td width="5%" align="center"><strong>SL.No.</strong></td>
								<td width="21%" align="center"><strong>Name</strong></td>
								<td width="39%" align="center"><strong>Video</strong></td>
								<td width="10%" align="center"><strong>Rank</strong></td>
								<td width="10%" align="center"><strong>Status</strong></td>
								<td width="10%" align="center"><strong>Remove</strong></td>
							</tr>
						</table>
					</div>
          <?php
			  	$sqryimg_dtl="select 
									videod_id,videod_nm,videod_video,
									videod_sts,videod_prty
							 from 
								  vw_videod_videom_mst
							 where 
								   	videod_videom_id  ='$id'";
	            $srsimg_dtl	= mysqli_query($conn,$sqryimg_dtl);		
		        $cntphtimg_dtl  = mysqli_num_rows($srsimg_dtl);
			  	$nfiles = "";
				if($cntphtimg_dtl> 0 ){
				?>
				<?php				
			  	while($rowsphtimgd_mdtl=mysqli_fetch_assoc($srsimg_dtl)){
					$phtimgdid = $rowsphtimgd_mdtl['videod_id'];
					$arytitle = explode("-",$rowsphtimgd_mdtl['videod_nm']);
					$nfiles+=1;					
			  ?>
<div class="table-responsive">
								<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
									<table width="100%" border="0" cellspacing="3" cellpadding="3">
										<tr bgcolor="#FFFFFF">
											<td colspan="7" align="center" bgcolor="#f1f6fd">

                      <input type="hidden" name="hdnbgimg<?php echo $nfiles?>"value="<?php echo $rowsphtimgd_mdtl['videod_id'];?>">
			              <input type="hidden" name="hdnproddid<?php echo $nfiles?>"  value="<?php echo $phtimgdid;?>">	

										<tr>
											<td width='5%'>
                      <?php echo $nfiles;?>
											</td>
											<td width='20%' align='center'>
                      <input type="text" name="txtphtname<?php echo $nfiles?>" id="txtphtname" value='<?php echo $rowsphtimgd_mdtl['videod_nm']?>'  size="15" class="form-control">
											</td>
											<td width="25%" align="center">
                      <input type="textarea" name="txtvideo<?php echo $nfiles?>"  id="txtvideo" class="form-control"  value='<?php echo $rowsphtimgd_mdtl['videod_video']?>' ><br>

											</td>
											<td width="14%" align="center">
                      <?php 
				             	$url = $rowsphtimgd_mdtl['videod_video'];
					        	parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
						       // $my_array_of_vars['v']; ?>
                               <iframe src="<?php echo $url; ?>" allowfullscreen="" width="120" height="100" frameborder="0"></iframe> <br>

											</td>
                      <td width="10%" align="center">
                      <input type="text" name="txtphtprior<?php echo $nfiles?>" id="txtphtprior" value="<?php echo $rowsphtimgd_mdtl['videod_prty'];?>" size="4" maxlength="3"  class="form-control"><span id="errorsDiv_txtphtprior"></span>
          </td>
											<td width="10%" align="center">
											<select name="lstphtsts<?php echo $nfiles?>" class="form-control" id="lstphtsts<?php echo $nfiles?>" >
							 <option value="a"<?php if($rowsphtimgd_mdtl['videod_sts']=='a') echo 'selected';?>>Active</option>
							 <option value="i"<?php if($rowsphtimgd_mdtl['videod_sts']=='i') echo 'selected';?>>Inactive</option>
							</select>
											</td>
											<td width='10%'><input type="button" name="btnrmv" value="REMOVE"
                      onClick="rmvvideo('<?php echo $rowsphtimgd_mdtl['videod_id']; ?>')"></td>
													</tr>
											</td>
										</tr>
									</table>
								</table>

											<?php
						}
						
					}
					else{
						echo "<tr bgcolor='#FFFFFF'><td colspan='6' align='center' bgcolor='#f1f6fd'>No Records Found.</td></tr>";
					}
					?>
					<div id="myDiv">
										<table width="100%" cellspacing='2' cellpadding='3'>
										
											<tr>
												<td align="center">
                        <input type="hidden" name="hdntotcntrl" id="hdntotcntrl" value="<?php echo $nfiles;?>">
													<input name="btnadd" type="button" onClick="expand()" value="Add Another Video" class="btn btn-primary mb-3">
												</td>
											</tr>
										</table>
									</div>

                  <p class="text-center">
                  <input type="hidden" name="hidnid" id="hidnid" value="<?php echo $rowsphtimgd_mdtl['videod_id'];?> ">  
                        <input type="Submit" class="btn btn-primary btn-cst" name="btnedtpht" id="btnedtpht" value="Submit">
                        &nbsp;&nbsp;&nbsp;
                        <input type="reset" class="btn btn-primary btn-cst" name="btneprodcatrst" value="Clear" id="btneprodcatrst">
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm; ?>'">
                    </p>
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
/********************Multiple Video Upload********************************/
	  var nfiles ="<?php echo $nfiles;?>";
	   function expand () {	   		
			nfiles ++;
            var htmlTxt = '<?php
				echo "<table width=100%  border=0 cellspacing=1 cellpadding=2>"; 
				echo "<tr>";
				echo "<td align=left width=4%>";
				echo "<span class=buylinks>' + nfiles + '</span></td>";
				echo "<td width=25% align=left>";
				echo "<input type=text name=txtphtname' + nfiles + ' id=txtphtname1' +                       nfiles +                     ' class=form-control size=30></td>";
				echo "<td align=left width=30%>";
				echo "<input type=text name=txtvideo' + nfiles + ' id=txtvideo' +                   nfiles + '                      class=form-control size=30></td><td width=11% align=left></td>";
				echo "<td align=left width=9%>";
				echo "<input type=text name=txtphtprior' + nfiles + ' id=txtphtprior1'                        +                      nfiles + ' class=form-control size=4 maxlength=3>";
				echo "</td>"; 
				echo "<td width=10% align=right>";
				echo "<select name=lstphtsts' + nfiles + ' id=lstphtsts' + 
				      nfiles + ' class=form-control>";
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


                   
             
