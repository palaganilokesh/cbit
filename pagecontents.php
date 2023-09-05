<?php
// echo"<pre>";
// var_dump($_REQUEST);
// echo"</pre>";
error_reporting(0);
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once "includes/inc_folder_path.php";
include_once 'includes/inc_paging_functions.php'; //Making paging validation
$cntstart    = 0;
$rowsprpg = 8; //maximum rows per page
$pageNum     = 1; //page number
include_once 'includes/inc_paging1.php'; //Includes pagination
global $u_cat_bnrfldnm;
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
	//or (isset($_REQUEST['txtsrchval']) && (trim($_REQUEST['txtsrchval']) != ''))){	
	$sqrypgcnts_mst1 = "SELECT
		prodmnlnksm_id,prodmnlnksm_name,prodmnlnksm_bnrimg,prodmnlnksm_typ,
		prodmnlnksm_sts,prodmnlnksm_prty,
		pgcntsd_id,prodscatm_id,prodcatm_id,prodscatm_dpthead,prodscatm_dptname,
		pgcntsd_name,pgcntsd_desc,prodscatm_name,prodscatm_desc,pgcntsd_lnk,
		prodcatm_name,pgcntsd_fle,prodcatm_typ,prodcatm_desc,prodscatm_dpttitle,
		 prodcatm_bnrimg,prodscatm_bnrimg,pgcntsd_bnrimg,pgcntsd_prodmnlnks_id,prodscatm_typ
	 from
		vw_pgcnts_prodcat_prodscat_mst
	where
		prodmnlnksm_sts='a' and
		prodcatm_sts = 'a' and
		pgcntsd_sts = 'a' ";
	// echo $sqrypgcnts_mst1;exit;	
	//-----------------------------------------------------------------------//	
	if (isset($_REQUEST['catid']) && (trim($_REQUEST['catid']) != "")) {
		$catone_id1 = glb_func_chkvl($_REQUEST['catid']);
		$catone_id=funcStrUnRplc($catone_id1);
		$sqrypgcnts_mst1 .= " and prodcatm_name ='$catone_id'";
		$loc = "&catid=$catone_id";
	}
	if (isset($_REQUEST['prodid']) && (trim($_REQUEST['prodid']) != "")) {
		$prodid_12 = $prodid = glb_func_chkvl($_REQUEST['prodid']);
			$prodid=funcStrUnRplc($prodid_12);
		$sqrypgcnts_mst1 .= " and pgcntsd_name = '$prodid' ";
		$loc .= "&prodid=$prodid";
	}
	if (isset($_REQUEST['scatid']) && (trim($_REQUEST['scatid']) != "")) {
		$cattwo_id1 = glb_func_chkvl($_REQUEST['scatid']);
		$cattwo_id=funcStrUnRplc($cattwo_id1);
		$sqrypgcnts_mst1 .= " and prodscatm_name = '$cattwo_id'";
		$loc .= "&scatid=$cattwo_id";
	}
	if (isset($_REQUEST['mnlnks']) && (trim($_REQUEST['mnlnks']) != "")) {
		$mnlnks_id1 = glb_func_chkvl($_REQUEST['mnlnks']);
			$mnlnks_id=funcStrUnRplc($mnlnks_id1);
		$sqrypgcnts_mst1 .= " and prodmnlnksm_name = '$mnlnks_id'";
		$loc .= "&mnlnks=$mnlnks_id";
	}
	$pgqry = $sqrypgcnts_mst1;
	$sqrypgcnts_mst2 = "group by pgcntsd_id order by pgcntsd_prty,prodscatm_prty,prodcatm_prty,prodmnlnksm_prty desc";
	/*if(isset($_REQUEST['dept']) && (trim($_REQUEST['dept'])!="")){			
		$sqrypgcnts_mst2 .= " limit 1";
	}*/
	$sqrypgcnts_mst  	= $sqrypgcnts_mst1 . " " . $sqrypgcnts_mst2;
	// echo $sqrypgcnts_mst;exit;
	$srspgcnts_mst 		= mysqli_query($conn, $sqrypgcnts_mst);
	$cnt 		   		= $offset;
	$cnt_recpgcnts    	= mysqli_num_rows($srspgcnts_mst);
	$title 		   		= "";
	if ($cnt_recpgcnts > 0) {
		$srowspgcnts_mst   = mysqli_fetch_assoc($srspgcnts_mst);
		$pgcnt_id5	        = $srowspgcnts_mst['pgcntsd_id'];
		$mnlnks_id	        = $srowspgcnts_mst['prodmnlnksm_id'];
		$cattwo_id 	        = $srowspgcnts_mst['prodscatm_id'];
		$catone_id5	        = $srowspgcnts_mst['prodcatm_id'];
		$prodscatm_name5		= $srowspgcnts_mst['prodscatm_name'];
		$pgcnt_scat_url=funcStrRplc($prodscatm_name5);
		$pgcntnt_name	= $srowspgcnts_mst['pgcntsd_name'];
		$pgcnt_nm_url=funcStrRplc($pgcntnt_name);
		$prodcatm_name5		= $srowspgcnts_mst['prodcatm_name'];
	
		$pgcnt_cat_url=funcStrRplc($prodcatm_name5);
		$prodmnlnksm_name		= $srowspgcnts_mst['prodmnlnksm_name'];
		$pgcnt_mn_url=funcStrRplc($prodmnlnksm_name);
		$prodcatm_bimg		= $srowspgcnts_mst['prodcatm_bnrimg'];
		$prodmnlnksm_typ		= $srowspgcnts_mst['prodmnlnksm_typ'];
	
		$prodscatm_desc  = $srowspgcnts_mst['prodscatm_desc'];
		$prodscatm_typ  = $srowspgcnts_mst['prodscatm_typ'];
	$prodcat_bnr	    = $srowspgcnts_mst['prodcatm_bnrimg'];
		$prodcat_pth	    = $u_cat_bnrfldnm . $prodcat_bnr;
		 $prodscat_bnr 	    = $srowspgcnts_mst['prodscatm_bnrimg'];
		$prodscat_pth = $u_scat_bnrfldnm . $prodscat_bnr;
		$pgcnt_bnr 		    = $srowspgcnts_mst['pgcntsd_bnrimg'];
		$pgcnt_pth	        = $u_pgcnt_bnrfldnm . $pgcnt_bnr;
		$prodmnlnksm_bnr 	    = $srowspgcnts_mst['prodmnlnksm_bnrimg'];
		$bngimgpth1 = $u_mnlnks_bnrfldnm . $prodmnlnksm_bnr;

		if ($prodid != '' || isset($prodid)) {
			$title = "$pgcntnt_name";
			if(($pgcnt_bnr != "") && file_exists($pgcnt_pth)) {
				$bnimgpth	 = $u_pgcnt_bnrfldnm . $pgcnt_bnr;
				$bnrimgpth = $rtpth.$bnimgpth;
			}
			else if (($prodscat_bnr != "") && file_exists($prodscat_pth)) {
				$bnrimgpth = $rtpth.$prodscat_pth;
			} 
			else if (($prodcat_bnr != "") && file_exists($prodcat_pth)) {
			
					$bnrimgpth = $rtpth . $prodcat_pth;
			}
		
			else if(($prodmnlnksm_bnr!= "") && file_exists($bngimgpth1)){
				$bnrimgpth = $rtpth . $bngimgpth1;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		} 
		else {
			$title = $prodcatm_name5;
			$bngimgpth = $u_cat_bnrfldnm . $prodcatm_bimg;
			if (($prodcatm_bimg != "") && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			}
			else if(($prodmnlnksm_bnr != "") && file_exists($bngimgpth1)){
				$bnrimgpth = $rtpth . $bngimgpth1;
			} 
			 else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		}
	
	} else {
		
		header("Location:index.php");
		exit();
	}
} else {
	header("Location:index.php");
	exit();
}
//if($srowspgcnts_mst['prodmnlnksm_typ'] == 'g'){
$page_title = $prodcatm_name5;
$pagescat_title = $prodscatm_name5;
//}
$current_page = '';
include('header.php');
$page_title = "Page Content | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Page Content | Chaitanya Bharathi Institute of Technology";
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
<div class="page-banner-area bg-2" style="background-image:url(<?php echo $rtpth.$bnrimgpth; ?>) ;">
</div>
<!-- <div class="page-banner-area bg-2">
	</div> -->
<section class="page-bread">
	<div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
		<div class="page-banner-content">
			<h1><?php echo $title; ?></h1>
			<ul>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
		
				<?php if ($_REQUEST['mnlnks'] != 'departments' && $_REQUEST['mnlnks'] != 'admissions') {
				?>
					<li><a href="<?php echo $rtpth . $pgcnt_mn_url . '/' . $pgcnt_cat_url;?>"><?php echo $prodmnlnksm_name; ?></a></li>
					<?php
				$query1="SELECT prodscatm_name from prodscat_mst where prodscatm_prodcatm_id='$catone_id5' group by  prodscatm_prodcatm_id order by prodscatm_prty asc limit 1";
				$result=mysqli_query($conn,$query1);
				$display=mysqli_fetch_assoc($result);
				$breds_scat_url=$display['prodscatm_name'];
				$brd_url=funcStrRplc($breds_scat_url);
				?>
				<li><a href="<?php echo $rtpth . $pgcnt_mn_url . '/' . $pgcnt_cat_url.'/'.$brd_url; ?>"><?php echo $prodcatm_name5; ?></a></li>
				<?php
			$query2="SELECT pgcntsd_name from  pgcnts_dtl where pgcntsd_prodscatm_id='$cattwo_id ' group by  pgcntsd_prodscatm_id order by pgcntsd_prty asc limit 1";
				$result2=mysqli_query($conn,$query2);
				$display1=mysqli_fetch_assoc($result2);
				$breds_pg_url=$display1['pgcntsd_name'];
				?>
					<li><a href="<?php echo $rtpth . $pgcnt_mn_url . '/' . $pgcnt_cat_url.'/'.$pgcnt_scat_url.'/'.$breds_pg_url; ?>"><?php echo $prodscatm_name5; ?></a></li>
					<!-- <li><?php echo $prodscatm_name5; ?></li> -->
					<li><?php echo $pgcntnt_name; ?></li>
				<?php
				}
				?>
				<?php
				if ($_REQUEST['mnlnks'] == 'departments') {
				
				?>	<?php
				$bdqry1="SELECT prodscatm_name from prodscat_mst where prodscatm_prodcatm_id='$catone_id5' group by  prodscatm_prodcatm_id order by prodscatm_prty asc limit 1";
				$res1=mysqli_query($conn,$bdqry1);
				$value1=mysqli_fetch_assoc($res1);
				$breds_scat_url=$value1['prodscatm_name'];
				$brd_url=funcStrRplc($breds_scat_url);
				?>
				
					<li><a href="<?php echo $rtpth; ?>departments"><?php echo $prodmnlnksm_name ;?></a></li>
					<li><a href="<?php echo $rtpth . $pgcnt_mn_url . '/' . $pgcnt_cat_url.'/'.$brd_url; ?>"><?php echo $prodcatm_name5; ?></a></li>
					<?php
			$bdqry2="SELECT pgcntsd_name from  pgcnts_dtl where pgcntsd_prodscatm_id='$cattwo_id ' group by  pgcntsd_prodscatm_id order by pgcntsd_prty asc limit 1";
				$res2=mysqli_query($conn,$bdqry2);
				$value2=mysqli_fetch_assoc($res2);
				$breds_pg_url=$value2['pgcntsd_name'];
				?>
					<li><a href="<?php echo $rtpth . $pgcnt_mn_url . '/' . $pgcnt_cat_url.'/'.$pgcnt_scat_url.'/'.$breds_pg_url; ?>"><?php echo $prodscatm_name5; ?></a></li>
					<li><?php echo $pgcntnt_name; ?></li>
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
	$sqrydept_mst =  "SELECT nwsm_id,nwsm_name,nwsm_sts,nwsm_prty,nwsm_typ,nwsm_dwnfl,date_format(nwsm_dt,'%d-%m-%Y') as nwsm_dt,nwsm_desc,nwsm_lnk	from nws_mst where nwsm_id != ''and nwsm_sts='a' and nwsm_typ=5 order by nwsm_prty asc";
	$srsdept_ntf_mst = mysqli_query($conn, $sqrydept_mst);
	$cnt_dept = mysqli_num_rows($srsdept_ntf_mst);
?>
	<div class="container-fluid px-0">
		<div class="depart-nitif-holder py-1">
			<?php
			if ($cnt_dept > 0) {
			?>
				<div class="an-label">
					<div class="an-label-holder">
						<p>Notifications </p>
					</div>
				</div>
			<?php
			}
			?>
			<marquee onmouseover="this.stop();" onmouseout="this.start();">
				<div class="header-left-content header-right-content">
					<div class="list top-not-links depart-link-scroll">
						<ul>
							<?php
							while ($dept_ntf = mysqli_fetch_assoc($srsdept_ntf_mst)) {
								$dept_ntf_id = $dept_ntf['nwsm_id'];
								$dept_ntf_nm = $dept_ntf['nwsm_name'];
								$dept_url=funcStrRplc($dept_ntf_nm);
								$dept_ntf_desc = $dept_ntf['nwsm_desc'];
								$dept_ntf_link = $dept_ntf['nwsm_lnk'];
								$dept_ntf_dt = $dept_ntf['nwsm_dt'];
								$dept_ntf_typ = $dept_ntf['nwsm_typ'];
								$dep_type=funcStrRplc($dept_ntf_typ);
							?>
								<li>
									<a href="<?php echo $rtpth.'latest-notifications/'.$dep_type.'/'.$dept_url.'_'.$dept_ntf_id; ?>"> <?php echo $dept_ntf_desc; ?></a>
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
?>
<!-- department notifications end -->
<div class="campus-information-area section-pad-y">
	<div class="container-fluid px-lg-3 px-md-3 px-2">
		<div class="row">
			<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-12 order-md-1 order-2">
				<?php
				// faculty menu
				
				if($prodscatm_name5=='People'){
					
				if ( $pgcntnt_name == 'Faculty' || $pgcntnt_name == 'Admin Staff' || $pgcntnt_name == 'Technical Staff') {
					$sqryfaculty_mst = "SELECT faculty_id,faculty_dept_id,faculty_rank,faculty_sts,faculty_dtl_id,faculty_mst_id,faculty_dtl_dept_id,faculty_simgnm,faculty_desgn,faculty_desc,faculty_simg,faculty_file,faculty_prty,faculty_dtl_sts
			 from faculty_mst
			  inner join faculty_dtl on faculty_mst_id=faculty_id 
				where faculty_dept_id='$catone_id5' and faculty_sts='a' and faculty_dtl_sts='a' ";
					if ($pgcntnt_name == 'Faculty') {
						$sqryfaculty_mst .= " and faculty_typ='F' ";
						// $txt = "Teaching Staff";
					}
					if ($pgcntnt_name == 'Admin Staff') {
						$sqryfaculty_mst .= " and faculty_typ='A' ";
						// $txt = "Non Teaching Staff";
					}
					if ($pgcntnt_name == 'Technical Staff') {
						$sqryfaculty_mst .= " and faculty_typ='T' ";
						// $txt = "TechnicalStaff";
					}
					$sqryfaculty_mst .= " group by faculty_dtl_id order by faculty_prty asc";
					// echo $sqryfaculty_mst;
					$srsfaclty_dtl = mysqli_query($conn, $sqryfaculty_mst);
					$cntrec_faclty = mysqli_num_rows($srsfaclty_dtl);
					if ($cntrec_faclty > 0) { ?>
						<!-- <h2><?php echo $txt; ?></h2> -->
						<div class="campus-content pr-20 ">
							<div class="comments">
								<div class="row slide-on-mob">
									<?php
									  $faclty_arr = array();
									while ($srowsfaclty_dtl = mysqli_fetch_assoc($srsfaclty_dtl)) {
										$faclty_id         = $srowsfaclty_dtl['faculty_dtl_id'];
										$faclty_arr[] = $faclty_id;
										$faclty_name      = $srowsfaclty_dtl['faculty_simgnm'];
										$faclty_desg     = $srowsfaclty_dtl['faculty_desgn'];
										$faclty_desc     = $srowsfaclty_dtl['faculty_desc'];
										$faclty_file     = $srowsfaclty_dtl['faculty_file'];
										$faclty_bnrimg      = $srowsfaclty_dtl['faculty_simg'];
										$factpath      = $u_phtgalfaculty . $faclty_bnrimg;
										$fact_fle_path      = $u_phtgalfaculty . $faclty_file;
										if (($faclty_bnrimg != "") && file_exists($factpath)) {
											$facltyimgpth = $rtpth . $factpath;
										} else {
											$facltyimgpth   = $rtpth . $u_phtgalfaculty  . 'dummy-fac.jpg';
										}
										//  file
										if (($faclty_file != "") && file_exists($fact_fle_path)) {
											$facty_file = $rtpth . $fact_fle_path;
										} else {
											$facty_file   = "no-files found";
										}
									?>
										<div class="col-lg-6 col-md-6 col-10">
											<div class="fac-single-holder">
												<div class="row">
													<div class="col-lg-4 col-md-4 col-4">
														<img src="<?php echo  $facltyimgpth; ?>" class="w-100" alt="Images">
													</div>
													<div class="col-lg-8 col-md-8 col-8">
														<div class="single-comments-box">
															<h1 class="common-sm-heading mb-2"><?php echo  $faclty_name; ?></h1>
																<div class="post">
																<p><?php echo  $faclty_desg; ?></p>
																<?php 
															if($faclty_desc!=''){
																?>
																<a href="" data-bs-toggle="modal" data-bs-target="#facultyDetailsModal<?php echo $faclty_id; ?>" class="read-more-btn">Read more<i class="flaticon-next "></i></a>
																<?php
															}
															?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php
									}
									?>
								</div>
							</div>
						</div>
					<?php
					}
				}
			}
				// <!-- gallery  menu-->
				if ($prodid !='') {
					$sqryphtcat_mst = "SELECT pgimgd_id,pgimgd_pgcntsd_id,pgimgd_name,pgimgd_img,pgimgd_prty,pgimgd_sts
					from  pgimg_dtl
					where pgimgd_pgcntsd_id='$pgcnt_id5' and pgimgd_sts = 'a' group by pgimgd_id order by  pgimgd_prty asc";
					$srsphtcat_dtl = mysqli_query($conn, $sqryphtcat_mst);
					$cntrec_phtcat = mysqli_num_rows($srsphtcat_dtl);
					if ($cntrec_phtcat > 0) {
					?>
						<div class="campus-content pr-20 ">
							<div class="cont ">
							<!-- <h3>Gallery Section</h3> -->
								<div class="demo-gallery ">
								<ul id="lightgallery" class="list-unstyled row gx-xxl-1 gx-xl-1 gx-lg-1 gx-md-2 gx-0 ">
										<?php
										while ($srowsphtcat_dtl = mysqli_fetch_assoc($srsphtcat_dtl)) {
											$phtcatid         = $srowsphtcat_dtl['pgimgd_id'];
											$phtcat_name      = $srowsphtcat_dtl['pgimgd_name'];
											$phtcat_bnrimg      = $srowsphtcat_dtl['pgimgd_img'];
											// $phtcatm_desc  = $srowsphtcat_dtl['phtcatm_desc'];
											// $bphtimgnm     = $srowsphtcat_dtl['phtm_simg'];
											$galpath      = $u_phtgalspath . $phtcat_bnrimg;
											// echo file_exists($galpath);
											if (($phtcat_bnrimg != "") && file_exists($galpath)) {
												$galryimgpth = $rtpth . $galpath;
											} else {
												$galryimgpth   = $rtpth . $gusrglry_fldnm . 'default.jpg';
											}
										?>
											 <li class="col-xxl-4 col-lg-4 col-md-4 col-6 mb-2"
					  data-responsive="<?php echo $galryimgpth; ?> 375, <?php echo $galryimgpth; ?> 480, <?php echo $galryimgpth; ?> 800"
					  data-src="<?php echo $galryimgpth; ?> " data-sub-html="<h4>Category 6</h4>">
					  <a href="">
						  <img class="img-responsive w-100" src="<?php echo $galryimgpth; ?>">
						  <div class="demo-gallery-poster">
							  <img src="https://sachinchoolur.github.io/lightgallery.js/static/img/zoom.png">
						  </div>
					  </a>
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
				?>
				<!-- // end gallery -->
				<!-- //videos start -->
					<?php
					if ($prodid != '') {
						$sqryvdom_mst1 = "SELECT pgvdod_id,pgvdod_pgcntsd_id,pgvdod_name,pgvdod_typ,	pgvdod_vdo,pgvdod_prty,pgvdod_sts from  pgvdo_dtl where  pgvdod_pgcntsd_id  ='$pgcnt_id5' and 	pgvdod_sts = 'a' order by 	pgvdod_prty asc";
						// echo $sqryvdom_mst1;		
						$srsvdom_dtl1 = mysqli_query($conn, $sqryvdom_mst1);
						$cntrec_vdom1 = mysqli_num_rows($srsvdom_dtl1);
						if ($cntrec_vdom1 > 0) {
					?>
					<div class="campus-content pr-20 ">
							<div class="comments">
								<div class="row slide-on-mob">
								<h3>Video Section</h3>
										<?php
										while ($srowsvdom_dtl1 = mysqli_fetch_assoc($srsvdom_dtl1)) {
											$vdoid        = $srowsvdom_dtl1['pgvdod_id'];
											//$phtid         = $srowsphtcat_dtl1['phtd_desc'];
											$vdo_name      = $srowsvdom_dtl1['pgvdod_name'];
											$vdolnk    = $srowsvdom_dtl1['pgvdod_vdo'];
										?>
											<div class="col-lg-4 col-md-4 col-10">
												<div class="row">
														<div class='embed-responsive embed-responsive-16by9 col-lg-3 col-md-3 col-3'>
												<iframe width="270" height="200" src="<?php echo $vdolnk; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
												<p ><?php echo $vdo_name; ?></p>
											</div>
											<!-- </div> -->
												</div>
											<!-- </div> -->
											</div>
										<?php } ?>
								</div>
								</div>
							</div>
					<?php
						}
					}
					?>
				<!-- videos end -->
				<?php
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
						$pgcntnt_id 	 = $srowspgcnts_mst['pgcntsd_id'];
						$prodscatm_id 	 = $srowspgcnts_mst['prodscatm_id'];
						$prodcatm_name	 = $srowspgcnts_mst['prodcatm_name'];
						$prodscatm_name	 = $srowspgcnts_mst['prodscatm_name'];
						$prodpg_lnk	 = $srowspgcnts_mst['pgcntsd_lnk'];
						$prodpg_fle	 = $srowspgcnts_mst['pgcntsd_fle'];
						$fact_fle_path      = $u_gevnt_fldnm . $prodpg_fle;
						$prodcatm_desc = preg_replace('/style=\\"[^\\"]*\\"/', '', $srowspgcnts_mst['prodcatm_desc']);
						$prodscatm_desc = preg_replace('/style=\\"[^\\"]*\\"/', '', $srowspgcnts_mst['prodscatm_desc']);
						$pgcnts_name	 = $srowspgcnts_mst['pgcntsd_name'];
						$pgcntsd_desc = preg_replace('/style=\\"[^\\"]*\\"/', '', $srowspgcnts_mst['pgcntsd_desc']);
						$pgcntsd_desc = $srowspgcnts_mst['pgcntsd_desc'];
						if ($_REQUEST['mnlnks'] == 'departments' || $_REQUEST['scatid'] != '' || $_REQUEST['prodid'] != '') {
							echo $pgcntsd_desc;
							// pgcntsd_fle
							if ($prodpg_lnk != '') {
								echo "<p><a href='$prodpg_lnk'>Click here<a></p>";
							}
							if (($prodpg_fle != "")) {
								$facty_file = $rtpth . $fact_fle_path;
								echo "<a href='$facty_file' download >Download</a>";
							} else {
								$facty_file   = "no-files found";
							}
						}
						// if ($_REQUEST['mnlnks'] == 3 || $_REQUEST['scatid'] !='') {
						// 	echo $prodscatm_desc;
						// }
						else {
							echo $pgcntsd_desc;
						}
						$testqns = "SELECT pgcntqns_id,pgcntqns_pgcntsd_id,pgcntqns_name,pgcntqns_vdo,pgcntqns_sts,pgcntqns_prty from  pgcntqnsm_dtl where";
						if ($_REQUEST['mnlnks'] == 'departments' || $_REQUEST['scatid'] != '') {
							$testqns .= "	pgcntqns_pgcntsd_id='$pgcntnt_id' and pgcntqns_sts='a'and  pgcntqns_id!='' order by pgcntqns_prty asc";
						} else {
							$testqns .= "	pgcntqns_pgcntsd_id='$pgcntnt_id' and pgcntqns_sts='a'and  pgcntqns_id!='' order by pgcntqns_prty asc";
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
										$pgcntqns_id = $testqnsrow['pgcntqns_id'];
										$pgcntqns_pgcntsd_id = $testqnsrow['pgcntqns_pgcntsd_id'];
										$pgcntqns_name1 = $testqnsrow['pgcntqns_name'];
										$pgcntqns_name2 = explode("$h-", $pgcntqns_name1);
										$pgcntqns_name = implode($pgcntqns_name2);
										$pgcntqns_vdo = $testqnsrow['pgcntqns_vdo'];
										$pgcntqns_sts = $testqnsrow['pgcntqns_sts'];
									?>
										<div class="accordion-item">
											<h2 class="accordion-header mb-0" id="heading-1">
												<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#po<?php echo $h; ?>" aria-expanded="false" aria-controls="po<?php echo $h; ?>">
													<?php echo $pgcntqns_name; ?>
												</button>
											</h2>
											<div id="po<?php echo $h; ?>" class="accordion-collapse collapse" aria-labelledby="heading-1" data-bs-parent="#departmentLinks" style="">
												<div class="accordion-body py-3">
													<p><?php echo $pgcntqns_vdo; ?></p>
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
				<?php include('catrightblock.php'); ?>
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>