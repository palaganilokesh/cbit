<?php
// echo"<pre>";
// var_dump($_REQUEST);
// echo"</pre>";
// exit;
error_reporting(0);
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once "includes/inc_folder_path.php";
include_once 'includes/inc_paging_functions.php'; //Making paging validation
$cntstart    = 0;
$rowsprpg = 8; //maximum rows per page
$pageNum     = 1; //page number
$ind_loc = $rtpth . "home";
include_once 'includes/inc_paging1.php'; //Includes pagination
global $u_cat_bnrfldnm, $rtpth;
if (isset($_REQUEST['pg']) && (trim($_REQUEST['pg']) != "")) {
	$loc = "&pg=" . $_REQUEST['pg'];
}
if (isset($_REQUEST['cntstart']) && (trim($_REQUEST['cntstart']) != "")) {
	$loc = "&cntstart=" . $_REQUEST['cntstart'];
}
if (
	isset($_REQUEST['catid']) && (trim($_REQUEST['catid']) != "") ||
	isset($_REQUEST['mnlnks']) && (trim($_REQUEST['mnlnks']) != "") ||
	isset($_REQUEST['prodid']) && (trim($_REQUEST['prodid']) != "") ||
	isset($_REQUEST['scatid']) && (trim($_REQUEST['scatid']) != "")
) {
	$scatid1 = glb_func_chkvl($_REQUEST['scatid']);
	$req_scat = funcStrUnRplc($scatid1);
	if ($req_scat == 'UG' || $req_scat == 'PG' || $req_scat == 'ug' || $req_scat == 'pg') {
		$admtyp = $req_scat;
		$req_scat = '';
	}
	$mnlnks1 = glb_func_chkvl($_REQUEST['mnlnks']);
	$req_mnlnks = funcStrUnRplc($mnlnks1);
	$prodid1 = glb_func_chkvl($_REQUEST['prodid']);
	$req_prodid = funcStrUnRplc($prodid1);
	$catid1 = glb_func_chkvl($_REQUEST['catid']);
	$req_cat = funcStrUnRplc($catid1);
	//or (isset($_REQUEST['txtsrchval']) && (trim($_REQUEST['txtsrchval']) != ''))){
	$sqrypgcnts_mst1 = "SELECT prodmnlnksm_id,prodmnlnksm_typ,prodmnlnksm_name,prodcatm_bnrimg,prodmnlnksm_sts,prodmnlnksm_prty,prodmnlnksm_bnrimg,prodcatm_id,prodcatm_name,prodcatm_typ,prodcatm_desc,prodcatm_bnrimg,prodcatm_admtyp";
	if ($_REQUEST['mnlnks'] == 'departments' ||  $req_scat != '') {
		$sqrypgcnts_mst1 .= ", prodscatm_id,prodscatm_name,prodscatm_desc,prodscatm_bnrimg,prodscatm_typ";
	}
	$sqrypgcnts_mst1 .= " from prodmnlnks_mst inner join prodcat_mst on prodcatm_prodmnlnksm_id =prodmnlnksm_id";
	if ($_REQUEST['mnlnks'] == 'departments' || $req_scat != '') {
		$sqrypgcnts_mst1 .= " inner join prodscat_mst on prodscatm_prodcatm_id=prodcatm_id";
	}
	$sqrypgcnts_mst1 .= " where prodmnlnksm_sts='a' and prodcatm_sts = 'a'";
	// echo $sqrypgcnts_mst1;exit;
	//-----------------------------------------------------------------------//
	if (isset($_REQUEST['catid']) && (trim($_REQUEST['catid']) != "")) {
		$catone_id1 = glb_func_chkvl($_REQUEST['catid']);
		$catone_id = funcStrUnRplc($catone_id1);
		$sqrypgcnts_mst1 .= " and prodcatm_name = '$catone_id'";
		$loc = "&catid=$catone_id";
	}


	if (isset($_REQUEST['scatid']) && (trim($_REQUEST['scatid']) != "")) {
		$cattwo_id2 = glb_func_chkvl($_REQUEST['scatid']);
		$cattwo_id_1 = $cattwo_id = funcStrUnRplc($cattwo_id2);
		if ($cattwo_id_1 == 'UG' || $cattwo_id_1 == 'PG' || $cattwo_id_1 == 'ug' || $cattwo_id_1 == 'pg') {
			$cattwo_id_1 = '';
		} else {
			$cattwo_id_1 = $cattwo_id_1;
		}
		if ($_REQUEST['mnlnks'] == 'admissions') {
			$sqrypgcnts_mst1 .= " and prodcatm_admtyp = '$admtyp' ";
		}
		if ($cattwo_id_1 != '') {
			$sqrypgcnts_mst1 .= " and prodscatm_name = '$cattwo_id' ";
			$loc .= "&scatid=$cattwo_id";
		}
	}

	if (isset($_REQUEST['mnlnks']) && (trim($_REQUEST['mnlnks']) != "")) {
		$mnlnks_id1 = glb_func_chkvl($_REQUEST['mnlnks']);
		$mnlnks_id = funcStrUnRplc($mnlnks_id1);
		// $sqrypgcnts_mst1 .= " and prodcatm_prodmnlnksm_id  = $mnlnks_id";
		$sqrypgcnts_mst1 .= " and prodmnlnksm_name  = '$mnlnks_id'";
		$loc .= "&mnlnks='$mnlnks_id'";
	}
	if ($_REQUEST['mnlnks'] == 'departments' || $req_scat != '') {
		$sqrypgcnts_mst1 .= " and prodscatm_sts  = 'a'";
	}
	// $pgqry = $sqrypgcnts_mst1;
	$sqrypgcnts_mst2 = "group by prodcatm_id order by prodcatm_prty asc";
	/*if(isset($_REQUEST['dept']) && (trim($_REQUEST['dept'])!="")){
			$sqrypgcnts_mst2 .= " limit 1";
		}*/
	$sqrypgcnts_mst  	= $sqrypgcnts_mst1 . " " . $sqrypgcnts_mst2;
	// echo $sqrypgcnts_mst;
	$srspgcnts_mst 		= mysqli_query($conn, $sqrypgcnts_mst);
	$cnt 		   		= $offset;
	$cnt_recpgcnts    	= mysqli_num_rows($srspgcnts_mst);
	$title 		   		= "";
	if ($cnt_recpgcnts > 0) {
		$srowspgcnts_mst   = mysqli_fetch_assoc($srspgcnts_mst);
		$mnlnks_id	        = $srowspgcnts_mst['prodmnlnksm_id'];
		$cattwo_id 	        = $srowspgcnts_mst['prodscatm_id'];
		$catone_id	        = $srowspgcnts_mst['prodcatm_id'];
		$prodscatm_name		= $srowspgcnts_mst['prodscatm_name'];
		$cn_scat_url = funcStrRplc($prodscatm_name);
		$prodscatm_name1		= $prodscatm_name;
		$prodcatm_name		= $srowspgcnts_mst['prodcatm_name'];
		$cn_cat_url = funcStrRplc($prodcatm_name);
		$prodcatm_bimg		= $srowspgcnts_mst['prodcatm_bnrimg'];
		$prodmnlnksm_typ		= $srowspgcnts_mst['prodmnlnksm_typ'];
		$prodmnlnksm_name		= $srowspgcnts_mst['prodmnlnksm_name'];
		$cn_mn_url = funcStrRplc($prodmnlnksm_name);
		$prodmnlnksm_name1		= $prodmnlnksm_name;
		$prodscatm_desc  = $srowspgcnts_mst['prodscatm_desc'];
		$prodscatm_typ  = $srowspgcnts_mst['prodscatm_typ'];
		$prodcat_bnr	    = $srowspgcnts_mst['prodcatm_bnrimg'];
		$prodcat_pth	    = $u_cat_bnrfldnm . $prodcat_bnr;
		$prodscat_bnr 	    = $srowspgcnts_mst['prodscatm_bnrimg'];
		$prodmnlnksm_bnr 	    = $srowspgcnts_mst['prodmnlnksm_bnrimg'];
		$bngimgpth1 = $u_mnlnks_bnrfldnm . $prodmnlnksm_bnr;

		if (($catone_id != '' || isset($catone_id))) {

			$title = $prodcatm_name;
			$bngimgpth = $u_cat_bnrfldnm . $prodcat_bnr;
			if ($prodcat_bnr != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else if ($prodmnlnksm_bnr != "" && file_exists($bngimgpth1)) {
				$bnrimgpth = $rtpth . $bngimgpth1;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		}
	 if (($cattwo_id_1 != '' || isset($cattwo_id_1))) {

		$title = $prodscatm_name;
			$bngimgpth = $u_scat_bnrfldnm . $prodscat_bnr;
			if ($prodscat_bnr != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else if ($prodmnlnksm_bnr != "" && file_exists($bngimgpth1)) {
				$bnrimgpth = $rtpth . $bngimgpth1;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		}

		else {
			// echo "lokesh";
			$title = $prodcatm_name;
			$bngimgpth = $u_cat_bnrfldnm . $prodcatm_bimg;
			if ($prodcatm_bimg != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else if ($prodmnlnksm_bnr != "" && file_exists($bngimgpth1)) {
				$bnrimgpth = $rtpth . $bngimgpth1;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		}
		if ($_REQUEST['mnlnks'] == 'departments') {
			$title = "$prodscatm_name";
			$bngimgpth = $u_cat_bnrfldnm . $prodcat_bnr;
			if ($prodcat_bnr != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else if ($prodmnlnksm_bnr != "" && file_exists($bngimgpth1)) {
				$bnrimgpth = $rtpth . $bngimgpth1;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		}
		if ($_REQUEST['mnlnks'] == 'admissions') {

			$title = $prodcatm_name;
			$bngimgpth = $u_cat_bnrfldnm . $prodcat_bnr;
			if ($prodcat_bnr != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else if ($prodmnlnksm_bnr != "" && file_exists($bngimgpth1)) {
				$bnrimgpth = $rtpth . $bngimgpth1;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		}
	} else {
		header("Location:$ind_loc");
		exit();
	}
} else {
	header("Location:$ind_loc");
	exit();
}
//if($srowspgcnts_mst['prodmnlnksm_typ'] == 'g'){
//}
$current_page = '';
include('header.php');
//Banner Starts
// $dsp_bnrdtl = "";
/*if($db_catone_hmpgtyp =='2'){
			$dsp_bnrdtl ="<div class='bannerContainer-inner'>";
		}*/
// if (($pgcnt_bnr != "") && file_exists($pgcnt_pth)) {
// 	$dsp_bnrdtl .= "<div class='bannerContainer-inner'><img src='$pgcnt_pth' class='img-responsive'/></div>";
// }
// /*elseif(($mnlnksbnr != "") && file_exists($mnlnkspth)){
// 		$dsp_bnrdtl .="<div class='bannerContainer-inner'><img src='$mnlnkspth' class='img-responsive'/></div>";
// 	}*/
// 	 elseif (($prodscat_bnr != "") && file_exists($prodscat_pth)) {
// 	$dsp_bnrdtl .= "<div class='bannerContainer-inner'><img src='$prodscat_pth' class='img-responsive'/></div>";
// } elseif (($prodcat_bnr != "")  && file_exists($prodcat_pth)) {
// 	$dsp_bnrdtl .= "<div class='bannerContainer-inner '><img src='$prodcat_pth'  /></div>";
// } else {
// 	$dsp_bnrdtl .= "<divclass='page-banner-area'><img src='catbnr/default-banner.jpg'  /></div>";
// }
$dsp_bnrdtl .= "";
//echo $dsp_bnrdtl;
//Banner Ends
$page_title = "About Us | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "About Us | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
//include('header.php');
?>
<style>
	.section-title h2 {
		font-size: 20px;
	}
</style>
<div class="page-banner-area bg-2" style="background-image:url(<?php echo $rtpth . $bnrimgpth; ?>) ;">
</div>
<!-- <div class="page-banner-area bg-2">
	</div> -->
<section class="page-bread">
	<div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
		<div class="page-banner-content">
			<h1><?php echo $title; ?></h1>
			<ul>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
				<?php
				if ($_REQUEST['mnlnks'] == 'admissions') {

					$bdadmson = "SELECT prodcatm_name from prodcat_mst where prodcatm_prodmnlnksm_id='$mnlnks_id' group by  prodcatm_id order by prodcatm_prty asc limit 1";
					$res_adm_cats = mysqli_query($conn, $bdadmson);
					$value_adm_cat = mysqli_fetch_assoc($res_adm_cats);
					$bred_admcat_url = $value_adm_cat['prodcatm_name'];
					$adm_url = funcStrRplc($bred_admcat_url);
				?>

					<li><a href="<?php echo $rtpth . $cn_mn_url . '/' . $adm_url . '/' . $admtyp; ?>"><?php echo $prodmnlnksm_name; ?></a></li>

					<li><?php echo $prodcatm_name; ?></li>
				<?php
				}
				?>
				<?php if ($_REQUEST['mnlnks'] != 'departments' && $_REQUEST['mnlnks'] != 'admissions') {
					$bdscat = "SELECT prodcatm_name from prodcat_mst where prodcatm_prodmnlnksm_id='$mnlnks_id' group by  prodcatm_id order by prodcatm_prty asc limit 1";
					$res_cats = mysqli_query($conn, $bdscat);
					$value_cat = mysqli_fetch_assoc($res_cats);
					$bred_cat_url = $value_cat['prodcatm_name'];
					$brd_cat_url = funcStrRplc($bred_cat_url);
				?>

		<li><a href="<?php echo $rtpth . $cn_mn_url . '/' . $brd_cat_url; ?>"><?php echo $prodmnlnksm_name; ?></a></li>
		<?php
		if($cattwo_id_1!='' && $_REQUEST['mnlnks'] != 'departments' && $_REQUEST['mnlnks'] != 'admissions'){
			 $bdscat_new = "SELECT prodscatm_name from prodscat_mst where prodscatm_prodmnlnksm_id='$mnlnks_id' and prodscatm_prodcatm_id='$catone_id' group by  prodscatm_id order by prodscatm_prty asc limit 1";
					$res_scats = mysqli_query($conn, $bdscat_new);
					$value_scat = mysqli_fetch_assoc($res_scats);
					$bred_scat_nw_url = $value_scat['prodscatm_name'];
					$brd_scat_nw_url = funcStrRplc($bred_scat_nw_url);
					?>
					<li><a href="<?php echo $rtpth . $cn_mn_url . '/' . $brd_cat_url.'/'.$brd_scat_nw_url; ?>"><?php echo $prodcatm_name; ?></a></li>
					<!-- <li><?php echo $prodcatm_name; ?></li> -->
					<?php
		}
		else{
			?>
					<li><?php echo $prodcatm_name; ?></li>
					<?php
		}
		?>

				<?php
				}
				?>
				<?php
				if ($_REQUEST['mnlnks'] == 'departments') {
				?>
					<?php $bdqry = "SELECT prodscatm_name from prodscat_mst where prodscatm_prodcatm_id='$catone_id' group by  prodscatm_prodcatm_id order by prodscatm_prty asc limit 1";
					$res = mysqli_query($conn, $bdqry);
					$value = mysqli_fetch_assoc($res);
					$bred_scat_url = $value['prodscatm_name'];
					$brd_scat_url = funcStrRplc($bred_scat_url);
					?>
					<li><a href="<?php echo $rtpth; ?>departments"><?php echo $prodmnlnksm_name; ?></a></li>
					<li><a href="<?php echo $rtpth . $cn_mn_url . '/' . $cn_cat_url . '/' . $brd_scat_url; ?>"><?php echo $prodcatm_name; ?></a></li>
					<li><?php echo $prodscatm_name1; ?></li>
				<?php
				}
				if($cattwo_id_1!='' && $_REQUEST['mnlnks'] != 'departments' && $_REQUEST['mnlnks'] != 'admissions'){
					?>
					<li><?php echo $prodscatm_name1; ?></li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
</section>
<!-- department notifications start -->
<!-- minimum add 4 for css -->
<?php
if ($_REQUEST['mnlnks'] == 'departments') {
	$sqrydept_mst =  "SELECT nwsm_id,nwsm_name,nwsm_sts,nwsm_prty,nwsm_typ,nwsm_dwnfl,date_format(nwsm_dt,'%d-%m-%Y') as nwsm_dt,nwsm_desc,nwsm_lnk	from nws_mst where nwsm_id != ''and nwsm_sts='a' and nwsm_typ=5  and nwsm_dept='$catone_id' order by nwsm_prty asc";
	$srsdept_ntf_mst = mysqli_query($conn, $sqrydept_mst);
	$cnt_dept = mysqli_num_rows($srsdept_ntf_mst);
?>
		<?php
			if ($cnt_dept > 0) {
			?>
	<div class="container-fluid px-0">
		<div class="depart-nitif-holder py-1">

				<div class="an-label">
					<div class="an-label-holder">
						<p>Notifications </p>
					</div>
				</div>

			<marquee onmouseover="this.stop();" onmouseout="this.start();">
				<div class="header-left-content header-right-content">
					<div class="list top-not-links depart-link-scroll">
						<ul>
							<?php
							while ($dept_ntf = mysqli_fetch_assoc($srsdept_ntf_mst)) {
								$dept_ntf_id = $dept_ntf['nwsm_id'];
								$dept_ntf_nm = $dept_ntf['nwsm_name'];
								$dept_url = funcStrRplc($dept_ntf_nm);
								$dept_ntf_desc = $dept_ntf['nwsm_desc'];
								$dept_ntf_link = $dept_ntf['nwsm_lnk'];
								$dept_ntf_dt = $dept_ntf['nwsm_dt'];
								$dept_ntf_typ = $dept_ntf['nwsm_typ'];
							?>
								<li>
									<a href="<?php echo $rtpth . 'latest-notifications/' . $dept_ntf_typ . '/' . $dept_url . '_' . $dept_ntf_id; ?>"> <?php echo $dept_ntf_nm; ?></a>
									<!-- <img src="<?php echo $rtpth; ?>assets/images/icon/new.gif" alt=""> -->
								</li>
							<?php  }
							?>

						</ul>
					</div>
				</div>
			</marquee>
		</div>
	</div>
<?php
}
}
?>
<!-- department notifications end -->
<div class="campus-information-area section-pad-y">
	<div class="container-fluid px-lg-3 px-md-3 px-2">
		<div class="row">
			<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-12 order-md-1 order-2">
				<!-- category level gallery -->
				<div class="campus-content pr-20 ">
					<?php
					$sqryphtcat_mst1 = "SELECT catm_id,catm_name,catm_img,catm_sts,catm_prty from  catimg_dtl where  catm_cat_id  ='$catone_id ' and 	catm_sts = 'a'   order by 	catm_prty asc";
					$srsphtcat_dtl1 = mysqli_query($conn, $sqryphtcat_mst1);
					$cntrec_phtcat1 = mysqli_num_rows($srsphtcat_dtl1);
					if ($cntrec_phtcat1 > 0) {
					?>
						<!-- <h3>Gallery Section</h3> -->
						<div class="cont ">
							<div class="demo-gallery ">
								<ul id="lightgallery" class="list-unstyled row gx-xxl-1 gx-xl-1 gx-lg-1 gx-md-2 gx-0 ">
									<?php
									while ($srowsphtcat_dtl1 = mysqli_fetch_assoc($srsphtcat_dtl1)) {
										$phtid         = $srowsphtcat_dtl1['catm_id'];
										//$phtid         = $srowsphtcat_dtl1['phtd_desc'];
										$pht_name      = $srowsphtcat_dtl1['catm_name'];
										$bphtimgnm     = $srowsphtcat_dtl1['catm_img'];
										$bimgpath      = $u_cat_imgfldnm . $bphtimgnm;
										if (($bphtimgnm != "") && file_exists($bimgpath)) {
											$galryimages = $rtpth . $bimgpath;
										} else {
											$galryimages   = $rtpth . $gusrglry_fldnm . 'default.jpg';
										}
									?>
										<li class="col-xxl-4 col-lg-4 col-md-4 col-6 mb-2" data-responsive="<?php echo $galryimages; ?> 375, <?php echo $galryimages; ?> 480, <?php echo $galryimages; ?> 800" data-src="<?php echo $galryimages; ?> " data-sub-html="<h4>Category 6</h4>">
											<a href="">
												<img class="img-responsive w-100" src="<?php echo $galryimages; ?>">
												<div class="demo-gallery-poster">
													<img src="https://sachinchoolur.github.io/lightgallery.js/static/img/zoom.png">
												</div>
											</a>
											<p><?php echo $pht_name; ?></p>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					<?php
					}
					?>
				</div>
				<?php
				// <!-- gallery  menu based on gallery section on admin side-->
				if ($prodscatm_typ == 2) {
					$sqryphtcat_mst = "SELECT phtd_id,phtcatm_name, phtd_phtcatm_id,phtcatm_img, phtd_name, phtd_desc,phtd_rank, phtd_sts, phtd_crtdon, phtd_crtdby, phtd_mdfdon, phtd_mdfdby, phtm_id, phtm_phtd_id, phtm_phtcatm_id, phtm_simgnm, phtm_simg, phtm_prty, phtm_sts, phtm_crtdon, phtm_crtdby, phtm_mdfdon, phtm_mdfdby,phtcatm_name,phtcatm_id,phtcatm_desc,phtcatm_deprtmnt from vw_phtd_phtm_mst
					left join phtcat_mst on  phtcat_mst.phtcatm_id = vw_phtd_phtm_mst.phtm_phtcatm_id where phtcatm_deprtmnt='$catone_id' and phtm_sts = 'a' and phtcatm_sts = 'a' and phtd_sts = 'a' and phtcatm_typ = 'd' group by phtcatm_id order by  phtcatm_prty asc";
					$srsphtcat_dtl = mysqli_query($conn, $sqryphtcat_mst);
					$cntrec_phtcat = mysqli_num_rows($srsphtcat_dtl);
					if ($cntrec_phtcat > 0) {
				?>
						<div class="campus-content pr-20 ">
							<div class="cont ">
								<div class="demo-gallery ">
									<ul id="" class="list-unstyled row gx-xxl-1 gx-xl-1 gx-lg-1 gx-md-2 gx-0 ">
										<?php
										while ($srowsphtcat_dtl = mysqli_fetch_assoc($srsphtcat_dtl)) {
											$phtcatid         = $srowsphtcat_dtl['phtcatm_id'];
											$phtcat_name      = $srowsphtcat_dtl['phtcatm_name'];
											$dept_pht_url = funcStrRplc($phtcat_name);
											$phtcat_bnrimg      = $srowsphtcat_dtl['phtcatm_img'];
											// $phtcatm_desc  = $srowsphtcat_dtl['phtcatm_desc'];
											// $bphtimgnm     = $srowsphtcat_dtl['phtm_simg'];
											$galpath      = $gusrglry_fldnm . $phtcat_bnrimg;
											if (($phtcat_bnrimg != "") && file_exists($galpath)) {
												$galryimgpth = $rtpth . $galpath;
											} else {
												$galryimgpth   = $rtpth . $gusrglry_fldnm . 'default.jpg';
											}
										?>
											<li class="col-xxl-4 col-lg-4 col-md-4 col-6 mb-2" data-responsive="<?php echo $galryimgpth; ?> 375, <?php echo $galryimgpth; ?> 480, <?php echo $galryimgpth; ?> 800 " data-src="<?php echo $galryimgpth; ?> " data-sub-html="<h4>Category 1</h4>">

												<a href="<?php echo $rtpth . 'dept-gallery/' . $dept_pht_url . '/' . $cn_mn_url . '/' . $cn_cat_url . '/' . $cn_scat_url . '_' . $phtcatid; ?>">
													<img class="img-responsive w-100" src="<?php echo $galryimgpth; ?>">
													<div class="demo-gallery-poster">
													</div>
												</a>
												<h2 class="cat-caption"><?php echo $phtcat_name; ?></h2>
											</li>
										<?php
										}
										?>
									</ul>
								</div>
							</div>
						</div>
						<?php
					}
				}
				// end gallery
				mysqli_data_seek($srspgcnts_mst, 0);
				$cnt_pgcnts    = mysqli_num_rows($srspgcnts_mst);
				if ($cnt_pgcnts > 0) {
					$dsp_dtl = "";
					/*if($db_catone_hmpgtyp =='2'){
				$dsp_dtl ="";
			}*/
					while ($srowspgcnts_mst = mysqli_fetch_assoc($srspgcnts_mst)) {
						//if($cattwo_id !=''){
						$prodcatm_id 	 = $srowspgcnts_mst['prodcatm_id'];
						$prodscatm_id 	 = $srowspgcnts_mst['prodscatm_id'];
						$prodcatm_name	 = $srowspgcnts_mst['prodcatm_name'];
						$prodscatm_name	 = $srowspgcnts_mst['prodscatm_name'];
						// $prodcatm_desc = preg_replace('/style=\\"[^\\"]*\\"/', '', $srowspgcnts_mst['prodcatm_desc']);
						// $prodscatm_desc = preg_replace('/style=\\"[^\\"]*\\"/', '', $srowspgcnts_mst['prodscatm_desc']);
						$prodcatm_desc = $srowspgcnts_mst['prodcatm_desc'];
						$prodscatm_desc = $srowspgcnts_mst['prodscatm_desc'];
						if ($_REQUEST['mnlnks'] == 'departments' || $req_scat != '') {
							echo $prodscatm_desc;
						} else {
							echo $prodcatm_desc;
						}
						$testqns = "SELECT pgqnsd_id,pgqnsd_pgcntsd_id,pgqnsd_name,pgqnsd_vdo,pgqnsd_sts,pgqnsd_prty from  pgqns_dtl where";
						if ($_REQUEST['mnlnks'] == 'departments' || $req_scat != '') {
							$testqns .= "	pgqnsd_pgcntsd_id='$prodscatm_id' and pgqnsd_sts='a'and  pgqnsd_id!='' order by pgqnsd_prty asc";
						} else {
							$testqns .= "	pgqnsd_pgcntsd_id='$prodcatm_id' and pgqnsd_sts='a'and  pgqnsd_id!='' order by pgqnsd_prty asc";
						}
						// echo 	$testqns;exit;
						$testqnsres = mysqli_query($conn, $testqns);
						$cnt_pgcnts1    = mysqli_num_rows($testqnsres);
						if ($cnt_pgcnts1 > 0) {
						?>
							<div class="faq-left-content depart-acc-options">
								<div class="accordion" id="departmentLinks">
									<?php
									$h = 1;
									while ($testqnsrow = mysqli_fetch_assoc($testqnsres)) {
										//	$testqnsrow=mysqli_fetch_assoc($testqnsres);
										$pgqnsd_id = $testqnsrow['pgqnsd_id'];
										$pgqnsd_pgcntsd_id = $testqnsrow['pgqnsd_pgcntsd_id'];
										$pgqnsd_name1 = $testqnsrow['pgqnsd_name'];
										$pgqnsd_name2 = explode("$h-", $pgqnsd_name1);
										$pgqnsd_name = implode($pgqnsd_name2);
										$pgqnsd_vdo = $testqnsrow['pgqnsd_vdo'];
										$pgqnsd_sts = $testqnsrow['pgqnsd_sts'];
									?>
										<div class="accordion-item">
											<h2 class="accordion-header mb-0" id="heading-1">
												<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#po<?php echo $h; ?>" aria-expanded="false" aria-controls="po<?php echo $h; ?>">
													<?php echo $pgqnsd_name; ?>
												</button>
											</h2>
											<div id="po<?php echo $h; ?>" class="accordion-collapse collapse" aria-labelledby="heading-1" data-bs-parent="#departmentLinks" style="">
												<div class="accordion-body py-3">
													<p><?php echo $pgqnsd_vdo; ?></p>
												</div>
											</div>
										</div>
									<?php
										$h++;
									}
									?>
								</div>
							</div>
				<?php
						}
						//}
					}
				}
				?>
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-12 order-md-2 order-1 ">
				<?php
				include('catrightblock.php'); ?>
				<!-- <?php include('imprightblock.php'); ?> -->
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>