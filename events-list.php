<?php
error_reporting(0);
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once 'includes/inc_config.php'; //Making paging validation	
include_once 'includes/inc_folder_path.php'; //Making paging validation	
include_once 'includes/inc_paging_functions.php'; //Making paging validation
//$rowsprpg  = $_SESSION['sespgval'];//maximum rows per page	
include_once 'includes/inc_paging1.php'; //Includes pagination  

$evnttoday = date('Y-m-d');
$crntmnty = date('n');
$sqryevnt_mst = "select 
          evntm_id,evntm_name,evntm_desc,evntm_city,
          evntm_strtdt,evntm_enddt,evntm_venue,evtnm_strttm,
          evntm_endtm,DATE_format(evntm_strtdt, '%D %M %Y') as stdate,
          DATE_format(evntm_enddt, '%D %M %Y') as eddate
        from 
          evnt_mst
        where 
          evntm_sts='a'  and evntm_typ='e' ";

if (isset($_REQUEST['id']) && trim($_REQUEST['id']) != "") {
  $evntId      = glb_func_chkvl($_REQUEST['id']);
  $sqryevnt_mst .= " and evntm_id = '$evntId' ";
}
// if((isset($_REQUEST['day']) && (trim ($_REQUEST['day'])!= "") && 
//   isset($_REQUEST['year']) && (trim($_REQUEST['year']) != "") && 
//   isset($_REQUEST['month']) && trim($_REQUEST['month'])!= "")){

//   $CurrMonth	= $_REQUEST['month'];
//   $CurrYear	= $_REQUEST['year'];
//   $CurrDay	= $_REQUEST['day'];
//   $loc 	   .= "&day=$CurrDay&month=$CurrMonth&year=$CurrYear";
//   if($CurrDay < 10){
//       $CurrDay = "0".$CurrDay;
//   }
//   if($CurrMonth < 10){
//       $CurrMonth = "0".$CurrMonth;
//   }					
//   $date = glb_func_chkvl($CurrYear ."-".$CurrMonth."-".$CurrDay);
//   $sqryevnt_mst.=" and '$date' between evntm_strtdt and evntm_enddt ||  '$date' IN (evntm_strtdt,evntm_enddt)";
//   $evnttoday = $date;
//   $crntmnty  = $CurrMonth; 	
// }
// elseif((isset($_REQUEST['date'])!="") && trim($_REQUEST['date']) != ''){
//    $month_name = date('m',$_REQUEST['date']); 
//    $sqryevnt_mst.=" and $month_name between MONTH(evntm_strtdt) and MONTH(evntm_enddt) ||  '$month_name' IN (MONTH(evntm_strtdt),MONTH(evntm_enddt))";
// }else{
//   $sqryevnt_mst.="and
//         (evntm_strtdt >= '$evnttoday' or
//         evntm_enddt >= '$evnttoday') and
//         (month(evntm_strtdt) >= '$crntmnty' or
//         month(evntm_enddt) >= '$crntmnty')";	
// }
$pgqry = $sqryevnt_mst;
$_SESSION['seprodscatqry'] = $sqryevnt_mst;
if (isset($_REQUEST['lstprodcat']) && trim($_REQUEST['lstprodcat']) != "") {
  $evnt_dpt      = glb_func_chkvl($_REQUEST['lstprodcat']);
  $sqryevnt_mst .= " and evntm_dept = '$evnt_dpt' ";
}
$sqryevnt_mst  .=  " group by evntm_id order by evntm_prty DESC ";
// limit $offset,$rowsprpg
// echo 	$sqryevnt_mst;		
$srsevnt_mst     =  mysqli_query($conn, $sqryevnt_mst) or die(mysqli_error($conn));
$cntrec_mst  = mysqli_num_rows($srsevnt_mst);

$page_title = "Events | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Events | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
$rd_crntpgnm="event-list.php";
include('header.php');
?>
<script language="javascript">
function srch_evnt() {
		//alert("");
		var urlval = "";
		if ((document.frmevnt.event.value == "") && (document.frmevnt.lstprodcat.value == "") || (document.frmevnt.txtname.value == "")) {
			alert("Plese Select Search Criteria");
			document.frmevnt.event.focus();
			return false;
		}
		var event = document.frmevnt.event.value;
		var lstprodcat = document.frmevnt.lstprodcat.value;
		var txtname = document.frmevnt.txtname.value;
		if (event != '') {
			if (urlval == "") {
				urlval += "event=" + event;
			} else {
				urlval += "&event=" + event;
			}
		}
		if (lstprodcat != '') {
			if (urlval == "") {
				urlval += "lstprodcat=" + lstprodcat;
			} else {
				urlval += "&lstprodcat=" + lstprodcat;
			}
		}
		// if (txtname != '') {
		// 	if (urlval == "") {
		// 		urlval += "txtname=" + txtname;
		// 	} else {
		// 		urlval += "&txtname=" + txtname;
		// 	}
		// }

			document.frmevnt.action = "<?php echo $rd_crntpgnm; ?>?" + urlval;
			document.frmevnt.submit();
	
		return true;
	}
  </script>
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
      <h1>Events</h1>
      <ul>
        <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
        <li>Events</li>
      </ul>
    </div>
  </div>
</section>
<?php
if ($cntrec_mst > 0) {
?>
<form method="post" action="<?php $_SERVER['SCRIPT_FILENAME']; ?>" name="frmevnt" id="frmevnt">
  <div class="col-md-12">
    <div class="row justify-content-left align-items-center mt-3">
      <div class="col-sm-3">
        <div class="form-group">
          <select name="event" id="event" class="form-control" onchange=get_event()>
            <option value="">Select Academic Year </option>
            <?php
            $sqry_evnt = "SELECT evntm_name,evntm_dept,evntm_crtdon,DATE_format(evntm_strtdt, '%Y') as evn_year from evnt_mst where evntm_sts='a' and evntm_typ='e' group by  evn_year";
            $exqury = mysqli_query($conn, $sqry_evnt);
            $cnt_rows = mysqli_num_rows($exqury);
            while ($filter = mysqli_fetch_assoc($exqury)) {
              $ex_year = $filter['evn_year'];
            ?>
            <option value="<?php echo $ex_year; ?>" <?php if (isset($_REQUEST['event']) && trim($_REQUEST['event']) == $catid) {echo 'selected';} ?>><?php echo $ex_year; ?></option>
             
            <?php
            }
            ?>
          </select>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <select name="lstprodcat" id="lstprodcat" class="form-control">
            <option value="">--Select Department--</option>
            <?php
            $sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name,evntm_dept,evntm_typ from prodcat_mst 
            inner join evnt_mst on evntm_dept=prodcatm_id
            where prodcatm_typ='d' and prodcatm_admtyp='UG' and evntm_typ='e' order by prodcatm_name";
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
            $sqryprodcat_mst1 = "SELECT prodcatm_id,prodcatm_name,evntm_dept,evntm_typ from prodcat_mst
             inner join evnt_mst on evntm_dept=prodcatm_id
             where prodcatm_typ='d' and prodcatm_admtyp='PG' and evntm_typ='e' order by prodcatm_name";
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
      <div class="col-sm-4">
        <div class="form-group">
          <input type="submit" value="Search" class="btn btn-primary" name="btnsbmt" onClick="srch_evnt();">

        </div>
      </div>
    </div>
  </div>

  <div class="campus-information-area section-pad-y">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
      <div class="row justify-content-center">

        <?php

        $cntval = '';
        while ($srowevnt_mst = mysqli_fetch_assoc($srsevnt_mst)) {
          $db_evntm_nm = $srowevnt_mst['evntm_name'];
          $evnt_url = funStrUrlEncode($db_evntm_nm);
          $db_evntm_desc = $srowevnt_mst['evntm_desc'];
          $db_evntm_id = $srowevnt_mst['evntm_id'];
          $db_evntm_vne = $srowevnt_mst['evntm_venue'];
          $db_evntm_strt = $srowevnt_mst['stdate'];
          $db_evntm_end = $srowevnt_mst['eddate'];
          // $db_evntm_lnk = $srowevnt_mst['evntm_img'];
          // $u_evntm_nm = funStrUrlEncode($db_evntm_nm);
          $dsplyNm = $db_evntm_strt;
          if ($db_evntm_end != '') {
            $dsplyNm = $db_evntm_strt . "-" . $db_evntm_end;
          }
          // $urlLnk = $rtpth.'events/'."$u_evntm_nm";
          // if($db_evntm_lnk !=''){
          // 	$urlLnk = 	$db_evntm_lnk;
          // }

          $sqryevntimg_dtl = "SELECT
								evntimgd_name,evntimgd_id,evntimgd_img				  		    
							from 
								  evntimg_dtl
							where 
								evntimgd_evntm_id = '$db_evntm_id'
								order by evntimgd_prty desc limit 1";
          // echo $sqryevntimg_dtl;
          $srsevntimg_dtl = mysqli_query($conn, $sqryevntimg_dtl);
          $serchres1    = mysqli_num_rows($srsevntimg_dtl);
          $imgnm  = '';
          if ($serchres1 > 0) {
            $srowprodimg_dtl = mysqli_fetch_assoc($srsevntimg_dtl);
            $bimg        = $srowprodimg_dtl['evntimgd_img'];
            $bgimgpth     = $u_imgevnt_fldnm . $bimg;
            if (($bimg != '') && file_exists($bgimgpth)) {
              $imgnm =   $bgimgpth;
            } else {
              $imgnm   =  $rtpth . $u_cat_bnrfldnm . 'default.jpg';
            }
          } else {
            $imgnm   =  $rtpth . $u_cat_bnrfldnm . 'default.jpg';
          }
        ?>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="single-health-care-card">
              <div class="img">
                <a href="<?php echo $rtpth . 'latest-events/' . $evnt_url . '_' . $db_evntm_id; ?>"><img src="<?php echo $imgnm; ?>" alt="Image"></a>
              </div>
              <div class="health-care-content">
                <span class="mb-3 pull-right"><i class="flaticon-date"></i><?php echo $dsplyNm; ?></span>
                <a href="<?php echo $rtpth . 'latest-events/' . $evnt_url . '_' . $db_evntm_id; ?>">
                  <h3><?php echo $db_evntm_nm; ?></h3>
                </a>

                <p> <?php echo substr($db_evntm_desc, 0, 100); ?>...</p>
                <a href="<?php echo $rtpth . 'latest-events/' . $evnt_url . '_' . $db_evntm_id; ?>" class="read-more-btn">Read More <i class="flaticon-next"></i></a>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</form>
<?php
}
?>

<?php include_once('footer.php'); ?>