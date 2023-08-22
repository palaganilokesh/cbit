<?php
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
	$sqrypgcnts_mst1 = "SELECT prodmnlnksm_id,prodmnlnksm_typ,prodmnlnksm_name,prodcatm_bnrimg,prodmnlnksm_sts,prodmnlnksm_prty,prodmnlnksm_bnrimg,prodcatm_id,prodcatm_name,prodcatm_typ,prodcatm_desc,prodcatm_bnrimg";
	if ($_REQUEST['mnlnks'] == 3 || $_REQUEST['scatid']!='') {
		$sqrypgcnts_mst1 .= ", prodscatm_id,prodscatm_name,prodscatm_desc,prodscatm_bnrimg,prodscatm_typ";
	}
	$sqrypgcnts_mst1 .= " from prodmnlnks_mst inner join prodcat_mst on prodcatm_prodmnlnksm_id =prodmnlnksm_id";
	if ($_REQUEST['mnlnks'] == 3 || $_REQUEST['scatid']!='') {
		$sqrypgcnts_mst1 .= " inner join prodscat_mst on prodscatm_prodcatm_id=prodcatm_id";
	}

	$sqrypgcnts_mst1 .= " where prodmnlnksm_sts='a' and prodcatm_sts = 'a'";
	//echo $sqrypgcnts_mst1;exit;	
	//-----------------------------------------------------------------------//	
	if (isset($_REQUEST['catid']) && (trim($_REQUEST['catid']) != "")) {
		$catone_id = glb_func_chkvl($_REQUEST['catid']);
		$sqrypgcnts_mst1 .= " and prodcatm_id = $catone_id";
		$loc = "&catid=$catone_id";
	}
	/*if(isset($_REQUEST['prodid']) && (trim($_REQUEST['prodid'])!="")){
			$prodid = glb_func_chkvl($_REQUEST['prodid']);
			$sqrypgcnts_mst1 .= " and pgcntsd_id = $prodid";
			$loc .="&prodid=$prodid";
		}*/
	if (isset($_REQUEST['scatid']) && (trim($_REQUEST['scatid']) != "")) {
		$cattwo_id_1 = $cattwo_id = glb_func_chkvl($_REQUEST['scatid']);
		$sqrypgcnts_mst1 .= " and prodscatm_id = $cattwo_id";
		$loc .= "&scatid=$cattwo_id";
	}
	if (isset($_REQUEST['mnlnks']) && (trim($_REQUEST['mnlnks']) != "")) {
		$mnlnks_id = glb_func_chkvl($_REQUEST['mnlnks']);
		$sqrypgcnts_mst1 .= " and prodcatm_prodmnlnksm_id  = $mnlnks_id";
		$loc .= "&mnlnks=$mnlnks_id";
	}
	if ($_REQUEST['mnlnks'] == 3 || $_REQUEST['scatid']!='') {
		$sqrypgcnts_mst1 .= " and prodscatm_sts  = 'a'";
	}
	$pgqry = $sqrypgcnts_mst1;
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
		$prodcatm_name		= $srowspgcnts_mst['prodcatm_name'];
		$prodcatm_bimg		= $srowspgcnts_mst['prodcatm_bnrimg'];
		$prodmnlnksm_typ		= $srowspgcnts_mst['prodmnlnksm_typ'];
		$prodmnlnksm_name		= $srowspgcnts_mst['prodmnlnksm_name'];
		$prodscatm_desc  = $srowspgcnts_mst['prodscatm_desc'];
		$prodscatm_typ  = $srowspgcnts_mst['prodscatm_typ'];
		$prodcat_bnr	    = $srowspgcnts_mst['prodcatm_bnrimg'];
		$prodcat_pth	    = $u_cat_bnrfldnm . $prodcat_bnr;
		$prodscat_bnr 	    = $srowspgcnts_mst['prodscatm_bnrimg'];
		
		if ($catone_id != '' || isset($catone_id)) {
			$title = "$prodcatm_name";
			$bngimgpth = $u_cat_bnrfldnm . $prodcat_bnr;
			if ($prodcat_bnr != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		}
		else if ($cattwo_id_1 != '' || isset($cattwo_id_1)) {
			$title = "$prodscatm_name";
			$bngimgpth = $u_scat_bnrfldnm . $prodscat_bnr;
			if ($prodscat_bnr != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		} else {
			$title = $prodcatm_name;
			$bngimgpth = $u_cat_bnrfldnm . $prodcatm_bimg;
			if ($prodcatm_bimg != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else {
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
<div class="page-banner-area bg-2" style="background-image:url(<?php echo $bnrimgpth; ?>) ;">

</div>
<!-- <div class="page-banner-area bg-2">
	</div> -->
<section class="page-bread">
	<div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
		<div class="page-banner-content">
			<h1><?php echo $title; ?></h1>
			<ul>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>

				<!-- <li><a href="<?php echo $rtpth; ?>category.php?mnlnks=1&catid=1"><?php echo $mnlnks_id; ?></a></li>	 -->
				<?php	if ($_REQUEST['mnlnks'] != 3) {
				?>
				<!-- <li><?php echo $mnlnks_id . " / " . $catone_id; ?></li> -->
				<li><?php echo $prodmnlnksm_name . " / " . $prodcatm_name; ?></li>
				<?php
				}
				?>
				<?php
				if ($_REQUEST['mnlnks'] == 3) {
				?>
					<!-- <li><a href="<?php echo $rtpth; ?>departments.php"><?php echo $cattwo_id; ?></a></li> -->
			
					<li><a href="<?php echo $rtpth; ?>departments.php"><?php echo $prodmnlnksm_name . " / " . $prodcatm_name; ?></a></li>
					<li><?php echo $prodscatm_name; ?></li>
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
if ($_REQUEST['mnlnks'] == 3) {
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
								$dept_ntf_desc = $dept_ntf['nwsm_desc'];
								$dept_ntf_link = $dept_ntf['nwsm_lnk'];
								$dept_ntf_dt = $dept_ntf['nwsm_dt'];
								$dept_ntf_typ = $dept_ntf['nwsm_typ'];
							?>
								<li>
									<a href="<?php echo $rtpth?>announcements-details.php?notify_typ=<?php echo $dept_ntf_typ;?>&notid=<?php echo $dept_ntf_id;?>"> <?php echo $dept_ntf_desc; ?></a>
									<!-- <img src="<?php echo $rtpth; ?>assets/images/icon/new.gif" alt=""> -->
								</li>
							<?php  }
							?>
							<!-- <li><a href="#">Notification from Civil department - 1</a></li> -->

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
				if($prodscatm_typ==4){
			 $sqryfaculty_mst="SELECT faculty_id,faculty_dept_id,faculty_rank,faculty_sts,faculty_dtl_id,faculty_mst_id,faculty_dtl_dept_id,faculty_simgnm,faculty_desgn,faculty_simg,faculty_file,faculty_prty,faculty_dtl_sts
			 from faculty_mst
			  inner join faculty_dtl on faculty_mst_id=faculty_id 
				where faculty_dept_id='$catone_id' and faculty_sts='a' and faculty_dtl_sts='a' group by faculty_dtl_id order by faculty_prty asc";
						$srsfaclty_dtl = mysqli_query($conn, $sqryfaculty_mst);
						$cntrec_faclty = mysqli_num_rows($srsfaclty_dtl);
						if ($cntrec_faclty > 0)
						{?>
						<div class="campus-content pr-20 ">
						<div class="comments">
						<div class="row slide-on-mob">

						<?php
					
						while ($srowsfaclty_dtl = mysqli_fetch_assoc($srsfaclty_dtl)) {
						 $faclty_id         = $srowsfaclty_dtl['faculty_dtl_id'];
						 $faclty_name      = $srowsfaclty_dtl['faculty_simgnm'];
						 $faclty_desg     = $srowsfaclty_dtl['faculty_desgn'];
						 $faclty_file     = $srowsfaclty_dtl['faculty_file'];
						 $faclty_bnrimg      = $srowsfaclty_dtl['faculty_simg'];
					 $factpath      = $u_phtgalfaculty .$faclty_bnrimg;
					 $fact_fle_path      = $u_phtgalfaculty .$faclty_file;

						 // echo file_exists($galpath);
					//  image
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
                                            <img src="<?php echo  $facltyimgpth;?>" class="w-100" alt="Images">
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <div class="single-comments-box">
                                                <h1 class="common-sm-heading mb-2"><?php echo  $faclty_name ;?></h1>
                                                <div class="post">
                                                    <p><?php echo  $faclty_desg ;?></p>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#facultyDetailsModal"
                                                        class="read-more-btn ">Read more<i
                                                            class="flaticon-next "></i></a>
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
				// <!-- gallery  menu-->
				if($prodscatm_typ==2){
				
	$sqryphtcat_mst = "SELECT phtd_id,phtcatm_name, phtd_phtcatm_id,phtcatm_img, phtd_name, phtd_desc,phtd_rank, phtd_sts, phtd_crtdon, phtd_crtdby, phtd_mdfdon, phtd_mdfdby, phtm_id, phtm_phtd_id, phtm_phtcatm_id, phtm_simgnm, phtm_simg, phtm_prty, phtm_sts, phtm_crtdon, phtm_crtdby, phtm_mdfdon, phtm_mdfdby,phtcatm_name,phtcatm_id,phtcatm_desc,phtcatm_deprtmnt from vw_phtd_phtm_mst left join phtcat_mst on  phtcat_mst.phtcatm_id = vw_phtd_phtm_mst.phtm_phtcatm_id where phtcatm_deprtmnt='$catone_id' and phtm_sts = 'a' and phtcatm_sts = 'a' and phtd_sts = 'a' and phtcatm_typ = 'd' group by phtcatm_id order by  phtcatm_prty asc";
		$srsphtcat_dtl = mysqli_query($conn, $sqryphtcat_mst);
		$cntrec_phtcat = mysqli_num_rows($srsphtcat_dtl);
		if ($cntrec_phtcat > 0)
		{
?>
 <div class="campus-content pr-20 ">

 <div class="cont ">
 <div class="demo-gallery ">
    <ul id="" class="list-unstyled row gx-xxl-1 gx-xl-1 gx-lg-1 gx-md-2 gx-0 ">
<?php
 while ($srowsphtcat_dtl = mysqli_fetch_assoc($srsphtcat_dtl)) {
	$phtcatid         = $srowsphtcat_dtl['phtcatm_id'];
	$phtcat_name      = $srowsphtcat_dtl['phtcatm_name'];
	$phtcat_bnrimg      = $srowsphtcat_dtl['phtcatm_img'];
	// $phtcatm_desc  = $srowsphtcat_dtl['phtcatm_desc'];
	// $bphtimgnm     = $srowsphtcat_dtl['phtm_simg'];
	$galpath      = $gusrglry_fldnm .$phtcat_bnrimg;
	// echo file_exists($galpath);

	if (($phtcat_bnrimg != "") && file_exists($galpath)) {
		$galryimgpth = $rtpth . $galpath;
	} else {
		$galryimgpth   = $rtpth . $gusrglry_fldnm . 'default.jpg';
		
	}
	?>
	<li class="col-xxl-4 col-lg-4 col-md-4 col-6 mb-2"
                                    data-responsive="<?php echo $galryimgpth;?> 375, <?php echo $galryimgpth;?> 480, <?php echo $galryimgpth;?> 800 "
                                    data-src="<?php echo $galryimgpth;?> "
                                    data-sub-html="<h4>Category 1</h4>">
                                    <a href='dept-gallery-explore.php?phtid=<?php echo $srowsphtcat_dtl['phtcatm_id'];?>&mnlnks=<?php echo $_REQUEST['mnlnks']?>&catid=<?php echo $catone_id?>&scatid=<?php echo $cattwo_id ?>'>
                                        <img class="img-responsive w-100"
                                            src="<?php echo $galryimgpth;?>">
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
						$prodcatm_desc=$srowspgcnts_mst['prodcatm_desc'];
						$prodscatm_desc=$srowspgcnts_mst['prodscatm_desc'];

						if ($_REQUEST['mnlnks'] == 3 || $_REQUEST['scatid'] !='') {
							echo $prodscatm_desc;
						} else {
							echo $prodcatm_desc;
						}

						$testqns = "SELECT pgqnsd_id,pgqnsd_pgcntsd_id,pgqnsd_name,pgqnsd_vdo,pgqnsd_sts,pgqnsd_prty from  pgqns_dtl where";
						if ($_REQUEST['mnlnks'] == 3 || $_REQUEST['scatid']!='') {
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
				<?php include('catrightblock.php'); ?>


			</div>

		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>