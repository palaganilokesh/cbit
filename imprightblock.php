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

$catid1 = $_GET['icatid'];
$catid = funcStrUnRplc($catid1);
$mnlnks1 = $_GET['imnlnks'];
$mnlnksid = funcStrUnRplc($mnlnks1);
$scatid1 = $_GET['iscatid'];
$scatid = funcStrUnRplc($scatid1);
$txt = explode('_', $scatid);
$pt_id = $txt[1];
$pt_scat_nm = $txt[0];
if ($scatid == 'UG' || $scatid == 'PG' || $scatid == 'ug' || $scatid == 'pg') {
	$admtyp = strtoupper($scatid);
	$scatid = '';
} else {
	$scatid = $scatid;
}

?>
<div class="about-us-sideLinks">
	<div class="faq-left-content ">
		<div class="accordion" id="academicsLinks">

			<div class="accordion-item item-custom-1">
				<h2 class="accordion-header " id="heading-2">
					<button class="accordion-button open-df collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#singleDepartment" aria-expanded="false" aria-controls="singleDepartment">
						<?php
						if ($mnlnksid !='' || $scatid != '') {

							echo $mnlnksid ;
						}
						?>
					</button>
				</h2>
				<?php
				$sqryprodcat_mst = "SELECT prodmnlnksm_id,prodmnlnksm_name,prodmnlnksm_typ,prodcatm_id,prodcatm_name,prodcatm_admtyp";
			
				$sqryprodcat_mst .= " from	prodmnlnks_mst 
								inner join prodcat_mst on prodcatm_prodmnlnksm_id=prodmnlnksm_id";
			
				$sqryprodcat_mst .= " where  prodmnlnksm_name='$mnlnksid' and	prodcatm_sts='a'";
			
				if($catid != ''){
					$sqryprodcat_mst .= "	and prodcatm_sts='a' group by prodcatm_name  order by prodcatm_prty";
				}
			
				// echo $sqryprodcat_mst;
				$srsprodcat_mst 		= mysqli_query($conn, $sqryprodcat_mst);
				$cntcat_mst            =  mysqli_num_rows($srsprodcat_mst);
				if ($cntcat_mst > 0) {
				?>
					<div id="singleDepartment" class="accordion-collapse open-df collapse" aria-labelledby="heading-2" data-bs-parent="#academicsLinks">
						<div class="accordion-body p-0 ug-links">
							<ul class="links-lists p-0 m-0">
								<?php
								while ($srowcat_mst = mysqli_fetch_assoc($srsprodcat_mst)) {
									$prodcatm_id 	= $srowcat_mst['prodcatm_id'];
									$prodscatm_id 	= $srowcat_mst['prodscatm_id'];
									$prodcatm_name = $srowcat_mst['prodcatm_name'];
									$caturl = funcStrRplc($prodcatm_name);
									$prodscatm_name = $srowcat_mst['prodscatm_name'];
									$scaturl = funcStrRplc($prodscatm_name);
									$prodmnlnksm_id 	= $srowcat_mst['prodmnlnksm_id'];
									$prodmnlnksm_name = $srowcat_mst['prodmnlnksm_name'];
									$mnlnkurl = funcStrRplc($prodmnlnksm_name);
								
									// $lftlnknm = "$rtpth/$z/$mnlnkurl/$caturl";
									if (strtoupper($catid) == strtoupper($prodcatm_name)) {

										$cat_cls = "active";
									} else {
										$cat_cls = "";
									}
								?>
									<li>
										<?php
										$sqrypgcnt_mst = " SELECT prodmnlnksm_id,prodmnlnksm_name,prodmnlnksm_sts,prodcatm_id,prodcatm_prodmnlnksm_id,prodcatm_name,prodscatm_id,prodscatm_name,prodscatm_sts,prodscatm_prodcatm_id from 	prodmnlnks_mst
									 inner join prodcat_mst on prodcatm_prodmnlnksm_id=prodmnlnksm_id 
									 inner join prodscat_mst on prodscatm_prodcatm_id=prodcatm_id 
										 where  prodscatm_prodmnlnksm_id='$prodmnlnksm_id' and prodscatm_prodcatm_id='$prodcatm_id' and prodcatm_sts='a' and prodmnlnksm_sts='a' and prodscatm_sts='a' order by prodscatm_prty asc";
										$srspgcnt_mst		= mysqli_query($conn, $sqrypgcnt_mst);
										$cntpgcnt_mst            =  mysqli_num_rows($srspgcnt_mst);
										if ($cntpgcnt_mst > 0) {
											// $srowpgcnt_mst1 = mysqli_fetch_assoc($srspgcnt_mst);		
											if (strtoupper($catid) == strtoupper($prodcatm_name)) {
												// echo "here-".$prodid;
												$pg_cls = "accordion-button sub-menus-1";
												$aria = "true";
											} else {
												$pg_cls = "accordion-button sub-menus-1 collapsed";
												$aria = "false";
											}
										?>
											<div class="accordion" id="departmentLinksDrop<?php echo $catid ?>">
												<div class="accordion-item">
													<h2 class="accordion-header" id="heading-1">
														<p><a class="<?php echo $pg_cls; ?>" data-bs-toggle="collapse" data-bs-target="#elig<?php echo $prodcatm_id ?>" aria-expanded="<?php echo $aria; ?>" aria-controls="elig<?php echo $prodcatm_id ?>" href="#"><i class="fa-solid fa-chevron-right"></i>
																<?php echo $prodcatm_name; ?></a>
														</p>
													</h2>
												<?php
											} else {
												?>
													<p>
														<a class="<?php echo $cat_cls; ?>" href="<?php echo $rtpth.'main-links/'.$mnlnkurl.'/'.$caturl; ?>">
															<i class="fa-solid fa-chevron-right"></i>
															<?php
														
																echo $prodcatm_name;
														
															?>
														</a>
													</p>
												<?php
											}
										
											if ($cntpgcnt_mst > 0) {
												
												if (strtoupper($catid) == strtoupper($prodcatm_name)) {
											
													$pg_cls1 = "accordion-collapse collapse show";
													// echo "here".$prodid;
												} else {
													$pg_cls1 = "accordion-collapse collapse";
												}
												?>
													<div id="elig<?php echo $prodcatm_id ?>" class="<?php echo $pg_cls1; ?>" aria-labelledby="heading-1" data-bs-parent="#departmentLinksDrop<?php echo $prodcatm_id ?>" style="">
														<div class="accordion-body py-0 ug-links">
															<ul class="sideLinks-2">
																<?php
																$srspgcnt_mst		= mysqli_query($conn, $sqrypgcnt_mst);
																while ($srowpgcnt_mst = mysqli_fetch_assoc($srspgcnt_mst)) {
																	$prodcatm_id 	= $srowpgcnt_mst['prodcatm_id'];
																	$prodscatm_id 	= $srowpgcnt_mst['prodscatm_id'];
																	$prodcatm_name = $srowpgcnt_mst['prodcatm_name'];
																	$pgcaturl = funcStrRplc($prodcatm_name);
																	$prodscatm_name = $srowpgcnt_mst['prodscatm_name'];
																	$pgscaturl = funcStrRplc($prodscatm_name);

																	if (	strtoupper($prodscatm_name) == strtoupper($scatid)) {
																		$pgcntnt_cls = "active";
																	} else {
																		$pgcntnt_cls = "";
																	}
																?>
																	<li>
																		<p><a class="<?php echo $pgcntnt_cls; ?>" href="<?php echo $rtpth .'main-links/'. $mnlnkurl . '/' . $pgcaturl . '/' . $pgscaturl ; ?>"><?php echo $prodscatm_name; ?></a></p>
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