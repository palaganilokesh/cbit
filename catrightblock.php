<?php
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once "includes/inc_folder_path.php";
// include_once 'includes/inc_paging_functions.php'; //Making paging validation

$scatid = $_GET['scatid'];
$catid = $_GET['catid'];
$mnlnksid = $_GET['mnlnks'];
$admtyp = $_GET['admtyp'];
$prodid = $_GET['prodid'];
?>

<div class="about-us-sideLinks">
	<div class="faq-left-content ">
		<div class="accordion" id="academicsLinks">
			<div class="accordion-item item-custom-1">
				<h2 class="accordion-header" id="heading-2">
					<button class="accordion-button open-df collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pg" aria-expanded="false" aria-controls="pg">
						<?php
						if ($mnlnksid == 3 || $scatid != '') {
							$ttl = "SELECT prodcatm_name from prodcat_mst where prodcatm_id='$catid'";
							$res = mysqli_query($conn, $ttl);
							$cat_res = mysqli_fetch_assoc($res);
							echo $cat_res['prodcatm_name'];
							//echo $catid ;
						} else {
							$tt2 = "SELECT prodmnlnksm_name from 	 prodmnlnks_mst where prodmnlnksm_id='$mnlnksid'";
							$resmn = mysqli_query($conn, $tt2);
							$mnln_res = mysqli_fetch_assoc($resmn);
							if ($mnlnksid == 4 && $admtyp == 'UG') {
								$adtyp = "Under Graduation";
								echo $mnln_res['prodmnlnksm_name'] . '-' . $adtyp;
							} elseif ($mnlnksid == 4 && $admtyp == 'PG') {
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
				if ($mnlnksid == 3 || $scatid != '') {
					$sqryprodcat_mst .= ",prodscatm_id,prodscatm_name,prodscatm_desc ";
				}
				$sqryprodcat_mst .= " from	prodmnlnks_mst 
								inner join prodcat_mst on prodcatm_prodmnlnksm_id=prodmnlnksm_id";
				if ($mnlnksid == 3 || $scatid != '') {
					$sqryprodcat_mst .= " inner join prodscat_mst on prodscatm_prodcatm_id=prodcatm_id ";
				}

				$sqryprodcat_mst .= " where  prodmnlnksm_id='$mnlnksid' and	prodcatm_sts='a'";
				if ($mnlnksid == 3 || $scatid != '') {
					$sqryprodcat_mst .= " and prodcatm_id='$catid' and prodscatm_sts='a'";
				}
				if ($mnlnksid == 4) {
					$sqryprodcat_mst .= " and prodcatm_admtyp='$admtyp' ";
				}
				if ($mnlnksid == 3 || $scatid != '') {
					$sqryprodcat_mst .= "	 order by prodscatm_prty asc";	
				}
				if($scatid==''){
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
									$prodscatm_name = $srowcat_mst['prodscatm_name'];
									$prodmnlnksm_id 	= $srowcat_mst['prodmnlnksm_id'];
									$prodmnlnksm_name = $srowcat_mst['prodmnlnksm_name'];
									if ($mnlnksid == 3 || $scatid != '') {
										$lftlnknm = "category.php?mnlnks=$prodmnlnksm_id&catid=$prodcatm_id&scatid=$prodscatm_id";
										if ($prodscatm_id == $scatid) {
											$cat_cls = "active";
										} else {
											$cat_cls = "";
										}
									} else {
										$lftlnknm = "category.php?mnlnks=$prodmnlnksm_id&catid=$prodcatm_id";
										if ($catid == $prodcatm_id) {
											$cat_cls = "active";
										} else {
											$cat_cls = "";
										}
									}
									if ($mnlnksid == 4) {
										$lftlnknm = "category.php?mnlnks=$prodmnlnksm_id&catid=$prodcatm_id&admtyp=$admtyp";
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

											if ($scatid == $prodscatm_id) {
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
											}
											 else {
												?>
													<p>
														<a class="<?php echo $cat_cls; ?>" href="<?php echo $lftlnknm; ?>">
															<i class="fa-solid fa-chevron-right"></i>
															<?php
															if ($mnlnksid == 3 || $scatid != '') {
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

												if ($scatid == $prodscatm_id) {
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
																	$prodpg_name = $srowpgcnt_mst['pgcntsd_name'];
																	$prodpg_id = $srowpgcnt_mst['pgcntsd_id'];

																	if ($prodpg_id == $prodid ) {
																		$pgcntnt_cls = "active";
																	} else {
																		$pgcntnt_cls = "";
																	}
																?>

																	<li>

																		<p><a class="<?php echo $pgcntnt_cls; ?>" href="pagecontents.php?mnlnks=<?php echo $prodmnlnksm_id; ?>&catid=<?php echo $prodcatm_id; ?>&scatid=<?php echo $prodscatm_id; ?>&prodid=<?php echo $prodpg_id; ?>"><?php echo $prodpg_name; ?></a></p>
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



















<!-- <div class="card">
							<div class="card-header" id="heading<?php echo $prodcatm_id  ?>">
								<h2 class="mb-0">
									<button class="btn btn-link <?php if ($prodcatm_id != $catid) {
																								echo 'collapsed';
																							} else {
																							}   ?>" type="button" data-toggle="collapse" data-target="#collapse<?php echo $prodcatm_id  ?>" aria-expanded="false" aria-controls="collapse<?php echo $prodcatm_id  ?>">
										<?php echo $prodcatm_name; ?>
									</button>
								</h2>
							</div>
							<div id="collapse<?php echo $prodcatm_id  ?>" class="collapse
		<?php
		if ($prodcatm_id == $catid) {
			echo ' in';
		} else {
		}   ?> " aria-labelledby="heading<?php echo $prodcatm_id  ?>" data-parent="#accordionExample">
								<ul class="links-lists p-0 m-0">
									<li>
										<a href="<?php echo $lftlnknm ?>">
											<i class="icon-li icon-double-angle-right"></i> <?php echo $prodcatm_name ?></a>
									</li>
									<?php $sqryprodscat_mst_r = "select 
										prodscatm_id,prodscatm_name,pgcntsd_id,pgcntsd_prodscatm_id,
										pgcntsd_name,pgcntsd_sts,prodcatm_id
									 from
										prodscat_mst
										inner join pgcnts_dtl on pgcntsd_prodscatm_id=prodscatm_id
										inner join prodcat_mst on prodcatm_id=pgcntsd_prodcatm_id
									 where 
										prodscatm_sts='a' and
										pgcntsd_sts='a' and
									    prodcatm_id = $prodcatm_id
										
									group by 
										prodscatm_id
										";

									$srsprodscat_mst_r = mysqli_query($conn, $sqryprodscat_mst_r);
									$cntrec_scat_nav_r = mysqli_num_rows($srsprodscat_mst_r);
									if ($cntrec_scat_nav_r > 0) {

										$rflg 		 = 1;
										$ncatflg  	 = 1;
										while ($srowprodscat_mst_r 	= mysqli_fetch_assoc($srsprodscat_mst_r)) {

											$prodscatm_name	  	= $srowprodscat_mst_r['prodscatm_name'];
											$prodscatm_id	   = $srowprodscat_mst_r['prodscatm_id'];
											$prodcatm_id	   = $srowprodscat_mst_r['prodcatm_id'];

											$pgcntsd_name = $srowprodscat_mst_r['pgcntsd_name'];


											$sqrypgcnts_dtl = "select 
							prodscatm_id,prodscatm_name,pgcntsd_id,pgcntsd_prodscatm_id,
							pgcntsd_name,pgcntsd_sts,prodcatm_id
						 from
							vw_pgcnts_prodcat_prodscat_mst
						 where
							pgcntsd_prodscatm_id='$prodscatm_id	' and
							
							 prodcatm_sts='a' and
							prodscatm_sts='a' 
							and
							pgcntsd_sts='a'
							order by pgcntsd_prty desc limit 1
							";
											$srspgcnts_dtl = mysqli_query($conn, $sqrypgcnts_dtl);
											$num = mysqli_num_rows($srspgcnts_dtl);
											if ($num > 0) {

												while ($rowpgcnts = mysqli_fetch_assoc($srspgcnts_dtl)) {
													$pgcntsd_id = $rowpgcnts['pgcntsd_id'];

									?>
													<li>
														<a href="pagecontents.php?mnlnks=<?php echo $prodmnlnksm_id ?>&catid=<?php echo $prodcatm_id ?>&scatid=<?php echo $prodscatm_id ?>&prodid=<?php echo $pgcntsd_id ?>">
															<i class="icon-li icon-double-angle-right"></i> <?php echo $prodscatm_name ?></a>
													</li>


									<?php	}
											}
										}
									} ?>
							</div>
						</div>
			</div>
		</div>
<?php
// }
// } 
?>
	</div>
	<div class="clearfix"></div>

</div> -->