<?php

error_reporting(0);
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once 'includes/inc_config.php'; //Making paging validation	
include_once 'includes/inc_folder_path.php'; //Making paging validation	

	
$page_title = "Notifications | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Notifications | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
include('header.php');
?>

<style>
.section-title h2 {
    font-size: 20px;
}
</style>

<div class="page-banner-area bg-2">

</div>
<?php
if (isset($_REQUEST['notify_typ']) && trim($_REQUEST['notify_typ']) != "") {
	$notify_typ1			=glb_func_chkvl($_REQUEST['notify_typ']);
$notify_typ=funcStrUnRplc($notify_typ1);
	$not_id1			= glb_func_chkvl($_REQUEST['notid']);
	$not_id=funcStrUnRplc($not_id1);
	$txt=explode('_',$not_id );
	$nt_id=$txt[1];
	 $sqryanounce_mst = "SELECT nwsm_id,nwsm_name,nwsm_sts,nwsm_prty,nwsm_typ,nwsm_img,nwsm_dwnfl,date_format(nwsm_dt,'%d-%m-%Y') as nwsm_dt,nwsm_desc,nwsm_lnk	from nws_mst where nwsm_id != '' and nwsm_sts='a'  and nwsm_typ='$notify_typ' and (nwsm_name='$not_id' or nwsm_id='$nt_id') ";
	
}
$sqryanounce_mst .= " order by nwsm_prty asc";
// echo $sqryanounce_mst;
$srsanounce_mst = mysqli_query($conn, $sqryanounce_mst);
$cnt_anounce = mysqli_num_rows($srsanounce_mst);
if ($cnt_anounce > 0) {
	$anounce = mysqli_fetch_assoc($srsanounce_mst);
	$ancmt_id = $anounce['nwsm_id'];
	$ancmt_nm = $anounce['nwsm_name'];
	$anu_url=funcStrRplc($ancmt_nm);
	$ancmt_desc = $anounce['nwsm_desc'];
	$ancmt_link = $anounce['nwsm_lnk'];
	$ancmt_dt = $anounce['nwsm_dt'];
	$ancmt_img = $anounce['nwsm_img'];
	$ancmt_flenm = $anounce['nwsm_dwnfl'];
	$ancimg = $u_cat_nwsfldnm . $ancmt_img;
		if (($ancmt_img != "") && file_exists($ancimg)) {
		$notify_imgpth = $rtpth . $ancimg;
	} else {
		$notify_imgpth   =  $rtpth . $u_cat_bnrfldnm . 'default.jpg';
	} 
	$ancmt_fle = $u_dwnfl_upldpth . $ancmt_flenm;
		if (($ancmt_flenm != "") && file_exists($ancmt_fle)) {
		$notify_flepth = $rtpth . $ancmt_fle;
	} 
	
} else {
	header("Location:" . $rtpth . "home");
	exit();
}

			if ($notify_typ == 1) {
				$disp_nm = "Result Update";
			} else if ($notify_typ == 2) {
				$disp_nm = "College Notifications";
			} else if ($notify_typ == 3) {
				$disp_nm = "University Notifications";
			} else if ($notify_typ == 4) {
				$disp_nm = "Announcements";
			} else if ($notify_typ == 5) {
				$disp_nm = "Department Notifications";
			}
			$notify_typ=funcStrUnRplc($notify_typ);
			?>
<section class="page-bread">
				<div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
					<div class="page-banner-content">
						<h1><?php echo $ancmt_nm; ?></h1>
						<ul>
							<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
							

							<li><a href="<?php echo $rtpth.'notifications/'.$notify_typ;?>"><?php echo $disp_nm; ?></a></li>
							<!-- <li><a href="<?php echo $rtpth.'notifications/'.$notify_typ.'/'.$anu_url;?>"><?php echo $disp_nm; ?></a></li> -->
							<li><?php echo $ancmt_nm; ?></li>
						</ul>
					</div>
				</div>
			</section>



<div class="news-details-area section-pad-y">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
<div class="row">
  <div class="col-lg-8">
    <div class="news-details">
      <div class="news-simple-card">
        <img src="<?php echo $notify_imgpth;?>" alt="Image">
        <!-- <div class="list">
          <ul>
            <li><i class="flaticon-user"></i>By <a href="news-details.html">Admin</a></li>
            <li><i class="flaticon-tag"></i>Social Sciences</li>
            </ul>
          </div> -->
        <h2><?php echo $ancmt_nm;?></h2>
        <p><?php echo $ancmt_dt;?></p>
				<?php
				if($ancmt_link!=''){
					?>
					
					 <p><a href="<?php echo $ancmt_link;?>">Click here</a></p>
					<?php
				}
				?>
						<?php
				if($ancmt_flenm!=''&& file_exists($ancmt_fle)){
					?>
					
					 <p><a href="<?php echo $notify_flepth;?>"  download>Download file</a></p>
					<?php
				}
				?>

				<?php echo $ancmt_desc;?>
        </div>

      </div>
    </div>
 <!-- removed -->
</div>



  




    </div>
</div>


<?php include_once('footer.php'); ?>