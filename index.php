<?php
error_reporting(0);
session_start();
include_once 'includes/inc_config.php'; //Making paging validation	
include_once 'includes/inc_connection.php'; //Making database Connection
include_once 'includes/inc_usr_functions.php'; //checking for session	
//include_once 'includes/inc_usr_sessions.php';
include_once 'includes/inc_folder_path.php';
$page_title = "Home | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Home | Chaitanya Bharathi Institute of Technology";
$page_title = "Home | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Home | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
include('header.php');
?>
<!-- banners dynamic start -->
<?php
$sqryqry_bnr = "SELECT bnrm_id, bnrm_name,bnrm_btn_name, bnrm_desc,bnrm_text, bnrm_imgnm, bnrm_lnk, bnrm_prty, bnrm_sts FROM bnr_mst WHERE bnrm_sts = 'a' order by bnrm_prty asc ";
$sqry_bnr_mst = mysqli_query($conn, $sqryqry_bnr);
$bnr_cnt = mysqli_num_rows($sqry_bnr_mst);
if ($bnr_cnt > 0) {
?>
  <div class="homeBanners">
    <div class="homeBanner-slider mb-20 owl-carousel owl-theme">
      <?php
      while ($srowbnr_mst = mysqli_fetch_assoc($sqry_bnr_mst)) {
        $bnrid = $srowbnr_mst['bnrm_id'];
        $bnrttl = $srowbnr_mst['bnrm_name'];
        $bnrnm = $srowbnr_mst['bnrm_btn_name'];

        $bnrlnk = $srowbnr_mst['bnrm_lnk'];
        $bnrimgnm = $srowbnr_mst['bnrm_imgnm'];
        $bnrtxt = $srowbnr_mst['bnrm_text'];
        if ($bnrtxt == 'L') {
          $i = 1;
        } elseif ($bnrtxt == 'R') {
          $i = 2;
        } else {
          $i = 3;
        }
        $bnrimgpth = $rtpth . $gusrbnr_fldnm . $bnrimgnm;
      ?>
        <div class="item">
          <a href="<?php echo $bnrlnk; ?>" target="_blank">
            <img src="<?php echo $bnrimgpth; ?>" class="w-100 d-md-block d-none" alt="">
            <img src="<?php echo $bnrimgpth; ?>" class="w-100 d-md-none d-block" alt=""></a>
          <?php
          if ($bnrnm != '') {
          ?>
            <div class="banner-know-more-btn-<?php echo $i; ?>">
              <a href="<?php echo $bnrlnk; ?>" target="_blank" class="custom-btn-12 transt"><?php echo $bnrnm; ?> <i class="fa-solid fa-chevron-right"></i></a>
            </div>
          <?php
          }
          ?>

        </div>
      <?php
      }
      ?>
    </div>
  </div>
<?php
}
?>
<!-- banners dynamic end -->
<div class="campus-information-area section-pad-y pb-0 d-none">
  <div class="container-fluid px-lg-3 px-md-3 px-2">
    <div class="row">
      <div class="col-lg-6">
        <div class="campus-image">
          <img src="<?php echo $rtpth; ?>assets/images/cbit-welcome-2.jpg" alt="Image">
        </div>
      </div>
      <div class="col-lg-6">
        <div class="campus-content pr-20">
          <div class="section-title  text-start mb-3">
            <h2>WELCOME TO CBIT</h2>
          </div>
          <div class="campus-title">
            <p>We are known for our immaculate engineering and management courses, our emphasis on research
              and advanced methods of instruction always keep pushing towards excellence. </p>
          </div>
          <div>
            <h5>Our History</h5>
            <p>CHAITANYA BHARATHI INSTITUTE OF TECHNOLOGY, established in the Year 1979, esteemed as the
              Premier Engineering Institute in the States of Telangana and Andhra Pradesh, was promoted by
              a Group of Visionaries from varied Professions
              of Engineering, Medical, Legal and Management, with an Objective to facilitate </p>
          </div>
          <div class="mb-lg-0 mb-md-0 mt-3">
            <a href="<?php echo $rtpth; ?>about-us" class="custom-btn-12 green">Read more <i class="fa-solid fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Departments Dynamic Start  -->
<?php
$sqry_dept = "SELECT prodmnlnksm_id,prodmnlnksm_name,prodmnlnksm_desc,prodmnlnksm_bnrimg,prodmnlnksm_typ,prodmnlnksm_dsplytyp,prodmnlnksm_prty,prodmnlnksm_sts,prodcatm_id,prodcatm_prodmnlnksm_id,prodcatm_name,prodcatm_desc,prodcatm_bnrimg,prodcatm_icn,prodcatm_dsplytyp,prodcatm_typ,prodcatm_sts,prodcatm_prty,prodscatm_id,prodscatm_name from  prodmnlnks_mst
 left join  prodcat_mst on prodcatm_prodmnlnksm_id = prodmnlnksm_id
 inner join prodscat_mst on prodscatm_prodcatm_id = prodcatm_id
 where prodmnlnksm_id !='' and prodmnlnksm_sts ='a' and prodmnlnksm_sts = 'a' and prodcatm_sts='a'  and prodmnlnksm_name='Departments' group by prodcatm_id order by prodcatm_prty asc ";

//  where prodmnlnksm_id !='' and prodmnlnksm_sts = 'a' and prodcatm_sts='a'  and prodmnlnksm_name='Departments' group by prodcatm_id";

// ,prodscatm_id,prodscatm_name,prodscatm_desc,prodscatm_bnrimg,prodscatm_dpttitle,prodscatm_dpthead,prodscatm_dptname,prodscatm_sts,prodscatm_prodcatm_id,prodscatm_prodmnlnksm_id,prodscatm_prty 
// left join prodscat_mst on prodscatm_prodcatm_id = prodcatm_id and prodscatm_sts='a'
$sqry_dept_mst = mysqli_query($conn, $sqry_dept);
$dept_cnt = mysqli_num_rows($sqry_dept_mst);
if ($dept_cnt > 0) {
?>
  <div class="courses-area section-pad-y">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
      <div class="section-title">
        <h2>Departments</h2>
      </div>
      <div class="courses-slider mb-20 owl-carousel owl-theme">
        <?php
        while ($srowdept_mst = mysqli_fetch_assoc($sqry_dept_mst)) {
          $deptid = $srowdept_mst['prodmnlnksm_id'];
          $deptmn_nm = $srowdept_mst['prodmnlnksm_name'];
          $hm_mn_url=funcStrRplc($deptmn_nm);
          $deptcatid = $srowdept_mst['prodcatm_id'];
       
          $deptscatid = $srowdept_mst['prodscatm_id'];
          $deptscat_nm = $srowdept_mst['prodscatm_name'];
          $hm_scat_url=funcStrRplc($deptscat_nm);
          $deptnm = $srowdept_mst['prodcatm_name']; //sub category department title
          $hm_cat_url=funcStrRplc($deptnm);
          $deptimgnm = $srowdept_mst['prodcatm_icn'];

          $deptimg = $u_cat_icnfldnm . $deptimgnm;
          //	$imgpath = $gusrbrnd_upldpth . $imgnm;
          if (($deptimgnm != "") && file_exists($deptimg)) {

            $deptimgpth = $rtpth . $deptimg;
          } else {
            $deptimgpth   = $rtpth . $u_cat_bnrfldnm . 'default.jpg';
            //$deptimgpth="catbnr/default.jpg";
          }
        ?>
          <div class="single-courses-card style2">
            <div class="courses-img">
            
              <a href="<?php echo $rtpth . $hm_mn_url . '/' . $hm_cat_url.'/'.$hm_scat_url; ?>"><img src="<?php echo $deptimgpth; ?>" alt="Image"></a>
            </div>
            <div class="courses-content">
              <a href="<?php echo $rtpth . $hm_mn_url . '/' . $hm_cat_url.'/'.$hm_scat_url; ?>">
                <h3><?php echo $deptnm; ?></h3>
              </a>


              <a href="<?php echo $rtpth . $hm_mn_url . '/' . $hm_cat_url.'/'.$hm_scat_url; ?>" class="read-more-btn pull-right">Read more<i class="flaticon-next"></i></a>
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
?>
<!-- Departments Dynamic End  -->
<div class="podcasts-area section-pad-y news-events-home pt-0">
  <div class="container-fluid px-lg-3 px-md-3 px-2">
    <div class="row">
      <div class="col-lg-8">
        <div class="row slide-on-mob news-notif">
          <div class="description">
            <div class="container-fluid px-lg-3 px-md-3 px-2 p-0">
              <nav>
                <div class="nav nav-tabs d-flex mb-0" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-overview-tab" data-bs-toggle="tab" data-bs-target="#nav-overview" type="button" role="tab" aria-controls="nav-overview" aria-selected="true">Events</button>
                  <button class="nav-link" id="nav-curriculum-tab" data-bs-toggle="tab" data-bs-target="#nav-curriculum" type="button" role="tab" aria-controls="nav-curriculum" aria-selected="false">News</button>
                </div>
              </nav>
              <div class="tab-content news-events-tabContent" id="nav-tabContent">
                <!-- events start dynamic -->
                <?php
                $evntToday  = date('Y-m-d');
                $CurrMonth  = date("n");
                $sqryevnt_mst = "SELECT evntm_name,evntm_desc,evntm_city,	evntm_id,evntm_venue,evtnm_strttm,evntm_endtm,
	DATE_format(evntm_strtdt, '%D %M %Y') as stdate,
	DATE_format(evntm_strtdt, '%d') as stdt,
	DATE_format(evntm_strtdt, '%b ') as stmnth,
	DATE_format(evntm_strtdt, '%Y ') as styr,
	DATE_format(evntm_enddt, '%D %M %Y') as eddate,evntm_strtdt
from 
evnt_mst	where evntm_sts='a' and evntm_typ='e' and
(evntm_strtdt >= '$evntToday' or	evntm_enddt >= '$evntToday') and	(month(evntm_strtdt) >= '$CurrMonth' or	month(evntm_enddt) >= '$CurrMonth') 	
	order by evntm_strtdt ASC limit 3 ";
                $srsevnt_mst  =  mysqli_query($conn, $sqryevnt_mst) or die(mysqli_error($conn));
                $numrows =   mysqli_num_rows($srsevnt_mst);
                $cnt = 0;
                if ($numrows  > 0) { ?>
                  <div class="tab-pane fade show active" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                    <div class="overview">
                      <div class="learn row mb-0">
                        <?php
                        while ($srowevnt_mst   = mysqli_fetch_assoc($srsevnt_mst)) {
                          $evntcnt += 1;
                          $evnt_nm = $srowevnt_mst['evntm_name'];
                          $evnt_url=funStrUrlEncode($evnt_nm);
                          $evntm_id = $srowevnt_mst['evntm_id'];
                          $evnt_vnu = $srowevnt_mst['evntm_venue'];
                          $evnt_stdt = $srowevnt_mst['stdt'];
                          $evnt_stmth = $srowevnt_mst['stmnth'];
                          $evnt_styr = $srowevnt_mst['styr'];
                          $evnt_strt = $srowevnt_mst['stdate'];
                          $evnt_desc = $srowevnt_mst['evntm_desc'];
                          $evnt_olddt = $srowevnt_mst['evntm_strtdt'];
                          $evnt_descstring = strip_tags($evnt_desc);
                          if (strlen($evnt_descstring) > 100) {
                            // truncate string
                            $evnt_descstringCut = substr($evnt_descstring, 0, 100);
                            $evnt_descPoint = strrpos($evnt_descstringCut, ' ');
                            //if the string doesn't contain any space then it will cut without word basis.
                            $evnt_desc = $evnt_descPoint ? substr($evnt_descstringCut, 0, $evnt_descPoint) : substr($evnt_descstringCut, 0);
                            //$string .= '... <a href="/this/story">Read More</a>';
                          } else {
                            $evnt_desc = strip_tags($evnt_desc);;
                          }
                          $u_evntm_nm = funStrUrlEncode($evnt_nm);
                          $db_evntm_end = $srowevnt_mst['eddate'];
                          $dsplyNm = $evnt_strt;
                          $sttm = strtotime($evnt_strt);
                          if ($db_evntm_end != '') {
                            //$dsplyNm = $evnt_strt."-".$db_evntm_end;
                          }
                          $urlLnk = $rtpth . 'events/' . "$u_evntm_nm";
                          if ($db_evntm_lnk != '') {
                            $urlLnk =   $db_evntm_lnk;
                          }
                        ?>

                          <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-12">
                            <div class="single-podcasts-card" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200" data-aos-once="true">
                              <div class="row align-items-start gx-lg-3 gx-md-3 gx-0">
                                <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-2 col-2">
                                  <div class="ent-date">
                                    <div class="dte">
                                      <p><?php echo $evnt_stdt; ?></p>
                                    </div>
                                    <div class="mnt">
                                      <p><?php echo $evnt_stmth; ?></p>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xxl-11 col-xl-11 col-lg-11 col-md-10 col-10">
                                  <div class="podcast-content">
                                    <?php
                                    if ($evntToday <= $evnt_strt) {
                                    ?>
                                      <span><img src="<?php echo $rtpth; ?>assets/images/icon/new.gif" alt=""></span>
                                    <?php  }

                                    ?>

                                    <h3><?php echo $evnt_nm ?></h3>
                                    <p><strong>Venue: </strong><?php echo $evnt_vnu ?></p>
                                    <!-- <p><a href="<?php echo $rtpth . "events.php?day=" . trim($evnt_stdt) . "&month=" . trim($evnt_stmth) . "&year=" . trim($evnt_styr) . "&date=" . trim($sttm) ?>"><?php echo $evnt_desc ?></a></p> -->
                                    <a href="<?php echo $rtpth.'latest-events/'.$evnt_url.'_'.$evntm_id; ?>" class="read-more-btn float-end">Read more<i class="flaticon-next"></i></a>

                                   
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php } ?>

                      </div>
                    </div>
                    <div class="single-podcasts-card mb-0">
                      <div class="row align-items-center justify-content-end">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
                          <div class="mb-lg-0 mb-md-0 mb-2 text-end">
                            <a href="<?php echo $rtpth ?>events" class="custom-btn-12 green">View All<i class="fa-solid fa-chevron-right"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>

                <!-- events end -->
                <!-- News dynamic start -->
                <?php
                $sqrynws_mst = "SELECT evntm_name,evntm_desc,evntm_city, evntm_id,evntm_lnk,evtnm_strttm,evntm_endtm,
									DATE_format(evntm_strtdt, '%D %M %Y') as newstdate,
									DATE_format(evntm_strtdt, '%d') as nstdt,
							DATE_format(evntm_strtdt, '%b ') as nstmnth,
								DATE_format(evntm_strtdt, '%Y ') as nstyr 
									 from 
								evnt_mst	
								

								where evntm_sts='a' and evntm_typ='n' order by evntm_strtdt ASC  limit 3";
                $srsnews_mst  =  mysqli_query($conn, $sqrynws_mst) or die(mysqli_error($conn));
                $numrows1 =   mysqli_num_rows($srsnews_mst);
                $cnt = 0;
                if ($numrows1  > 0) { ?>


                  <div class="tab-pane fade" id="nav-curriculum" role="tabpanel" aria-labelledby="nav-curriculum-tab">
                    <div class="overview">
                      <div class="learn row mb-0">
                        <?php
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
                          <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-12">
                            <div class="single-podcasts-card" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200" data-aos-once="true">
                              <div class="row align-items-start gx-lg-3 gx-md-3 gx-0">

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
                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-4">
                                      <div class="podcasts-image">
                                        <img src="<?php echo $nwsimgpth; ?>" alt=" No Image">
                                      </div>
                                    </div>

                                <?php    }
                                }

                                ?>




                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-8">
                                  <div class="podcast-content">
                                    <span><?php echo $news_dt; ?>
                                      <?php
                                      if ($news_dt == 1 || $news_dt == 21) {

                                        $t = "st";
                                      } else if ($news_dt == 2 || $news_dt == 22) {

                                        $t = "nd";
                                      } else if ($news_dt == 3) {

                                        $t = "rd";
                                      } else {

                                        $t = "th";
                                      }
                                      ?>
                                      <sup><?php echo $t; ?></sup>
                                      <?php echo $news_mt . '' . $news_yr; ?>
                                      <img src="<?php echo $rtpth; ?>assets/images/icon/new.gif" alt=""></span>
                                    <h3><?php echo $news_nm; ?></h3>
                                    <!-- <p>Chaitanya Bharathi Institute of Technology, established in the Year 1979,
                                            esteemed as the premier engineering institute.</p> -->
                                    <a href="<?php echo $rtpth.'latest-news/'.$news_url.'_'.$news_id; ?>" class="read-more-btn float-end">Read more<i class="flaticon-next"></i></a>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php } ?>



                      </div>
                    </div>
                    <div class="single-podcasts-card mb-0">
                      <div class="row align-items-center justify-content-end">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
                          <div class="mb-lg-0 mb-md-0 mb-2 text-end">
                            <a href="<?php echo $rtpth ?>news" class="custom-btn-12 green">View All<i class="fa-solid fa-chevron-right"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="single-podcasts-card mb-0">
					<div class="row align-items-center justify-content-end">
						<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
							<div class="mb-lg-0 mb-md-0 mb-2 text-end">
								<a href="#" class="custom-btn-12 green">View All <i class="fa-solid fa-chevron-right"></i></a>
							</div>
						</div>
					</div>
				</div> -->
      </div>
      <!-- ######### NOTIFICATION START ######## -->
      <?php
      $sqrynws_mst = "SELECT  nwsm_id,nwsm_name,nwsm_desc,nwsm_sts,nwsm_typ, nwsm_dwnfl,nwsm_prty,nwsm_dt,nwsm_img from  nws_mst where  nwsm_sts ='a' and nwsm_typ = 2 order by nwsm_prty asc 	";
      $srsnws_mst = mysqli_query($conn, $sqrynws_mst) or die(mysqli_error($conn));
      $serchres  = mysqli_num_rows($srsnws_mst);
      if ($serchres > 0) { ?>
        <div class="col-lg-4">
          <div class="section-title text-start notific-cus">
            <h2 class="mt-lg-0 mt-md-0 mt-3">Notifications</h2>
          </div>
          <div class="categories">
            <marquee style="height:430px;" scrollamount="6" direction="up" scroll="continuous" onmouseover="this.stop();" onmouseout="this.start();">
              <!-- <h3 class="text-white">Notifications</h3> -->
              <div class="marquee-wrapper">
                <div class="marque-loop">
                  <ul>
                    <?php
                    while ($srownws_mstreslt = mysqli_fetch_assoc($srsnws_mst)) {
                      $resltnwsid   = $srownws_mstreslt['nwsm_id'];
                      $resltnewsdate = $srownws_mstreslt['nwsm_dt'];
                      $resltnewsname =  $srownws_mstreslt['nwsm_name'];
                      $anu_url=funcStrRplc($resltnewsname);
                      $resltnewsdsec =  $srownws_mstreslt['nwsm_desc'];
                      $resltnwstyp = $srownws_mstreslt['nwsm_typ'];
                    ?>
                      <li>
                       
                        <a href="<?php echo $rtpth.'latest-notifications/'.$resltnwstyp.'/'.$anu_url.'_'.$resltnwsid;?>" class="d-flex align-items-baseline">
                          <span> <i class="fa-regular fa-bell"></i></span>
                          <span><?php echo   $resltnewsname; ?> <img src="<?php echo $rtpth; ?>assets/images/icon/new.gif" alt=""></span>
                        </a>
                      </li>
                    <?php
                    }
                    ?>
                  </ul>
                </div>
              </div>
            </marquee>
          </div>
          <div class="single-podcasts-card mt-3 mb-0">
            <div class="row align-items-center justify-content-end">
              <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-6">
                <div class="mb-lg-0 mb-md-0 mb-2 text-end">
                  <!-- <a href="<?php echo $rtpth ?>announcements-list.php?notify_typ=2" class="custom-btn-12 green">View All <i class="fa-solid fa-chevron-right"></i></a> -->
                  <a href="<?php echo $rtpth ?>notifications/2" class="custom-btn-12 green">View All <i class="fa-solid fa-chevron-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<?php
      }
?>
<!-- ######### NOTIFICATION END ######## -->
<section id="numbers" class="cbit-by-numbers">
  <div class="container-fluid px-lg-3 px-md-3 px-2-fluid">
    <div class="section-title text-center">
      <h2 class="mt-lg-0 mt-md-0 mt-3 pipe-1">CBIT By Numbers</h2>
    </div>
    <div class="row">
      <div class="col-lg-3 col-12 position-relative px-0 hidden-xs cbit-numbers-side-logo">
        <img src="<?php echo $rtpth; ?>assets/images/cbit-numbers-logo.png" class="w-100 h-100">
      </div>
      <div class="numArea col-lg-9 col-12 px-0">
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="44">00</span><span class="target">+</span></h3>
          <p>Years of Academic Excellence</p>
        </div>
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="22">00</span><span class="target"></span></h3>
          <p>Programmes</p>
        </div>
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="333">00</span><span class="target">+</span></h3>
          <p>Highly Dedicated Faculty</p>
        </div>
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="143">00</span><span class="target">+</span></h3>
          <p>Faculty with Ph.D and 102 Pusuing Ph.D</p>
        </div>
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="68">00</span><span class="target">+</span></h3>
          <p>Research Projects from AICTE, DST, DRDO, MSME and State Government</p>
        </div>
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="140">00</span><span class="target">+</span></h3>
          <p>Recruiters</p>
        </div>
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="56">00</span><span class="target">+</span></h3>
          <p>MoUs with Industry</p>
        </div>
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="5115">00</span><span class="target"></span></h3>
          <p>Students</p>
        </div>
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="7500">00</span><span class="target">+</span></h3>
          <p>Publications</p>
        </div>
        <div class="numBox text-center">
          <h3><span class="odometer" data-count="25000">00</span><span class="target">+</span></h3>
          <p>Alumni Across the Globe</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Achievements dynamic start -->
<?php
$sqryqry_achmntm = "SELECT achmntm_id, achmntm_name, achmntm_desc,achmntm_sdesc, achmntm_imgnm,achmntm_lnk, achmntm_prty, achmntm_sts FROM  achmnt_mst WHERE achmntm_sts = 'a' order by achmntm_prty asc ";
$sqry_ach_mst = mysqli_query($conn, $sqryqry_achmntm);
$ach_cnt = mysqli_num_rows($sqry_ach_mst);
if ($ach_cnt > 0) {
?>
  <div class="health-care-area section-pad-y achievements-section" style="background-color: rgba(162, 110, 41, 0);">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
      <div class="section-title">
        <h2 class="">Achievements</h2>
      </div>
      <div class="health-care-slider owl-carousel owl-theme">
        <?php
        while ($srowach_mst = mysqli_fetch_assoc($sqry_ach_mst)) {
          $achid = $srowach_mst['achmntm_id'];
          $achttl = $srowach_mst['achmntm_name'];
          $ach_url=funStrUrlEncode($achttl);
          $achlnk = $srowach_mst['achmntm_lnk'];
          $achimgnm = $srowach_mst['achmntm_imgnm'];
          $achsdesc = $srowach_mst['achmntm_sdesc'];
          $achdesc = $srowach_mst['achmntm_desc'];
          $achimg = $gusrach_fldnm . $achimgnm;
          if (($achimgnm != "") && file_exists($achimg)) {
            $achmntimgpth = $rtpth . $achimg;
          } else {
            $achmntimgpth   = 'n.a';
          }
        ?>
          <div class="single-health-care-card style-3">
            <div class="achievements-img">
              <img src="<?php echo   $achmntimgpth; ?>" alt="">
            </div>
            <div class="health-care-content">
           
              <a href="<?php echo $rtpth.'latest-achivements/'.$ach_url.'_'.$achid; ?>" class="mt-4">
                <h3><?php echo $achttl; ?></h3>
              </a>
              <a href="<?php echo $rtpth.'latest-achivements/'.$ach_url.'_'.$achid; ?>" class="read-more-btn"><?php echo $achsdesc; ?></a>
              <p><?php echo $achdesc; ?></p>
              <a href="<?php echo $rtpth.'latest-achivements/'.$ach_url.'_'.$achid; ?>" class="read-more-btn float-end">Read more<i class="flaticon-next"></i></a>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
      <div class="row align-items-center justify-content-end">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-6">
          <div class="mb-lg-0 mb-md-0 mb-2 text-end">
            <a href="<?php echo $rtpth; ?>achivements" class="custom-btn-12 green">Viewl All <i class="fa-solid fa-chevron-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>
<!-- Achivements dynamic close -->
<!-- placenents dynamic menu Start -->
<!-- <?php
      $sqryplcmt_mst = "SELECT plcmtm_id,plcmtm_name,plcmtm_img,plcmtm_sts, plcmtm_prty,plcmtm_compny,plcmtm_ofer,plcmtm_pkg, plcmtm_percnt from plcmt_mst where plcmtm_sts='a'  order by plcmtm_prty  asc limit 1 ";
      $srsplcmt_mst = mysqli_query($conn, $sqryplcmt_mst) or die(mysqli_error($conn));
      $serchresplcmt  = mysqli_num_rows($srsplcmt_mst);
      if ($serchresplcmt > 0) {
      ?>
<div class="campus-information-area placements-section section-pad-y">
	<div class="container-fluid px-lg-3 px-md-3 px-2">
		<div class="row align-items-center justify-content-center">
			<div class="col-12">
				<div class="campus-content mb-0">
				<?php
        while ($srowplcmt_mst = mysqli_fetch_assoc($srsplcmt_mst)) {
          $plcmt_id =  $srowplcmt_mst['plcmtm_id'];
          $plcmt_name =  $srowplcmt_mst['plcmtm_name'];
          $plcmt_compny =  $srowplcmt_mst['plcmtm_compny'];
          $plcmt_ofer =  $srowplcmt_mst['plcmtm_ofer'];
          $plcmt_pkg =  $srowplcmt_mst['plcmtm_pkg'];
          $plcmt_perc =  $srowplcmt_mst['plcmtm_percnt'];


        ?>
					<div class="section-title">
						<h2 class="text-white"><?php echo $plcmt_name; ?> Placement Highlights</h2>
					</div>

					<div class="counter">
						<div class="row">
							<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
								<div class="counter-card text-white">
									<img src="assets/images/icons/companies.png" class="place-icon" alt="">
									<h1>
										<span class="odometer" data-count="<?php echo $plcmt_compny; ?>">00</span><span class="target">+</span>
									</h1>
									<p class="text-white text-center">Companies</p>
								</div>
							</div>
							<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
								<div class="counter-card text-white">
									<img src="assets/images/icons/placements-offer.png" class="place-icon" alt="">
									<h1>
										<span class="odometer" data-count="<?php echo $plcmt_ofer; ?>">00</span>
									</h1>
									<p class="text-white text-center">Placement Offers</p>
								</div>
							</div>
							<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
								<div class="counter-card text-white">
									<img src="assets/images/icons/highest-package.png" class="place-icon" alt="">
									<h1>
										<span class="odometer" data-count="<?php echo $plcmt_pkg; ?>">00</span><span class="target">L</span>
									</h1>
									<p class="text-white text-center">Highest package</p>
								</div>
							</div>
							<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
								<div class="counter-card text-white">
									<img src="assets/images/icons/of-placements.png" class="place-icon" alt="">
									<h1>
										<span class="odometer" data-count="<?php echo $plcmt_perc; ?>">00</span><span class="target">%</span>
									</h1>
									<p class="text-white text-center">Of Placements</p>
								</div>
							</div>



						</div>
					</div>
					<?php
        }
          ?>
						 -->

<!-- #####################  brand logos for company like TCS,Wipro  start  ################################ -->
<!-- <?php
        $sqrybrnd_mst1 = "SELECT brndm_id,brndm_name,brndm_img,brndm_sts, brndm_prty from brnd_mst where brndm_sts='a' and brndm_img!='' order by brndm_prty  asc";
        $srsbrnd_mst = mysqli_query($conn, $sqrybrnd_mst1) or die(mysqli_error($conn));
        $serchresbrnd  = mysqli_num_rows($srsbrnd_mst);
        if ($serchresbrnd > 0) {
      ?>
						<div class="hire-company mt-xxl-5 mt-lx-4 mt-lg-3 mt-md-2 mt-2">
							<div class="events-area">
								<div class="container-fluid px-lg-3 px-md-3 px-2">
									<div class="hireCompany-slider mb-20 owl-carousel owl-theme">
										<?php
                    while ($srowbrnd_mst = mysqli_fetch_assoc($srsbrnd_mst)) {
                      $brnd_id =  $srowbrnd_mst['brndm_id'];
                      $brnd_name =  $srowbrnd_mst['brndm_name'];
                      $imgnm =  $srowbrnd_mst['brndm_img'];
                      $imgpath = $gusrbrnd_upldpth . $imgnm;
                      if (($imgnm != "") && file_exists($imgpath)) {
                        $brndimgpth = $rtpth . $imgpath;
                      } else {

                        $brndimgpth   = $rtpth . $u_cat_bnrfldnm . 'default.jpg';
                      }

                    ?>
											<div class="single-events-card style2">
												<div class="events-image"><img src="<?php echo $brndimgpth; ?>" class="w-100" alt="Image"></div>
											</div>
										<?php
                    }
                    ?>
									</div>
								</div>
							</div>
						</div>
					<?php
        }
          ?> -->
<!-- #####################  brand logos for company like TCS,Wipro Close ################################ -->

<!-- </div>
			</div>


		</div>
	</div>
</div>
<?php } ?> -->

<!-- placenents dynamic menu close -->

<!-- placenents static menu start -->
<div class="campus-information-area placements-section section-pad-y">
  <div class="container-fluid px-lg-3 px-md-3 px-2">
    <div class="row align-items-center justify-content-center">
      <div class="col-12">
        <div class="campus-content mb-0">
          <div class="section-title">
            <h2 class="text-white">2022-23 Placement Highlights</h2>
          </div>
          <div class="counter">
            <div class="row">
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
                <div class="counter-card text-white">
                  <img src="<?php echo $rtpth; ?>assets/images/icons/companies.png" class="place-icon" alt="">
                  <h1>
                    <span class="odometer" data-count="140">00</span><span class="target">+</span>
                  </h1>
                  <p class="text-white text-center">Companies</p>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
                <div class="counter-card text-white">
                  <img src="<?php echo $rtpth; ?>assets/images/icons/placements-offer.png" class="place-icon" alt="">
                  <h1>
                    <span class="odometer" data-count="1736">00</span>
                  </h1>
                  <p class="text-white text-center">Placement Offers</p>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
                <div class="counter-card text-white">
                  <img src="<?php echo $rtpth; ?>assets/images/icons/highest-package.png" class="place-icon" alt="">
                  <h1>
                    <span class="odometer" data-count="54">00</span><span class="target">L</span>
                  </h1>
                  <p class="text-white text-center">Highest package</p>
                </div>
              </div>
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-6">
                <div class="counter-card text-white">
                  <img src="<?php echo $rtpth; ?>assets/images/icons/of-placements.png" class="place-icon" alt="">
                  <h1>
                    <span class="odometer" data-count="83.68">00</span><span class="target">%</span>
                  </h1>
                  <p class="text-white text-center">Of Placements</p>
                </div>
              </div>
            </div>
          </div>
          <div class="hire-company mt-xxl-5 mt-lx-4 mt-lg-3 mt-md-2 mt-2">
            <div class="events-area">
              <div class="container-fluid px-lg-3 px-md-3 px-2">
                <div class="hireCompany-slider mb-20 owl-carousel owl-theme">
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/amazon.jpg" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/ascenture.jpg" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/byjus.jpg" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/capgemini.jpg" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/deloitte.jpg" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/hcl.png" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/infosys.png" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/medplus.png" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/mindtree.jpg" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/tcs1.png" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/tech-mahindra.png" class="w-100" alt="Image"></div>
                  </div>
                  <div class="single-events-card style2">
                    <div class="events-image"><img src="<?php echo $rtpth; ?>assets/images/company-logos/wipro.jpg" class="w-100" alt="Image"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- placenents startic menu close -->


<!-- ###############  Facilities start ################# -->
<?php
$sqry_facility = "SELECT prodmnlnksm_id,prodmnlnksm_name,prodmnlnksm_desc,prodmnlnksm_bnrimg,prodmnlnksm_typ,prodmnlnksm_dsplytyp,prodmnlnksm_prty,prodmnlnksm_sts,prodcatm_id,prodcatm_prodmnlnksm_id,prodcatm_name,prodcatm_desc,prodcatm_bnrimg,prodcatm_icn,prodcatm_dsplytyp,prodcatm_typ,prodcatm_sts,prodcatm_prty  from  prodmnlnks_mst
  left join  prodcat_mst on prodcatm_prodmnlnksm_id = prodmnlnksm_id
	where prodmnlnksm_id !='' and prodmnlnksm_sts ='a' and prodmnlnksm_sts = 'a' and prodcatm_sts='a' and prodmnlnksm_name='Facilities' group by prodcatm_id  order by prodcatm_prty asc";
//  prodscatm_id,prodscatm_name,prodscatm_desc,prodscatm_bnrimg,prodscatm_dpttitle,prodscatm_dpthead,prodscatm_dptname,prodscatm_sts,prodscatm_prodcatm_id,prodscatm_prodmnlnksm_id,prodscatm_prty 
//  left join prodscat_mst on prodscatm_prodcatm_id = prodcatm_id
$sqry_fcty_mst = mysqli_query($conn, $sqry_facility);
$fcty_cnt = mysqli_num_rows($sqry_fcty_mst);
if ($fcty_cnt > 0) {
?>
  <div class="health-care-area section-pad-y facilities-holder">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
      <div class="facilities-wrapper">
        <div class="section-title">
          <h2>Facilities</h2>
        </div>
        <div class="facilities-slider mb-20 owl-carousel owl-theme">
          <?php
          while ($srowfcty_mst = mysqli_fetch_assoc($sqry_fcty_mst)) {
            $fctytid = $srowfcty_mst['prodmnlnksm_id'];
            $fctyt_nm = $srowfcty_mst['prodmnlnksm_name'];
            $fct_mn_url=funcStrRplc($fctyt_nm);
            $fctyimgnm = $srowfcty_mst['prodcatm_icn'];
            $fctynm = $srowfcty_mst['prodcatm_name'];
            $fct_cat_url=funcStrRplc($fctynm);
            $d_catid = $srowfcty_mst['prodcatm_id'];

            $fctyimg =  $u_cat_icnfldnm . $fctyimgnm;
            if (($fctyimgnm != "") && file_exists($fctyimg)) {
              $fctyimgpth = $rtpth . $fctyimg;
            } else {
              $fctyimgpth   = $rtpth . $u_cat_bnrfldnm . 'default.jpg';
            }
          ?>
            <div class="item">
              <div class="single-health-care-card style1">
                <div class="img">

                  <a href=" <?php echo $rtpth . $fct_mn_url . '/' . $fct_cat_url;?>"><img src="<?php echo $fctyimgpth; ?>" alt="Image"></a>
                </div>
                <div class="health-care-content">
                  <a href=" <?php echo $rtpth . $fct_mn_url . '/' . $fct_cat_url;?>">
                    <h3><?php echo $fctynm; ?></h3>
                  </a>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
        <div class="single-podcasts-card mt-3 mb-0">
          <div class="row align-items-center justify-content-end">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-6">
              <div class="mb-lg-0 mb-md-0 mb-2 text-end">
                <a href=" <?php echo $rtpth . $fct_mn_url . '/' . $fct_cat_url;?>" class="custom-btn-12 green">View All <i class="fa-solid fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
}

$sqryalumni = "SELECT alumnim_id,alumnim_name,alumnim_desc,alumnim_imgnm,alumnim_lnk,alumnim_batch,alumnim_job,alumnim_prty,alumnim_sts from  alumni_mst where alumnim_sts='a' and alumnim_id!='' order by alumnim_prty asc ";
$sqry_alumni_mst = mysqli_query($conn, $sqryalumni);
$alumni_cnt = mysqli_num_rows($sqry_alumni_mst);
if ($alumni_cnt > 0) {
?>
  <div class="courses-area section-pad-y  alumni-holder">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
      <div class="section-title">
        <h2>Distinguished Alumni</h2>
      </div>
      <div class="courses-slider mb-20 owl-carousel owl-theme">
        <?php
        $alm_arr = array();
        while ($srowalumni_mst = mysqli_fetch_assoc($sqry_alumni_mst)) {
          $alumniid = $srowalumni_mst['alumnim_id'];
          $alm_arr[] = $alumniid;
          $alumnittl = $srowalumni_mst['alumnim_name'];
          $alumnibatch = $srowalumni_mst['alumnim_batch'];
          $alumnidesc = $srowalumni_mst['alumnim_desc'];
          $alumnijob = $srowalumni_mst['alumnim_job'];
          $alumnilnk = $sroalumnip_mst['alumnim_lnk'];
          $alumniimgnm = $srowalumni_mst['alumnim_imgnm'];
          if ($alumniimgnm != '') {
            $alumniimgpth = $rtpth . $gusralumni_fldnm . $alumniimgnm;
          } else {
            $alumniimgpth = $rtpth . $gusralumni_fldnm . $alumniimgnm; //no image
          }

        ?>
          <div class="single-courses-card style2">
            <div class="courses-img">
              <a href="#"><img src="<?php echo  $alumniimgpth ?>" alt="Image"></a>
            </div>
            <div class="courses-content">
              <a href="#">
                <h3><i class="fa-regular fa-user"></i><?php echo $alumnittl; ?></h3>
                <p><?php echo $alumnibatch; ?></p>
                <h2><?php echo $alumnijob; ?></h2>
              </a>
              <a href="#" data-bs-toggle="modal" data-bs-target="#alumni-<?php echo $alumniid; ?>PopupModal" class="read-more-btn pull-right">Read more<i class="flaticon-next"></i></a>
            </div>
            <!-- <div class="modal fade" id="alumni-<?php echo $alumniid; ?>PopupModal" tabindex="-1" aria-labelledby="alumni-<?php echo $alumniid; ?>PopupModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="alumni-<?php echo $alumniid; ?>PopupModalLabel"><?php echo $alumnittl; ?> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      &#x2715;
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="alumni-content">
                      <p><?php echo $alumnidesc; ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
        <?php }
        ?>
      </div>
      <div class="single-podcasts-card mt-lg-3 mt-md-3 mt-5 mb-0">
        <div class="row align-items-center justify-content-end">
          <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-6">
            <div class="mb-lg-0 mb-md-0 mb-2 text-end">
              <a href="https://alumni.cbit.ac.in/" target="_blank" class="custom-btn-12 green">Alumni Portal <i class="fa-solid fa-chevron-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
<div class="section-pad-y pb-0 pt-0">
  <div class="">
    <!-- <div class="section-title">
            <h2>Gallery</h2>
        </div> -->
    <?php
    $sqryphtcat_mst = "SELECT phtd_id,phtcatm_name, phtd_phtcatm_id,phtcatm_img, phtd_name, phtd_desc,phtd_rank, phtd_sts, phtd_crtdon, phtd_crtdby, phtd_mdfdon, phtd_mdfdby, phtm_id, phtm_phtd_id, phtm_phtcatm_id, phtm_simgnm, phtm_simg, phtm_prty, phtm_sts, phtm_crtdon, phtm_crtdby, phtm_mdfdon, phtm_mdfdby,phtcatm_name,phtcatm_id,phtcatm_desc from vw_phtd_phtm_mst left join phtcat_mst on  phtcat_mst.phtcatm_id = vw_phtd_phtm_mst.phtm_phtcatm_id where phtm_sts = 'a' and phtcatm_sts = 'a' and phtd_sts = 'a' and phtcatm_typ = 'c' group by phtcatm_id order by  phtcatm_prty asc";
    $srsphtcat_dtl = mysqli_query($conn, $sqryphtcat_mst);
    $cntrec_phtcat = mysqli_num_rows($srsphtcat_dtl);
    if ($cntrec_phtcat > 0) { ?>
      <div class="homeGallery">
        <?php
        $spl_cnt = ceil($cntrec_phtcat / 2);
        $j = 0;
        while ($j < 2) { ?>
          <div class="homeGallery-slider-1 owl-carousel owl-theme">
            <?php
            $i = 1;
            while ($srowsphtcat_dtl = mysqli_fetch_assoc($srsphtcat_dtl)) {
              $phtcatid         = $srowsphtcat_dtl['phtcatm_id'];
              $phtcat_name      = $srowsphtcat_dtl['phtcatm_name'];
              $pht_url=funcStrRplc($phtcat_name);
              $phtcat_bnrimg      = $srowsphtcat_dtl['phtcatm_img'];
              // $phtcatm_desc  = $srowsphtcat_dtl['phtcatm_desc'];
              // $bphtimgnm     = $srowsphtcat_dtl['phtm_simg'];
              $galpath      = $gusrglry_fldnm . $phtcat_bnrimg;
              // echo file_exists($galpath);

              if (($phtcat_bnrimg != "") && file_exists($galpath)) {
                $galryimgpth = $rtpth . $galpath;
              } else {
                $galryimgpth   = $rtpth . $gusrglry_fldnm . 'default.jpg';
              }
              // if ($i <= $spl_cnt) {
              // 	$cls_ext = "1";
              // } else {
              // 	$cls_ext = "2";
              // }
              // $cls_ext = "1";
            ?>
              <div class="item">
                <div class="gal-img-holder">
                  
                  <a href="  <?php echo $rtpth.'photo-gallery/'.$pht_url.'_'.$phtcatid;?>">
                  
                    <img src="<?php echo $galryimgpth; ?>" classw="w-100" alt="" title="<?php echo $phtcat_name; ?>">
                    <p class="gal-cat-home"><?php echo $phtcat_name; ?></p>
                  </a>
                </div>
              </div>
            <?php
              if ($i == $spl_cnt) {
                break;
              }
              $i++;
            }
            ?>
          </div>
        <?php

          $j++;
        }
        ?>
        <div class="gal-center-overlay">
          <div class="cont-holder">
            <h2 class="text-white text-center">Gallery</h2>
            <p class="txt2">Follow Us On</p>
            <div class="copyright p-0">
              <div class="social-content d-flex justify-content-center m-0">
                <ul>
                  <li>
                    <a class="text-white" href="https://www.facebook.com/CBIThyderabad/" target="_blank"><i class="ri-facebook-fill"></i></a>
                  </li>
                  <li>
                    <a class="text-white" href="https://www.instagram.com/cbithyderabad/" target="_blank"><i class="ri-instagram-line"></i></a>
                  </li>
                  <li>
                    <a class="text-white" href="https://twitter.com/CBIThyd" target="_blank"><i class="ri-twitter-fill"></i></a>
                  </li>
                  <li>
                    <a class="text-white" href="https://www.youtube.com/channel/UCUW8oQB8Fl6j-pg2g_sf1tw" target="_blank"><i class="ri-youtube-fill"></i></a>
                  </li>
                </ul>
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


<div class="admisssion-area section-pad-y section-line-1 pt-0 pb-0">
  <div class="">
    <div class="admission-bg section-pad-y px-4">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-6">
          <div class="admission-left-content">
            <h2>Let’s build the future with innovation</h2>
            <p>Chaitanya Bharathi Institute of Technology, established in the Year 1979, esteemed as the
              premier
              engineering institute in the states of Telangana and Andhra Pradesh.
            </p>
            <a href="#" class="custom-btn-12 transt">Virtual Tour 360 degrees <i class="flaticon-next"></i></a>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="admission-right-content">
            <ul>
              <li>
                <div class="icon">
                  <a class="popup-youtube play-btn" href="https://www.youtube.com/watch?v=RptoHi3UxGA"><i class="ri-play-fill"></i></a>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('footer.php'); ?>
<!-- popup -->
<?php
$sqrypopup = "SELECT popupm_id,popupm_name,popupm_desc,popupm_imgnm,popupm_lnk,popupm_prty,popupm_sts from  popup_mst where popupm_sts='a' and popupm_id!='' order by popupm_prty asc ";
$sqry_popup_mst = mysqli_query($conn, $sqrypopup);
$popup_cnt = mysqli_num_rows($sqry_popup_mst);
if ($popup_cnt > 0) {
?>
  <div class="modal fade autoModal-home" id="autoPopupModal" tabindex="-1" aria-labelledby="autoPopupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header text-center">
          <?php
          $srowpopup_mstnm = mysqli_fetch_assoc($sqry_popup_mst);
          $popupnm = $srowpopup_mstnm['popupm_name'];
          ?>
          <h5 class="modal-title w-100" id="autoPopupModalLabel"><?php echo $popupnm;?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            &#x2715;
          </button>
        </div>
       <div class="modal-body">
          <div class="autoPopup-slider owl-carousel owl-theme">
            <!-- loop -->
            <?php
            $sqry_popup_mst = mysqli_query($conn, $sqrypopup);
            while ($srowpopup_mst = mysqli_fetch_assoc($sqry_popup_mst)) {
              $popupid = $srowpopup_mst['popupm_id'];
              $popupttl = $srowpopup_mst['popupm_name'];
              $popuplnk = $srowpopup_mst['popupm_lnk'];
              $popupimgnm = $srowpopup_mst['popupm_imgnm'];


              $popupimgpth = $rtpth . $gusrbnr_fldnm . $popupimgnm;
            ?>
              <div class="item">
                <a href="<?php echo $popuplnk; ?>" target="_blank">
                  <img src="<?php echo $popupimgpth; ?>" class="w-100 " alt="">
                </a>

              </div>
            <?php
            }
            ?>

          </div>
        </div>

      </div>
    </div>
  </div>
<?php
}
?>