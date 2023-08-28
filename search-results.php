<?php
error_reporting(0);
include_once 'includes/inc_connection.php';
include_once 'includes/inc_paging_functions.php'; //Making paging validation
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
/***************************************************************/
//Programm 	  : sub-pagecontent.php
//Company 	  : Adroit
/************************************************************/
global $loc, $title, $rowsprpg, $cntstart, $scat_id, $arr, $opt; //Stores the message


$sqrypgcnts_mst = "SELECT  prodmnlnksm_id, prodmnlnksm_name, prodmnlnksm_desc, prodcatm_id, prodcatm_name, prodcatm_desc, prodscatm_id, prodscatm_name, prodscatm_desc,prodscatm_id, prodscatm_name, prodscatm_desc,pgcntsd_id, pgcntsd_name, pgcntsd_desc,prodcatm_admtyp
    from  vw_pgcnts_prodcat_prodscat_mst 
     where prodmnlnksm_sts='a' and prodcatm_sts = 'a' ";
if (isset($_REQUEST['txtsrchval']) && (trim($_REQUEST['txtsrchval']) != "")) {
	$hdrsrchval =  funcStrUnRplc($_REQUEST['txtsrchval']);
}
if (isset($_REQUEST['txtsrchval2']) && (trim($_REQUEST['txtsrchval2']) != "")) {
	$hdrsrchval =  funcStrUnRplc($_REQUEST['txtsrchval2']);
}

$sqrypgcnts_mst .= "  and (prodmnlnksm_name like '%$hdrsrchval%' or prodcatm_name like '%$hdrsrchval%' or prodscatm_name like '%$hdrsrchval%' or pgcntsd_name like '%$hdrsrchval%' ) order by prodcatm_prty asc ";
// or prodmnlnksm_desc like '%$hdrsrchval%' or prodcatm_desc like '%$hdrsrchval%' or prodscatm_desc like '%$hdrsrchval%' or pgcntsd_desc like '%$hdrsrchval%'

//  and prodscatm_sts = 'a' and pgcntsd_sts='a'
// echo 	$sqrypgcnts_mst; 
$srspgcnts_mst = mysqli_query($conn, $sqrypgcnts_mst);
$cnt_recpgcnts = mysqli_num_rows($srspgcnts_mst);
// ------------notifications-------
$sqrypgcnts_mst1 = "SELECT nwsm_id,nwsm_name,nwsm_desc,nwsm_typ,nwsm_sts from nws_mst
     where nwsm_sts='a'  and (nwsm_name like '%$hdrsrchval%' or nwsm_desc like '%$hdrsrchval%' ) order by nwsm_prty asc";
// echo 	$sqrypgcnts_mst1; 
$srspgcnts_mst1 = mysqli_query($conn, $sqrypgcnts_mst1);
$cnt_recpgcnts1 = mysqli_num_rows($srspgcnts_mst1);
// ------------notifications-------
// ------------events and news-------
$sqrypgcnts_mst2 = "SELECT evntm_id,evntm_name,evntm_desc,evntm_typ,evntm_sts from  evnt_mst
    where evntm_sts='a'  and (evntm_name like '%$hdrsrchval%' or evntm_desc like '%$hdrsrchval%' ) order by evntm_prty asc";
// echo 	$sqrypgcnts_mst2; 
$srspgcnts_mst2 = mysqli_query($conn, $sqrypgcnts_mst2);
$cnt_recpgcnts2 = mysqli_num_rows($srspgcnts_mst2);
// ------------events and news-------
// ------------achivements-------
$sqrypgcnts_mst3 = "SELECT achmntm_id,achmntm_name,achmntm_sdesc,achmntm_desc,achmntm_sts from  achmnt_mst
where achmntm_sts='a'  and (achmntm_name like '%$hdrsrchval%' or achmntm_sdesc like '%$hdrsrchval%' or achmntm_desc like '%$hdrsrchval%' ) order by achmntm_prty asc";
// echo 	$sqrypgcnts_mst3; 
$srspgcnts_mst3 = mysqli_query($conn, $sqrypgcnts_mst3);
$cnt_recpgcnts3 = mysqli_num_rows($srspgcnts_mst3);
// ------------achivements-------
// ------------gallery-------
$sqrypgcnts_mst4 = "SELECT phtd_id,phtd_phtcatm_id,phtd_name,phtd_desc,phtd_sts,phtm_id,phtm_phtd_id,phtm_phtcatm_id,phtm_simgnm,phtm_sts,phtcatm_id,phtcatm_typ,phtcatm_deprtmnt,phtcatm_name,phtcatm_desc from   phtcat_mst
left join  vw_phtd_phtm_mst on phtd_phtcatm_id=phtcatm_id
where phtcatm_sts='a'  and (phtcatm_name like '%$hdrsrchval%' or phtcatm_desc like '%$hdrsrchval%' or phtd_name like '%$hdrsrchval%' or phtm_simgnm like '%$hdrsrchval%')  group by phtcatm_id order by phtcatm_prty asc";
// echo 	$sqrypgcnts_mst4; 
$srspgcnts_mst4 = mysqli_query($conn, $sqrypgcnts_mst4);
$cnt_recpgcnts4 = mysqli_num_rows($srspgcnts_mst4);
// ------------gallery-------
$new_count=$cnt_recpgcnts+$cnt_recpgcnts1+$cnt_recpgcnts2+$cnt_recpgcnts3+$cnt_recpgcnts4;
$cnt = $offset;
echo "<br/>";
$dispval = "<span> Text Search For :</span>" . "'" . $hdrsrchval . "'";
$title = "";
if ($cnt_recpgcnts == 0 && $cnt_recpgcnts1 == 0 && $cnt_recpgcnts2 == 0  && $cnt_recpgcnts3 == 0 && $cnt_recpgcnts4==0) {
	$emptyval = "Your search - $hdrsrchval - did not match any information.";
}
// else {
// 	header("Location:index.php");
// 	exit();
// }
$page_title = "Search Results";
$current_page = 'search';
include('header.php');
?>
<section class="page">
	<div class="container">
		<h3 class="title text-primary">
			<?php echo $dispval; ?>
		</h3>
		<div class="alert alert-warning">
			<?php echo $new_count; ?> results found
		</div>
		<div class="well">
			<ul class="list-unstyled">
				<?php
				if ($cnt_recpgcnts > 0) {
					$dsp_dtl = "";
					$pgurl = "";
					$prodscat_name = "";
					$disppgurl = "";
					while ($srowspgcnts_mst = mysqli_fetch_assoc($srspgcnts_mst)) {
						$prodmnlnks_id = $srowspgcnts_mst['prodmnlnksm_id'];
						$prodmnlnks_name = $srowspgcnts_mst['prodmnlnksm_name'];
						$mnlnks_url = funcStrRplc($prodmnlnks_name);
						$prodcat_id = $srowspgcnts_mst['prodcatm_id'];
						$prodcat_nm = $srowspgcnts_mst['prodcatm_name'];
						$cat_url = funcStrRplc($prodcat_nm);
						$prodscat_id = $srowspgcnts_mst['prodscatm_id'];
						$prodscat_nm = $srowspgcnts_mst['prodscatm_name'];
						$scat_url = funcStrRplc($prodscat_nm);
						$admt_type = $srowspgcnts_mst['prodcatm_admtyp'];
						$prodcat_desc = $srowspgcnts_mst['prodcatm_desc'];
						$s_des = substr($prodcat_desc, 0, 100);
						$pgcnt_id = $srowspgcnts_mst['pgcntsd_id'];
						$pgcnt_name = $srowspgcnts_mst['pgcntsd_name'];
						$pgcnt_url=funcStrRplc($pgcnt_name);

						// $pgurl = $rtpth . $mnlnks_url . "/" . $cat_url;
						if($prodmnlnks_id=='3' && $prodscat_id!=''){
							
							$pgurl = $rtpth . $mnlnks_url . "/" . $cat_url.'/'.$scat_url;
							$dsp_dtl .= "<li><h4>&raquo; <a href='$pgurl'>$prodscat_nm</a></h4></li>";
						}
						else if($prodmnlnks_id=='4' && $admt_type=='UG'){
					
						$pgurl = $rtpth . $mnlnks_url . "/" . $cat_url.'/'.$admt_type;
							$dsp_dtl .= "<li><h4>&raquo; <a href='$pgurl'>$prodcat_nm</a></h4></li>";
						}
						else if($prodmnlnks_id=='4' && $admt_type=='PG'){
							$pgurl = $rtpth . $mnlnks_url . "/" . $cat_url.'/'.$admt_type;
							$dsp_dtl .= "<li><h4>&raquo; <a href='$pgurl'>$prodcat_nm</a></h4></li>";
						}
						
						else if($prodmnlnks_id=='3' && $prodscat_id!='' && $pgcnt_id!=''){
							$pgurl = $rtpth . $mnlnks_url . "/" . $cat_url.'/'.$scat_url.'/'.$pgcnt_url;
							$dsp_dtl .= "<li><h4>&raquo; <a href='$pgurl'>$pgcnt_name</a></h4></li>";

						}
						else if($prodmnlnks_id!='' && $prodcat_id!='' && $prodscat_id!=''){
							$pgurl = $rtpth . $mnlnks_url . "/" . $cat_url.'/'.$scat_url;
							$dsp_dtl .= "<li><h4>&raquo; <a href='$pgurl'>$prodscat_nm</a></h4></li>";

						}
						else{
							$pgurl = $rtpth . $mnlnks_url . "/" . $cat_url;
							$dsp_dtl .= "<li><h4>&raquo; <a href='$pgurl'>$prodcat_nm</a></h4></li>";
						}

						// $dsp_dtl .= $s_des;
					}
					echo $dsp_dtl;
				} else {
					// echo $emptyval;
				}
				?>
			</ul>
		</div>

		<!-- -------------------------Notifications programs---------------------------------------------- -->
		<!-- <?php
		$dispval1 .= "<span>Notifications or Anouncements Search For :</span>" . "'" . $hdrsrchval . "'";
		?>
		<h3 class="title text-primary">
			<?php echo $dispval1; ?>
		</h3>
		<div class="alert alert-warning">
			<?php echo $cnt_recpgcnts1; ?> results found in notification
		</div> -->
		<div class="well">
			<ul class="list-unstyled">
				<?php
				if ($cnt_recpgcnts1 > 0) {
					$dsp_dtl1 = "";
					$pgurl = "";
					$prodscat_name = "";
					$disppgurl = "";
					while ($srowspgcnts_mst1 = mysqli_fetch_assoc($srspgcnts_mst1)) {
						$nws_id = $srowspgcnts_mst1['nwsm_id'];
						$nws_typ = $srowspgcnts_mst1['nwsm_typ'];
						$nws_name = $srowspgcnts_mst1['nwsm_name'];
						$nws_url = funcStrRplc($nws_name);
						$nws_desc = $srowspgcnts_mst1['nwsm_desc'];
						$nwsd_url = funcStrRplc($nws_desc);
						if ($nws_typ == '2') {
													
							$pgurl1 = $rtpth."latest-notifications/2/". $nws_url.'_'.$nws_id;
						}
						if ($nws_typ == '4') {
							$pgurl1 = $rtpth."latest-notifications/4/". $nws_url.'_'.$nws_id;
						}
						if ($nws_typ == '5') {
							$pgurl1 = $rtpth."latest-notifications/5/". $nws_url.'_'.$nws_id;
						}


						$dsp_dtl1 .= "<li><h4>&raquo; <a href='$pgurl1'>$nws_name</a></h4></li>";
					}
					echo $dsp_dtl1;
				} else {
					// echo $emptyval;
				}
				?>
			</ul>
		</div>
		<!-- end notification -->
		<!-- -------------------------Events and News programs---------------------------------------------- -->
		<!-- <?php
		$dispval2 .= "<span>Events or News Search For :</span>" . "'" . $hdrsrchval . "'";
		?>
		<h3 class="title text-primary">
			<?php echo $dispval2; ?>
		</h3>
		<div class="alert alert-warning">
			<?php echo $cnt_recpgcnts2; ?> results found in events or news
		</div> -->
		<div class="well">
			<ul class="list-unstyled">
				<?php
				if ($cnt_recpgcnts2 > 0) {
					$dsp_dtl2 = "";
					$pgurl = "";
					$prodscat_name = "";
					$disppgurl = "";
					while ($srowspgcnts_mst2 = mysqli_fetch_assoc($srspgcnts_mst2)) {
						$event_id = $srowspgcnts_mst2['evntm_id'];
						$event_typ = $srowspgcnts_mst2['evntm_typ'];
						$event_name = $srowspgcnts_mst2['evntm_name'];
						$event_url = funcStrRplc($event_name);
						$execprog_name = $srowspgcnts_mst2['evntm_desc'];
						$execprog_url = funcStrRplc($execprog_name);
						if ($event_typ == 'e') {
							$pgurl2 = $rtpth."latest-events/".$event_url.'_'.$event_id;
							
						}
						if ($event_typ == 'n') {
							
							$pgurl2 = $rtpth."latest-news/".$event_url.'_'.$event_id;
						}

						$dsp_dtl2 .= "<li><h4>&raquo; <a href='$pgurl2'>$event_name</a></h4></li>";
					}
					echo $dsp_dtl2;
				} else {
					// echo $emptyval;
				}
				?>
			</ul>
		</div>
		<!-- end notification -->
		<!-- -------------------------Achivements---------------------------------------------- -->
		<!-- <?php
		$dispval3 .= "<span>Achivements Search For :</span>" . "'" . $hdrsrchval . "'";
		?>
		<h3 class="title text-primary">
			<?php echo $dispval3; ?>
		</h3>
		<div class="alert alert-warning">
			<?php echo $cnt_recpgcnts3; ?> results found in Achivements
		</div> -->
		<div class="well">
			<ul class="list-unstyled">
				<?php
				if ($cnt_recpgcnts3 > 0) {
					$dsp_dtl3 = "";
					$pgurl = "";
					$prodscat_name = "";
					$disppgurl = "";
					while ($srowspgcnts_mst3 = mysqli_fetch_assoc($srspgcnts_mst3)) {
						$achmt_id = $srowspgcnts_mst3['achmntm_id'];
						$achmt_desc = $srowspgcnts_mst3['achmntm_desc'];
						$achmt_name = $srowspgcnts_mst3['achmntm_name'];
						$achmt_url = funcStrRplc($event_name);
						$execprog_sdesc = $srowspgcnts_mst3['achmntm_sdesc'];
						$achmntdes_url = funcStrRplc($execprog_sdesc);

						// $pgurl2 = $rtpth."latest-achivements/".$achmt_url.''.$achmt_id;
						$pgurl3 = $rtpth."latest-achivements/".$achmt_url.'_'.$achmt_id;


						$dsp_dtl3 .= "<li><h4>&raquo; <a href='$pgurl3'>$achmt_name</a></h4></li>";
					}
					echo $dsp_dtl3;
				} else {
					// echo $emptyval;
				}
				?>
			</ul>
		</div>
		<!-- -------------------------------end achivements -------------------------->
		<!-- -------------------------Gallery---------------------------------------------- -->
		<!-- <?php
		$dispval4 .= "<span>Gallery Search For :</span>" . "'" . $hdrsrchval . "'";
		?>
		<h3 class="title text-primary">
			<?php echo $dispval4; ?>
		</h3>
		<div class="alert alert-warning">
			<?php echo $cnt_recpgcnts4; ?> results found in Gallery
		</div> -->
		<div class="well">
			<ul class="list-unstyled">
				<?php
				if ($cnt_recpgcnts4 > 0) {
					$dsp_dtl4 = "";
					$pgurl = "";
					$prodscat_name = "";
					$disppgurl = "";
					while ($srowspgcnts_mst4 = mysqli_fetch_assoc($srspgcnts_mst4)) {
						$phtcatm_id = $srowspgcnts_mst4['phtcatm_id'];
						$phtcatm_typ = $srowspgcnts_mst4['phtcatm_typ'];
						$phtcatm_name = $srowspgcnts_mst4['phtcatm_name'];
						$phtcatm_url = funcStrRplc($phtcatm_name);
						$phtcatm_desc = $srowspgcnts_ms42['phtcatm_desc'];
						$phtcatm_url = funcStrRplc($phtcatm_desc);
						if ($phtcatm_typ == 'c') {
							
							$pgurl4 = $rtpth."photo-gallery/".$phtcatm_url.'_'.$phtcatm_id;
						}
						if ($phtcatm_typ == 'd') {
							$pgurl4 =$rtpth."photo-gallery/".$phtcatm_url.'_'.$phtcatm_id;
						}

						$dsp_dtl2 .= "<li><h4>&raquo; <a href='$pgurl4'>$phtcatm_name</a></h4></li>";
					}
					echo $dsp_dtl2;
				} else {
					echo $emptyval;
				}
				?>
			</ul>
		</div>
		<!-- end notification -->

	</div>
</section>
<?php include_once('footer.php'); ?>