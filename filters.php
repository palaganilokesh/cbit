<?php
error_reporting(0);
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once 'includes/inc_config.php'; //Making paging validation
include_once 'includes/inc_folder_path.php'; //Making paging validation
include_once 'includes/inc_paging_functions.php'; //Making paging validation
include_once 'includes/inc_paging1.php'; //Includes pagination
// news filters starts
if ((isset($_REQUEST['nw_dept_id']) && (trim($_REQUEST['nw_dept_id']) != "")) || (isset($_REQUEST['nw_yr']) && (trim($_REQUEST['nw_yr']) != "")) || (isset($_REQUEST['nw_typ']) && (trim($_REQUEST['nw_typ']) != ""))) {

  $result = "";
  $nw_dept_id = glb_func_chkvl($_REQUEST['nw_dept_id']);
  $nw_yr = glb_func_chkvl($_REQUEST['nw_yr']);
  $sqrynws_mst = "SELECT evntm_name,evntm_desc,evntm_city, evntm_id,evntm_lnk,evtnm_strttm,evntm_endtm,
  DATE_format(evntm_strtdt, '%D %M %Y') as newstdate,evntm_dept,evntm_acyr,
  DATE_format(evntm_strtdt, '%d') as nstdt,
  DATE_format(evntm_strtdt, '%b ') as nstmnth,
  DATE_format(evntm_strtdt, '%Y ') as nstyr
    from
  evnt_mst	where evntm_sts='a'";
  if ($_REQUEST['nw_typ'] == "n") {

    $sqrynws_mst .= "  and evntm_typ='n'  ";
  }

  if (isset($nw_dept_id) && trim($nw_dept_id) != "") {

    $sqrynws_mst .= " and evntm_dept = '$nw_dept_id' ";
  }
  if (isset($nw_yr) && trim($nw_yr) != "") {

    $sqrynws_mst .= " and evntm_acyr = '$nw_yr' ";
  }
  $sqrynws_mst .= "	order by evntm_strtdt ASC ";
  $srsnews_mst  =  mysqli_query($conn, $sqrynws_mst) or die(mysqli_error($conn));
  $numrows1 =   mysqli_num_rows($srsnews_mst);
  if ($numrows1 > 0) {
    while ($srownews_mst   = mysqli_fetch_assoc($srsnews_mst)) {
      $evntcnt += 1;
      $news_nm = $srownews_mst['evntm_name'];
      $news_url = funStrUrlEncode($news_nm);
      $news_dt = $srownews_mst['nstdt'];
      $news_mt = $srownews_mst['nstmnth'];
      $news_yr = $srownews_mst['nstyr'];
      $news_id = $srownews_mst['evntm_id'];

      $news_stdt = $srownews_mst['newstdate'];
      $news_lnk = $srownews_mst['evntm_lnk'];
      $news_strt = $srownews_mst['stdate'];
      $news_desc = $srownews_mst['evntm_desc'];
      //$news_olddt= $srownews_mst['evntm_strtdt'];

?>
      <div class="col-lg-6 col-md-6">
        <div class="single-news-card">
          <?php
          $news_srs_qry = "SELECT evntimgd_sts,evntimgd_img,evntimgd_name,evntimgd_evntm_id,evntimgd_id from evntimg_dtl where evntimgd_evntm_id=$news_id and evntimgd_sts='a' group by evntimgd_evntm_id";
          $news_mst  =  mysqli_query($conn, $news_srs_qry) or die(mysqli_error($conn));
          $nurs =   mysqli_num_rows($news_mst);
          if ($nurs > 0) {
            while ($srownewsimg_mst   = mysqli_fetch_assoc($news_mst)) {
              $nwsimgnm = $srownewsimg_mst['evntimgd_img'];
              $nsimg = $u_imgevnt_fldnm . $nwsimgnm;
              //	$imgpath = $gusrbrnd_upldpth . $imgnm;
              if (($nwsimgnm != "") && file_exists($nsimg)) {
                $nwsimgpth = $rtpth . $nsimg;
              } else {
                $nwsimgpth   =  $rtpth . $u_cat_bnrfldnm . 'default.jpg';
              } ?>
              <div class="news-img">

                <a href="<?php echo $rtpth . 'latest-news/' . $news_url . '_' . $news_id; ?>"><img src="<?php echo $nwsimgpth; ?>" alt="Image"></a>
              </div>
              <div class="news-content">

                <a href="<?php echo $rtpth . 'latest-news/' . $news_url . '_' . $news_id; ?>">
                  <h3><?php echo $news_nm; ?></h3>
                </a>
                <a href="<?php echo $rtpth . 'latest-news/' . $news_url . '_' . $news_id; ?>" class="read-more-btn">Read More<i class="flaticon-next"></i></a>
              </div>
        </div>
      </div>
  <?php
            }
          }
        }
      } else {
        echo "NO DATA FOUND ON NEWS.....";
      }
    }
    // news filters end
    // events filters starts
    if ((isset($_REQUEST['evnt_dept_id']) && (trim($_REQUEST['evnt_dept_id']) != "")) || (isset($_REQUEST['evnt_yr']) && (trim($_REQUEST['evnt_yr']) != "")) || (isset($_REQUEST['ev_typ']) && (trim($_REQUEST['ev_typ']) != ""))) {
      $sqryevnt_mst = "SELECT evntm_id,evntm_name,evntm_desc,evntm_city,
      evntm_strtdt,evntm_enddt,evntm_venue,evtnm_strttm,
      evntm_endtm,DATE_format(evntm_strtdt, '%D %M %Y') as stdate,
      DATE_format(evntm_enddt, '%D %M %Y') as eddate,evntm_acyr
    from
      evnt_mst
    where
      evntm_sts='a'";
      if ($_REQUEST['ev_typ'] == "e") {

        $sqryevnt_mst .= "  and evntm_typ='e'  ";
      }

      if (isset($_REQUEST['evnt_dept_id']) && trim($_REQUEST['evnt_dept_id']) != "") {
        $evnt_dpt      = glb_func_chkvl($_REQUEST['evnt_dept_id']);
        $sqryevnt_mst .= " and evntm_dept = '$evnt_dpt' ";
      }
      if (isset($_REQUEST['evnt_yr']) && trim($_REQUEST['evnt_yr']) != "") {
        $evnt_yr      = glb_func_chkvl($_REQUEST['evnt_yr']);
        $sqryevnt_mst .= " and evntm_acyr = '$evnt_yr' ";
      }
      $sqryevnt_mst  .=  " group by evntm_id order by evntm_prty DESC ";
      // limit $offset,$rowsprpg
      // echo 	$sqryevnt_mst;
      $srsevnt_mst     =  mysqli_query($conn, $sqryevnt_mst) or die(mysqli_error($conn));
      $cntrec_mst  = mysqli_num_rows($srsevnt_mst);
      if ($cntrec_mst > 0) {
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
      } else {
        echo "No Data Found On Events...";
      }
    }
    //  events end

    //  notifications---announcements

    if ((isset($_REQUEST['not_dept_id']) && (trim($_REQUEST['not_dept_id']) != "")) || (isset($_REQUEST['not_yr']) && (trim($_REQUEST['not_yr']) != "")) || (isset($_REQUEST['not_typ']) && (trim($_REQUEST['not_typ']) != ""))) {


      $sqryanounce_mst = "SELECT nwsm_id,nwsm_name,nwsm_sts,nwsm_prty,nwsm_typ,nwsm_img,nwsm_dwnfl,date_format(nwsm_dt,'%d-%m-%Y') as nwsm_dt,nwsm_desc,nwsm_lnk,nwsm_acyr,nwsm_dept	from nws_mst where nwsm_id != ''and nwsm_sts='a' ";
      if (isset($_REQUEST['not_dept_id']) && trim($_REQUEST['not_dept_id']) != "") {

        $not_dept_id      = glb_func_chkvl($_REQUEST['not_dept_id']);
        $sqryanounce_mst .= " and nwsm_dept = '$not_dept_id' ";
      }
      if (isset($_REQUEST['not_yr']) && trim($_REQUEST['not_yr']) != "") {
        $not_yr      = glb_func_chkvl($_REQUEST['not_yr']);
        $sqryanounce_mst .= " and nwsm_acyr = '$not_yr' ";
      }
      if (isset($_REQUEST['not_typ']) && trim($_REQUEST['not_typ']) != "") {
        $not_typ      = glb_func_chkvl($_REQUEST['not_typ']);
        $sqryanounce_mst .= " and nwsm_typ = '$not_typ' ";
      }
      $sqryanounce_mst .= " order by nwsm_prty asc";
      // echo $sqryanounce_mst;
      $srsanounce_mst = mysqli_query($conn, $sqryanounce_mst);
      $cnt_anounce = mysqli_num_rows($srsanounce_mst);
      if ($cnt_anounce > 0) {
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

<?php
        }
      } else {
        echo "NO DATA FOUND....";
      }
    } ?>