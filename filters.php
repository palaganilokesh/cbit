<?php
error_reporting(0);
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once 'includes/inc_config.php'; //Making paging validation
include_once 'includes/inc_folder_path.php'; //Making paging validation
include_once 'includes/inc_paging_functions.php'; //Making paging validation
include_once 'includes/inc_paging1.php'; //Includes pagination
// if((isset($_REQUEST['nw_dept_id']) && (trim($_REQUEST['nw_dept_id']) != ""))||(isset($_REQUEST['nw_yr']) && (trim($_REQUEST['nw_yr']) != "")))
// {

	$result = "";
	$nw_dept_id = glb_func_chkvl($_REQUEST['nw_dept_id']);
  $nw_yr = glb_func_chkvl($_REQUEST['nw_yr']);
  $sqrynws_mst = "SELECT evntm_name,evntm_desc,evntm_city, evntm_id,evntm_lnk,evtnm_strttm,evntm_endtm,
  DATE_format(evntm_strtdt, '%D %M %Y') as newstdate,evntm_dept,
  DATE_format(evntm_strtdt, '%d') as nstdt,
  DATE_format(evntm_strtdt, '%b ') as nstmnth,
  DATE_format(evntm_strtdt, '%Y ') as nstyr
    from
  evnt_mst	where evntm_sts='a' and evntm_typ='n' ";
  if (isset($nw_dept_id) && trim($nw_dept_id) != "") {

    $sqrynws_mst .= " and evntm_dept = '$nw_dept_id' ";
    }
    if (isset( $nw_yr) && trim( $nw_yr) != "") {

    $sqrynws_mst .= " and evntm_dept = '$nw_yr' ";
    }
    $sqrynws_mst.="	order by evntm_strtdt ASC ";
  $srsnews_mst  =  mysqli_query($conn, $sqrynws_mst) or die(mysqli_error($conn));
  $numrows1 =   mysqli_num_rows($srsnews_mst);
                        while ($srownews_mst   = mysqli_fetch_assoc($srsnews_mst)) {
                          $evntcnt += 1;
                          $news_nm = $srownews_mst['evntm_name'];
                          $news_url=funStrUrlEncode($news_nm);
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

<a href="<?php echo $rtpth.'latest-news/'.$news_url.'_'.$news_id; ?>"><img src="<?php echo $nwsimgpth;?>" alt="Image"></a>
</div>
<div class="news-content">
<!-- <div class="list">
<ul>
<li><i class="flaticon-user"></i>By <a href="news-details.php">ECE</a></li>
<li><i class="flaticon-tag"></i>Electronics</li>
</ul>
</div> -->
<a href="<?php echo $rtpth.'latest-news/'.$news_url.'_'.$news_id; ?>"><h3><?php echo $news_nm;?></h3></a>
<a href="<?php echo $rtpth.'latest-news/'.$news_url.'_'.$news_id; ?>" class="read-more-btn">Read More<i class="flaticon-next"></i></a>
</div>
</div>
</div>
<?php
					}
				}
	}


// }
?>