<?php
// echo"<pre>";
// var_dump($_REQUEST);
// echo"</pre>";
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once "includes/inc_folder_path.php";
// include_once 'includes/inc_paging_functions.php'; //Making paging validation
global $rtpth;
$admtyp = $_GET['admtyp'];
$catid1 = $_GET['catid'];
$catid = funcStrUnRplc($catid1);
$mnlnks1 = $_GET['mnlnks'];
$mnlnksid = funcStrUnRplc($mnlnks1);
$scatid1 = $_GET['scatid'];
$scatid = funcStrUnRplc($scatid1);
if($scatid=='UG' || $scatid=='PG' || $scatid=='ug' || $scatid=='pg' )
{
	$admtyp=strtoupper($scatid);
	$scatid='';	
}
else{
$scatid=$scatid;
}

$prodid1 = $_GET['prodid'];
$prodid = funcStrUnRplc($prodid1);
?>
<div class="about-us-sideLinks">
	<div class="faq-left-content ">
		<div class="accordion" id="academicsLinks">
			<div class="accordion-item item-custom-1">
				<h2 class="accordion-header" id="heading-2">
					<button class="accordion-button open-df collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pg" aria-expanded="false" aria-controls="pg">
						<?php
						if ($mnlnksid == 'departments' || $scatid != '') {
							
							$ttl = "SELECT prodcatm_name,prodcatm_id from prodcat_mst where prodcatm_name='$catid'";
							// echo $ttl;
							$res = mysqli_query($conn, $ttl);
							$cat_res = mysqli_fetch_assoc($res);
							echo $cat_res['prodcatm_name'];
								$get_catid=$cat_res['prodcatm_id'];
							// echo "her".$get_catid ;
						} else {
							$tt2 = "SELECT prodmnlnksm_name,prodmnlnksm_id from prodmnlnks_mst where prodmnlnksm_name='$mnlnksid'";
							$resmn = mysqli_query($conn, $tt2);
							$mnln_res = mysqli_fetch_assoc($resmn);
							$get_mnlnkid=$mnln_res['prodmnlnksm_id'];
							if ($mnlnksid == 'admissions' && $admtyp == 'UG') {
								$adtyp = "Under Graduation";
								echo $mnln_res['prodmnlnksm_name'] . '-' . $adtyp;
							} elseif ($mnlnksid == 'admissions' && $admtyp == 'PG') {
								$adtyp = "Post Graduation";
								echo $mnln_res['prodmnlnksm_name'] . '-' . $adtyp;
							} else {
								echo $mnln_res['prodmnlnksm_name'];
							}
							//	echo $mnlnksid ;
						}
						?>
					</button>
				</h2>
				<?php
				$sqryprodcat_mst = "SELECT prodmnlnksm_id,prodmnlnksm_name,prodmnlnksm_typ,prodcatm_id,prodcatm_name,prodcatm_admtyp";
				if ($mnlnksid == 'departments' || $scatid != '') {
					$sqryprodcat_mst .= ",prodscatm_id,prodscatm_name,prodscatm_desc ";
				}
				$sqryprodcat_mst .= " from	prodmnlnks_mst 
								inner join prodcat_mst on prodcatm_prodmnlnksm_id=prodmnlnksm_id";
				if ($mnlnksid == 'departments' || $scatid != '') {
					$sqryprodcat_mst .= " inner join prodscat_mst on prodscatm_prodcatm_id=prodcatm_id ";
				}
				$sqryprodcat_mst .= " where  prodmnlnksm_name='$mnlnksid' and	prodcatm_sts='a'";
				if ($mnlnksid == 'departments' || $scatid != '') {
					$sqryprodcat_mst .= " and prodcatm_name='$catid' and prodscatm_sts='a'";
				}
				if ($mnlnksid == 'admissions') {
					$sqryprodcat_mst .= " and prodcatm_admtyp='$admtyp' ";
				}
				if ($mnlnksid == 'departments' || $scatid != '') {
					$sqryprodcat_mst .= "	 order by prodscatm_prty asc";
				}
				if ($scatid == '') {
					$sqryprodcat_mst .= "	 order by prodcatm_prty asc";
				}
				// echo $sqryprodcat_mst;
				$srsprodcat_mst 		= mysqli_query($conn, $sqryprodcat_mst);
				$cntcat_mst            =  mysqli_num_rows($srsprodcat_mst);
				if ($cntcat_mst > 0) {
				?>
					<div id="pg" class="accordion-collapse open-df collapse" aria-labelledby="heading-2" data-bs-parent="#academicsLinks">
						<div class="accordion-body p-0 ug-links">
							<ul class="links-lists p-0 m-0">
								<?php
								while ($srowcat_mst = mysqli_fetch_assoc($srsprodcat_mst)) {
									$prodcatm_id 	= $srowcat_mst['prodcatm_id'];
									$prodscatm_id 	= $srowcat_mst['prodscatm_id'];
									$prodcatm_name = $srowcat_mst['prodcatm_name'];
									$caturl=funcStrRplc($prodcatm_name);
									$prodscatm_name = $srowcat_mst['prodscatm_name'];
									$scaturl=funcStrRplc($prodscatm_name);
									$prodmnlnksm_id 	= $srowcat_mst['prodmnlnksm_id'];
									$prodmnlnksm_name = $srowcat_mst['prodmnlnksm_name'];
									$mnlnkurl=funcStrRplc($prodmnlnksm_name);
									if ($mnlnksid == 'departments' || $scatid != '') {
										$lftlnknm = "$rtpth$mnlnkurl/$caturl/$scaturl";
										if (ucwords($prodscatm_name) == ucwords($scatid)) {
											$cat_cls = "active";
										} else {
											$cat_cls = "";
										}
									} else {
										// echo"scat-".$prodcatm_name;
										// echo"scatid-".$catid;
										$lftlnknm = "$rtpth$mnlnkurl/$caturl";
										if (ucwords($catid) == ucwords($prodcatm_name)) {
											$cat_cls = "active";
										} else {
											$cat_cls = "";
										}
									}
									if ($mnlnksid == 'admissions') {
										$lftlnknm="$rtpth$mnlnkurl/$caturl/$admtyp";
									}
								?>
									<li>
										<?php
										$sqrypgcnt_mst = " SELECT prodmnlnksm_id,prodmnlnksm_name,prodmnlnksm_sts,prodcatm_id,prodcatm_prodmnlnksm_id,prodcatm_name,prodscatm_id,prodscatm_name,prodscatm_sts,prodscatm_prodcatm_id,pgcntsd_prodscatm_id,pgcntsd_prodcatm_id,pgcntsd_id,pgcntsd_name,pgcntsd_sts,pgcntsd_typ from 	prodmnlnks_mst
									 inner join prodcat_mst on prodcatm_prodmnlnksm_id=prodmnlnksm_id 
									 inner join prodscat_mst on prodscatm_prodcatm_id=prodcatm_id 
									 inner join pgcnts_dtl on pgcntsd_prodscatm_id=prodscatm_id
									 where  prodscatm_id='$prodscatm_id' and pgcntsd_prodcatm_id='$prodcatm_id' and prodcatm_sts='a' and prodmnlnksm_sts='a' and prodscatm_sts='a' and pgcntsd_sts='a' and pgcntsd_id !='' order by pgcntsd_prty asc";
										$srspgcnt_mst		= mysqli_query($conn, $sqrypgcnt_mst);
										$cntpgcnt_mst            =  mysqli_num_rows($srspgcnt_mst);
										if ($cntpgcnt_mst > 0) {
											// $srowpgcnt_mst1 = mysqli_fetch_assoc($srspgcnt_mst);		
											if (ucwords($scatid) == ucwords($prodscatm_name)) {
												// echo "here-".$prodid;
												$pg_cls = "accordion-button sub-menus-1";
												$aria = "true";
											} else {
												$pg_cls = "accordion-button sub-menus-1 collapsed";
												$aria = "false";
											}
										?>
											<div class="accordion" id="departmentLinksDrop<?php echo $prodid ?>">
												<div class="accordion-item">
													<h2 class="accordion-header" id="heading-1">
														<p><a class="<?php echo $pg_cls; ?>" data-bs-toggle="collapse" data-bs-target="#elig<?php echo $prodscatm_id ?>" aria-expanded="<?php echo $aria; ?>" aria-controls="elig<?php echo $prodscatm_id ?>" href="#"><i class="fa-solid fa-chevron-right"></i>
																<?php echo $prodscatm_name; ?></a>
														</p>
													</h2>
												<?php
											} else {
												?>
													<p>
														<a class="<?php echo $cat_cls; ?>" href="<?php echo $lftlnknm; ?>">
															<i class="fa-solid fa-chevron-right"></i>
															<?php
															if ($mnlnksid == 'departments' || $scatid != '') {
																echo $prodscatm_name;
															} else {
																echo $prodcatm_name;
															}
															?>
														</a>
													</p>
												<?php
											}
											if ($cntpgcnt_mst > 0) {
												if (ucwords($scatid) == ucwords($prodscatm_name)) {
													$pg_cls1 = "accordion-collapse collapse show";
													// echo "here".$prodid;
												} else {
													$pg_cls1 = "accordion-collapse collapse";
												}
												?>
													<div id="elig<?php echo $prodscatm_id ?>" class="<?php echo $pg_cls1; ?>" aria-labelledby="heading-1" data-bs-parent="#departmentLinksDrop<?php echo $prodscatm_id ?>" style="">
														<div class="accordion-body py-0 ug-links">
															<ul class="sideLinks-2">
																<?php
																$srspgcnt_mst		= mysqli_query($conn, $sqrypgcnt_mst);
																while ($srowpgcnt_mst = mysqli_fetch_assoc($srspgcnt_mst)) {
																	$prodcatm_id 	= $srowpgcnt_mst['prodcatm_id'];
																	$prodscatm_id 	= $srowpgcnt_mst['prodscatm_id'];
																	$prodcatm_name = $srowpgcnt_mst['prodcatm_name'];
																	$pgcaturl=funcStrRplc($prodcatm_name);
																	$prodscatm_name = $srowpgcnt_mst['prodscatm_name'];
																	$pgscaturl=funcStrRplc($prodscatm_name);
																	$prodpg_name = $srowpgcnt_mst['pgcntsd_name'];
																	$pgurl=funcStrRplc($prodpg_name);
																	$prodpg_id = $srowpgcnt_mst['pgcntsd_id'];
																	if (ucwords($prodpg_name) == ucwords($prodid)) {
																		$pgcntnt_cls = "active";
																	} else {
																		$pgcntnt_cls = "";
																	}
																?>
																	<li>
																		<p><a class="<?php echo $pgcntnt_cls; ?>" href="<?php echo $rtpth.$mnlnkurl.'/'.$pgcaturl.'/'.$pgscaturl.'/'.$pgurl;?>"><?php echo $prodpg_name; ?></a></p>
																	</li>
																<?php } ?>
															</ul>
														</div>
													</div>
												<?php
											}
											if ($cntpgcnt_mst > 0) {
												?>
												</div>
											</div>
										<?php
											}
										?>
									</li>
								<?php
								}
								?>
							</ul>
						</div>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>