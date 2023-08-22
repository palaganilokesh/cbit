<?php
error_reporting(0);
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php';//Use function for validation and more
include_once 'includes/inc_config.php';//Making paging validation	
include_once 'includes/inc_folder_path.php';//Making paging validation	
include_once 'includes/inc_paging_functions.php';//Making paging validation
//$rowsprpg  = $_SESSION['sespgval'];//maximum rows per page	
include_once 'includes/inc_paging1.php';//Includes pagination  

$page_title = "Events | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Events | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
include('header.php');
?>

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
            <h1>News</h1>
            <ul>
                <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
                <li>News</li>
            </ul>
        </div>
    </div>
</section>




<div class="latest-news-area section-pad-y">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
<div class="row">
<div class="col-lg-8">
<div class="latest-news-left-content pr-20">
<!-- <div class="latest-news-simple-card">
<div class="news-content">
<div class="list">
<ul>
<li><i class="flaticon-user"></i>By <a href="news-details.php">ECE</a></li>
<li><i class="flaticon-tag"></i>Electronics</li>
</ul>
</div>
<a href="news-details.php"><h3>Professor Tom Comments On The Volunteer B. Snack Brand</h3></a>
<a href="news-details.php" class="read-more-btn active">Read More<i class="flaticon-next"></i></a>
</div>
</div> -->
<?php
                $sqrynws_mst = "SELECT evntm_name,evntm_desc,evntm_city, evntm_id,evntm_lnk,evtnm_strttm,evntm_endtm,
									DATE_format(evntm_strtdt, '%D %M %Y') as newstdate,
									DATE_format(evntm_strtdt, '%d') as nstdt,
							DATE_format(evntm_strtdt, '%b ') as nstmnth,
								DATE_format(evntm_strtdt, '%Y ') as nstyr 
									 from 
								evnt_mst	where evntm_sts='a' and evntm_typ='n' order by evntm_strtdt ASC ";
                $srsnews_mst  =  mysqli_query($conn, $sqrynws_mst) or die(mysqli_error($conn));
                $numrows1 =   mysqli_num_rows($srsnews_mst);
                $cnt = 0;
                if ($numrows1  > 0) { ?>

<div class="latest-news-card-area">
<h3>Latest News</h3>
<div class="row">
<?php
                        while ($srownews_mst   = mysqli_fetch_assoc($srsnews_mst)) {
                          $evntcnt += 1;
                          $news_nm = $srownews_mst['evntm_name'];
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
<a href="<?php echo $rtpth?>news-details.php?nwsid=<?php echo $news_id;?>"><img src="<?php echo $nwsimgpth;?>" alt="Image"></a>
</div>
<div class="news-content">
<!-- <div class="list">
<ul>
<li><i class="flaticon-user"></i>By <a href="news-details.php">ECE</a></li>
<li><i class="flaticon-tag"></i>Electronics</li>
</ul>
</div> -->
<a href="<?php echo $rtpth?>news-details.php?nwsid=<?php echo $news_id;?>"><h3><?php echo $news_nm;?></h3></a>
<a href="<?php echo $rtpth?>news-details.php?nwsid=<?php echo $news_id;?>" class="read-more-btn">Read More<i class="flaticon-next"></i></a>
</div>
</div>
</div>
<?php
					}
				}
	} 

?>

</div>
</div>
<?php } ?>
</div>
</div>

<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-12 order-md-2 order-1 ">


                <div class="about-us-sideLinks">
                    <!-- <h4 class="common-sm-heading mb-3">Departments</h4> -->
                    <div class="faq-left-content ">
                        <div class="accordion" id="academicsLinks">

                

                            <!-- <div class="accordion-item item-custom-1">
                                <h2 class="accordion-header" id="heading-2">
                                    <button class="accordion-button open-df collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#pg" aria-expanded="false" aria-controls="pg">
                                        About Us
                                    </button>
                                </h2>
                                <div id="pg" class="accordion-collapse open-df collapse" aria-labelledby="heading-2"
                                    data-bs-parent="#academicsLinks">
                                    <div class="accordion-body p-0 ug-links">
                                        <ul class="links-lists p-0 m-0">
                                            <li>
                                                <p><a class="active" href="#"><i class="fa-solid fa-chevron-right"></i> CBIT At a Glance</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> First Management Committee</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Board of Management</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> President’s Message</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Principal’s Message</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Institute Information</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Organizational Structure</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Our Team</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Governing Body</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Advisory Body</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Academic Council</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Established Procedures</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Financial Report</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> IQAC</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> Institutional committees</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> CBIT MoU’s</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> CBIT in Pictures</a></p>
                                            </li>
                                            <li>
                                                <p><a href="#"><i class="fa-solid fa-chevron-right"></i> CBIT in Videos</a></p>
                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div> -->


                        </div>
                    </div>
                </div>


            </div>
</div>
  





    </div>
</div>


<?php include_once('footer.php'); ?>