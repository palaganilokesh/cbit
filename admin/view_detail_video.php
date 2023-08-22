<?php

include_once '../includes/inc_config.php'; //Making paging validation	
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************
Programm : view_detail_video.php	
Purpose : For Viewing video Details
Created By : Lokesh palagani
Created On :	21707-2023
Modified By : 
Modified On :
Purpose : 
Company : Adroit
 ************************************************************/
global $id, $pg, $countstart;
$rd_crntpgnm = "view_all_video.php";
$rd_edtpgnm = "edit_video.php";
$clspn_val = "4";
/*****header link********/
$pagemncat = "Gallery";
$pagecat = "Videos";
$pagenm = "Videos";
/*****header link********/
if (isset($_REQUEST['vw']) && (trim($_REQUEST['vw']) != "") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg']) != "") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart']) != "")) {
    $id = glb_func_chkvl($_REQUEST['vw']);
    $pg = glb_func_chkvl($_REQUEST['pg']);
    $countstart = glb_func_chkvl($_REQUEST['countstart']);
    $srchval = glb_func_chkvl($_REQUEST['val']);
}
 $sqryprodscat_mst = "select 
videom_id,videom_name,videom_desc,videom_prty,videom_sts
from  
vw_videod_videom_mst
where 
videom_id='$id'";
$srsprodscat_mst  = mysqli_query($conn, $sqryprodscat_mst);
$rowsprodscat_mst = mysqli_fetch_assoc($srsprodscat_mst);

// $db_scattype     = $rowsprodscat_mst['prodscatm_typ']; //type
$loc = "&val=$srchval";
if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) {
    $msg = "<font color=red>Record updated successfully</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "n")) {
    $msg = "<font color=red>Record not updated</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "d")) {
    $msg = "<font color=red>Duplicate Recored Name Exists & Record Not updated</font>";
}
?>
<script language="javascript">
    function update1() //for update download details
    {
        document.frmedtbrnd.action = "<?php echo $rd_edtpgnm; ?>?edit=<?php echo $id; ?>&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
        document.frmedtbrnd.submit();
    }
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">View Videos</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Videos</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <form name="frmedtbrnd" id="frmedtbrnd" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return performCheck('frmedtbrnd', rules, 'inline');">
        <input type="hidden" name="hdnprodscatid" value="<?php echo $id; ?>">
        <input type="hidden" name="hdnpage" value="<?php echo $pg; ?>">
        <input type="hidden" name="hdncnt" value="<?php echo $countstart ?>">
        <?php
        if ($msg != '') {
            echo "<center><tr bgcolor='#FFFFFF'>
				<td colspan='4' bgcolor='#F3F3F3' align='center'><strong>$msg</strong></td> 
			 </tr></center>";
        }
        ?>
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">
                                 Name</label>
                            <div class="col-sm-8">
                                <?php echo $rowsprodscat_mst['videom_name']; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <?php echo $rowsprodscat_mst['videom_desc']; ?>
                            </div>
                        </div>
                       



                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Priority</label>
                            <div class="col-sm-8">
                                <?php echo $rowsprodscat_mst['videom_prty']; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Status</label>
                            <div class="col-sm-8">
                            <?php echo funcDispSts($rowsprodscat_mst['videom_sts']);?>
                             
                            </div>
                        </div>
                        <div class="table-responsive">
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
								<td width="5%" align="center"><strong>SL.No.</strong></td>
										<td width="30%" align="center"><strong>Name</strong></td>
										<td width="30%" align="center"><strong>Video</strong></td>
										<td width="10%" align="center"><strong>Rank</strong></td>
										<td width="10%" align="center"><strong>Status</strong></td>
								</tr>
							</table>
						</div>


            <?php
				 $sqryimg_dtl="SELECT 
									videod_id,videod_nm,videod_video,videod_prty,
									 	videod_sts
							  from 
								  	vw_videod_videom_mst
							  where 
								 	 	videod_videom_id  ='$id' 
							  order by 
								 	 	videod_id";
					   $srsimg_dtl	= mysqli_query($conn,$sqryimg_dtl);		
					   $cntvdo_dtl  = mysqli_num_rows($srsimg_dtl);
					$cnt = $offset;
					if($cntvdo_dtl> 0 ){				
					while($rowvdo_dtl=mysqli_fetch_assoc($srsimg_dtl)){						
						$cnt+=1;
				  ?>
          	<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
								<td width="5%" align="center"><?php echo $cnt;?></td>
								
										<td width="30%" align="center"><?php echo $rowvdo_dtl['videod_nm']; ?></td>
										<td width="30%" align="center">
                    <?php 
				            	$url = $rowvdo_dtl['videod_video'];
					        	parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
						       // $my_array_of_vars['v']; ?>
								<iframe src="<?php echo $url; ?>" allowfullscreen="" width="200" height="100" frameborder="0"></iframe> 
                      
                    </td>
										
										<td width="10%" align="center"><?php echo $rowvdo_dtl['videod_prty']; ?></td>
										<td width="10%" align="center"><?php echo funcDispSts($rowvdo_dtl['videod_sts']);?></td>
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
                            <input type="Submit" class="btn btn-primary btn-cst" name="btnedtbrnd" id="btnedtbrnd" value="Edit" onclick="update1();">
                            &nbsp;&nbsp;&nbsp;
                            <input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='<?php echo $rd_crntpgnm; ?>?<?php echo $loc; ?>'">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<?php include_once "../includes/inc_adm_footer.php"; ?>