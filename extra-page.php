<?php
// echo "<pre>";
// var_dump($_REQUEST);
// echo "</pre>";
// exit;
error_reporting(0);
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once "includes/inc_folder_path.php";
include_once 'includes/inc_paging_functions.php'; //Making paging validation
$ind_loc = $rtpth . "home";
include_once 'includes/inc_paging1.php'; //Includes pagination
if (isset($_REQUEST['abtus']) && (trim($_REQUEST['abtus']) != "")) {
	$abtus = glb_func_chkvl($_REQUEST['abtus']);
	$abt_name = funcStrUnRplc($abtus);
	$abtqry = "SELECT abtusm_id,abtusm_name,abtusm_desc,abtusm_imgnm,abtusm_lnk,abtusm_prty,abtusm_sts from  abtus_mst where abtusm_name='$abt_name'  and  abtusm_sts='a' ";
	$abtqry_mst 	= mysqli_query($conn, $abtqry);
	$cnt_abtqry   	= mysqli_num_rows($abtqry_mst);
	if ($cnt_abtqry > 0) {
		while ($abt_rows = mysqli_fetch_assoc($abtqry_mst)) {
			$ab_name = $abt_rows['abtusm_name'];
			$ab_id = $abt_rows['abtusm_id'];
			$ab_desc = $abt_rows['abtusm_desc'];
			$ab_lnk = $abt_rows['abtusm_lnk'];
		}
	}
	 else {
		header("Location:$ind_loc");
		exit();
	}
}
if (isset($_REQUEST['dwnld']) && (trim($_REQUEST['dwnld']) != "" ) && isset($_REQUEST['year']) && (trim($_REQUEST['year']) != "" )) {
	$dwnld = glb_func_chkvl($_REQUEST['dwnld']);
	$dwnld_nm = funcStrUnRplc($dwnld);
	$year = glb_func_chkvl($_REQUEST['year']);
	// $year_nm = funcStrUnRplc($year);
	 $dwnldqry = "SELECT dwnld_id,dwnld_name,dwnld_sts,dwnld_desc,dwnld_prty,dwnld_flenm, prodm_id,prodm_name from  vw_dwnld_dtl  where dwnld_name ='$dwnld_nm' and prodm_name='$year' and dwnld_sts='a'";
	$dwnldqry_mst 	= mysqli_query($conn, $dwnldqry);
	$dwn_abtqry   	= mysqli_num_rows($dwnldqry_mst);
	if ($dwn_abtqry > 0) {
		while ($dwn_rows = mysqli_fetch_assoc($dwnldqry_mst)) {
			$dwn_name = $dwn_rows['dwnld_name'];
			$dwn_id = $dwn_rows['dwnld_id'];
			$dwn_desc = $dwn_rows['dwnld_desc'];
			$dwn_yer = $dwn_rows['prodm_name'];
		}
	}
	else {
		header("Location:$ind_loc");
		exit();
	}
}
// else {
//     header("Location:$ind_loc");
//     exit();
// }
$page_title = "About | Chaitanya Bharathi Institute of Technology";
$page_seo_title = " About | Chaitanya Bharathi Institute of Technology";
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
<section class="page-bread">
	<div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
		<div class="page-banner-content">
			<?php
			if (isset($_REQUEST['dwnld']) && (trim($_REQUEST['dwnld']) != "")) {
			?>
				<h1><?php echo $dwn_name; ?></h1>
			<?php
			} else {
			?>
				<h1><?php echo $ab_name; ?></h1>
			<?php
			}
			?>

			<ul>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
				<?php
				if (isset($_REQUEST['dwnld']) && (trim($_REQUEST['dwnld']) != "")) {
				?>
					<li><?php echo $dwn_name; ?></li>
					<li><?php echo $dwn_yer; ?></li>
				<?php
				} else {
				?>
					<li><?php echo $ab_name; ?></li>

				<?php
				}
				?>

			</ul>
		</div>
	</div>
</section>

<div class="campus-information-area section-pad-y">
	<!-- <div class="container-fluid px-xxl-5 px-xl-5 px-lg-5 px-md-3 px-3"> -->
	<div class="container-fluid px-lg-3 px-md-3 px-2">
		<div class="row">
			<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-12 order-md-1 order-2">

				<div class="campus-content pr-20 ">
					<!-- <div class="section-title  text-start mb-3">
                        <h2>We’re talking education that sparks creativity</h2>
                    </div> -->
					<div class="campus-title mb-0">
						<?php
						if (isset($_REQUEST['dwnld']) && (trim($_REQUEST['dwnld']) != "")) {
						?>
							<p><?php echo $dwn_desc; ?> </p>
						<?php
						} else {
						?>
							<p><?php echo $ab_desc; ?> </p>
						<?php
						}
						?>


					</div>
				</div>
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-12 order-md-2 order-1 ">
				<?php
				// include_once('department-nav.php');
				?>
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>