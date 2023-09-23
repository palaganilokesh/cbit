<?php
// echo "<pre>";
// var_dump($_REQUEST);
// echo"</pre>";
error_reporting(0);
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once 'includes/inc_config.php'; //Making paging validation
include_once 'includes/inc_folder_path.php'; //Making paging validation
include_once 'includes/inc_paging_functions.php'; //Making paging validation
include_once 'includes/inc_paging1.php'; //Includes pagination
$notify_typ			= glb_func_chkvl($_REQUEST['notify_typ']);
 if ($notify_typ == 2) {
	$disp_nm = "College Notifications";
}  else if ($notify_typ == 4) {
	$disp_nm = "Announcements";
} else if ($notify_typ == 5) {
	$disp_nm = "Department Notifications";
}
$page_title = "$disp_nm | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "$disp_nm | Chaitanya Bharathi Institute of Technology";
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
<script language="javascript">
 	function get_notification()
  {

  	var acyr = $("#news_yr").val();
		var dept_id = $("#lstprodcat").val();
		var not_typ=$("#not_type").val();

  	$.ajax({
  		type: "POST",
  		url: "<?php echo $rtpth;?>filters.php",
  		// data:'not_dept_id='+dept_id+'&not_yr='+acyr,
			data:'not_yr='+acyr+'&not_dept_id='+dept_id+'&not_typ='+not_typ,
  		success: function(data){
  			// alert(data)
  			$("#filt_not1").html(data);
  		}
  	});

  }
  </script>
<div class="page-banner-area bg-2">

</div>
<?php
$sqryanounce_mst = "SELECT nwsm_id,nwsm_name,nwsm_sts,nwsm_prty,nwsm_typ,nwsm_img,nwsm_dwnfl,date_format(nwsm_dt,'%d-%m-%Y') as nwsm_dt,nwsm_desc,nwsm_lnk	from nws_mst where nwsm_id != ''and nwsm_sts='a' ";

if (isset($_REQUEST['notify_typ']) && trim($_REQUEST['notify_typ']) != "") {
	$notify_typ			= glb_func_chkvl($_REQUEST['notify_typ']);
	$sqryanounce_mst .= " and nwsm_typ='$notify_typ' ";
}
if (isset($_REQUEST['notid']) && trim($_REQUEST['notid']) != "") {
	$notid1		= glb_func_chkvl($_REQUEST['notid']);
	$notnm		= funStrUrlDecode($notid1);
	$txt = explode('_', $notnm);
	$ab_id = $txt[1];
	$sqryanounce_mst .= "  and (nwsm_name='$notnm' or nwsm_id='$ab_id') ";
}
$sqryanounce_mst .= " order by nwsm_prty asc";
// echo $sqryanounce_mst;
$srsanounce_mst = mysqli_query($conn, $sqryanounce_mst);
$cnt_anounce = mysqli_num_rows($srsanounce_mst);
?>
<section class="page-bread">
	<div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
		<div class="page-banner-content">
			<?php
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
			// $page_title = "$disp_nm | Chaitanya Bharathi Institute of Technology";
			?>

			<h1><?php echo $disp_nm; ?></h1>
			<ul>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
				<li><?php echo $disp_nm; ?></li>
			</ul>
		</div>
	</div>
</section>
<input type="hidden" id="not_type" value="<?php echo $notify_typ;?>"/>
  <div class="col-md-12">
    <div class="row justify-content-left align-items-center mt-3">
      <div class="col-sm-3">
        <div class="form-group">
          <select name="news_yr" id="news_yr" class="form-control" onchange=get_notification();>
            <option value="">Select Academic Year </option>
            <?php
            $sqry_evnt = "SELECT nwsm_acyr from nws_mst where nwsm_sts='a' and nwsm_typ='$notify_typ' group by  nwsm_acyr";
            $exqury = mysqli_query($conn, $sqry_evnt);
            $cnt_rows = mysqli_num_rows($exqury);
            while ($filter = mysqli_fetch_assoc($exqury)) {
              $ex_year = $filter['nwsm_acyr'];
            ?>
            <option value="<?php echo $ex_year; ?>" <?php if (isset($_REQUEST['news_yr']) && trim($_REQUEST['news_yr']) == $catid) {echo 'selected';} ?>><?php echo $ex_year; ?></option>

            <?php
            }
            ?>
          </select>
        </div>
      </div>
			<?php if($notify_typ == 5){
				?>
				    <div class="col-sm-3">
        <div class="form-group">
          <select name="lstprodcat" id="lstprodcat" class="form-control" onchange=get_notification()>
            <option value="">--Select Department--</option>
            <?php
            $sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name,nwsm_dept,nwsm_typ from prodcat_mst
            inner join nws_mst on nwsm_dept=prodcatm_id
            where prodcatm_typ='d' and prodcatm_admtyp='UG' and nwsm_typ='$notify_typ' group by prodcatm_name order by prodcatm_name";
            $rsprodcat_mst = mysqli_query($conn, $sqryprodcat_mst);
            $cnt_prodcat = mysqli_num_rows($rsprodcat_mst);
            if ($cnt_prodcat > 0) {   ?>
              <option disabled>-- UG --</option>
              <?php while ($rowsprodcat_mst = mysqli_fetch_assoc($rsprodcat_mst)) {
                $catid = $rowsprodcat_mst['prodcatm_id'];
                $catname = $rowsprodcat_mst['prodcatm_name'];
              ?>
               <option value="<?php echo $catid; ?>" <?php if (isset($_REQUEST['lstprodcat']) && trim($_REQUEST['lstprodcat']) == $catid) {echo 'selected';} ?>><?php echo $catname; ?></option>
               <?php
              }
            }
            $sqryprodcat_mst1 = "SELECT prodcatm_id,prodcatm_name,nwsm_dept,nwsm_typ from prodcat_mst
             inner join nws_mst on nwsm_dept=prodcatm_id
             where prodcatm_typ='d' and prodcatm_admtyp='PG' and nwsm_typ='$notify_typ' group by prodcatm_name order by prodcatm_name";
            $rsprodcat_mst1 = mysqli_query($conn, $sqryprodcat_mst1);
            $cnt_prodcat1 = mysqli_num_rows($rsprodcat_mst1);
            if ($cnt_prodcat1 > 0) {   ?>
              <option disabled>-- PG --</option>
              <?php while ($rowsprodcat_mst1 = mysqli_fetch_assoc($rsprodcat_mst1)) {
                $catid = $rowsprodcat_mst1['prodcatm_id'];
                $catname = $rowsprodcat_mst1['prodcatm_name'];
              ?>
              <option value="<?php echo $catid; ?>" <?php if (isset($_REQUEST['lstprodcat']) && trim($_REQUEST['lstprodcat']) == $catid) {echo 'selected';} ?>><?php echo $catname; ?></option>

            <?php
              }
            }
            ?>
          </select>
        </div>
      </div>
				<?php
			}?>
 </div>
  </div>
<div class="latest-news-area section-pad-y">
	<div class="container-fluid px-lg-3 px-md-3 px-2">
		<div class="row">
			<div class="col-lg-8">
				<div class="latest-news-left-content pr-20 ">
					<div class="latest-news-card-area">
						<h3>Latest <?php echo $disp_nm; ?></h3>
						<div class="row" id="filt_not1">
							<?php
							while ($anounce = mysqli_fetch_assoc($srsanounce_mst)) {
								$ancmt_id = $anounce['nwsm_id'];
								$ancmt_nm = $anounce['nwsm_name'];
								$ancmt_url = funcStrRplc($ancmt_nm);
								$ancmt_desc = $anounce['nwsm_desc'];
								$ancmt_link = $anounce['nwsm_lnk'];
								$ancmt_dt = $anounce['nwsm_dt'];
								$ancmt_img = $anounce['nwsm_img'];
								$ancmt_fle = $anounce['nwsm_dwnfl'];
								$ancimg = $u_cat_nwsfldnm . $ancmt_img;
								//	$imgpath = $gusrbrnd_upldpth . $imgnm;
								if (($ancmt_img != "") && file_exists($ancimg)) {
									$notify_imgpth = $rtpth . $ancimg;
								} else {
									$notify_imgpth   =  $rtpth . $u_cat_bnrfldnm . 'default.jpg';
								}

							?>

								<div class="col-lg-6 col-md-6">
									<div class="single-news-card">
										<div class="news-img">

											<a href="<?php echo $rtpth . 'latest-notifications/' . $notify_typ . '/' . $ancmt_url . '_' . $ancmt_id; ?>"><img src="<?php echo $notify_imgpth; ?>" alt="Image"></a>
										</div>
										<div class="announcements-content">

											<a href="<?php echo $rtpth . 'latest-notifications/' . $notify_typ . '/' . $ancmt_url . '_' . $ancmt_id; ?>">
												<h3><?php echo $ancmt_nm; ?></h3>
											</a>
											<a href="<?php echo $rtpth . 'latest-notifications/' . $notify_typ . '/' . $ancmt_url . '_' . $ancmt_id; ?>" class="read-more-btn">Read More<i class="flaticon-next"></i></a>
										</div>
									</div>
								</div>
							<?php } ?>


						</div>
					</div>

				</div>
			</div>
			<!-- removed -->
		</div>
	</div>
</div>


<?php include_once('footer.php'); ?>