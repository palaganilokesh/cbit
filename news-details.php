<?php
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php';//Use function for validation and more
include_once 'includes/inc_config.php';//Making paging validation	
include_once 'includes/inc_folder_path.php';//Making paging validation	

if(isset($_REQUEST['nwsid']) && trim($_REQUEST['nwsid'])!= ""){
	$nwsid			= funcStrUnRplc(glb_func_chkvl($_REQUEST['nwsid']));
	 $sqrynws_mst = "SELECT evntm_name,evntm_desc,evntm_city, evntm_id,evntm_lnk,evtnm_strttm,evntm_endtm,
     DATE_format(evntm_strtdt, '%D %M %Y') as newstdate,
     DATE_format(evntm_strtdt, '%d') as nstdt,
DATE_format(evntm_strtdt, '%b ') as nstmnth,
 DATE_format(evntm_strtdt, '%Y ') as nstyr 
      from 
 evnt_mst	where evntm_sts='a' and evntm_typ='n' and evntm_id = '$nwsid' group by evntm_id order by evntm_strtdt ASC";
 
//  echo $sqrynws_mst;
	$srsnws_mst  	 =  mysqli_query($conn,$sqrynws_mst) or die(mysqli_error($conn));
	$cntnws_mst  = mysqli_num_rows($srsnws_mst);
	if($cntnws_mst > 0){
		$srownews_mst = mysqli_fetch_assoc($srsnws_mst);
		$news_nm = $srownews_mst['evntm_name'];
		$news_dt = $srownews_mst['nstdt'];
		$news_mt = $srownews_mst['nstmnth'];
		$news_yr = $srownews_mst['nstyr'];
		$news_id = $srownews_mst['evntm_id'];

		$news_stdt = $srownews_mst['newstdate'];
		$news_lnk = $srownews_mst['evntm_lnk'];
		$news_strt = $srownews_mst['stdate'];
		$news_desc = $srownews_mst['evntm_desc'];
}

}else{
	header("Location:".$rtpth."News");
	exit();
}	
$page_title = $news_nm;
	$current_page = "News";
// $page_title = "Events | Chaitanya Bharathi Institute of Technology";
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
				<h1><?php echo $page_title;?></h1>
            <ul>
                <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
								      <li><a href="<?php echo $rtpth;?>news-list.php">News</a></li>
                    <li><?php echo $page_title;?></li>
            </ul>
        </div>
    </div>
</section>




<div class="news-details-area section-pad-y">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
<div class="row">
  <div class="col-lg-8">
    <div class="news-details">
      <div class="news-simple-card">
				<?php
			$news_srs_qry = "SELECT evntimgd_sts,evntimgd_img,evntimgd_name,evntimgd_evntm_id,evntimgd_id from evntimg_dtl where evntimgd_evntm_id=$news_id and evntimgd_sts='a' group by evntimgd_evntm_id limit 1";
                                $news_mst  =  mysqli_query($conn, $news_srs_qry) or die(mysqli_error($conn));
                                $nurs =   mysqli_num_rows($news_mst);
                                if ($nurs > 0) {
                                 $srownewsimg_mst   = mysqli_fetch_assoc($news_mst);
                                    $nwsimgnm = $srownewsimg_mst['evntimgd_img'];
                                    $nsimg = $u_imgevnt_fldnm . $nwsimgnm;
                                    //	$imgpath = $gusrbrnd_upldpth . $imgnm;
                                    if (($nwsimgnm != "") && file_exists($nsimg)) {
                                      $nwsimgpth = $rtpth . $nsimg;
                                    } else {
                                      $nwsimgpth   =  $rtpth . $u_cat_bnrfldnm . 'default.jpg';
                                    }
																	 } ?>
        <img src="<?php echo $nwsimgpth;?>" alt="Image">
        <p><?php echo $news_stdt;?></p>
        <h2><?php echo $news_nm;?></h2>
        <p><?php echo $news_desc;?></p>
        </div>
      </div>
    </div>
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-12 order-md-1 order-2">
              
			  <div class="campus-content pr-20 ">
							  <?php 
if(isset($_REQUEST['nwsid']) && trim($_REQUEST['nwsid'])!="" )
{
  
$sqryphtcat_mst1="SELECT evntimgd_name,evntimgd_id,evntimgd_img,evntimgd_sts				  		    
from  evntimg_dtl
where evntimgd_evntm_id = '$news_id' and evntimgd_sts='a' order by evntimgd_prty asc";
	// echo 	$sqryphtcat_mst1;		  
		  $srsphtcat_dtl1 = mysqli_query($conn,$sqryphtcat_mst1);
		  $cntrec_phtcat1 = mysqli_num_rows($srsphtcat_dtl1);
		  if($cntrec_phtcat1 > 0){
			  
?>
			  <div class="cont ">
		  <div class="demo-gallery ">
			  <ul id="lightgallery" class="list-unstyled row gx-xxl-1 gx-xl-1 gx-lg-1 gx-md-2 gx-0 ">
							  <?php
								  while($srowsphtcat_dtl1 = mysqli_fetch_assoc($srsphtcat_dtl1)){
									  $phtid         = $srowsphtcat_dtl1['evntimgd_id'];
								  //$phtid         = $srowsphtcat_dtl1['phtd_desc'];
									  $pht_name      = $srowsphtcat_dtl1['evntimgd_name'];
									  $bphtimgnm     = $srowsphtcat_dtl1['evntimgd_img'];
									//   $bgimgpth 		= $u_imgevnt_fldnm.$bimg;			
										 $bimgpath      = $u_imgevnt_fldnm.$bphtimgnm;
									  if (($bphtimgnm != "") && file_exists($bimgpath)) {
										  $galryimages = $rtpth . $bimgpath;
									  } else {
										  $galryimages   = $rtpth . $u_cat_bnrfldnm . 'default.jpg';
										  
									  }	
									  ?>
				  <li class="col-xxl-4 col-lg-4 col-md-4 col-6 mb-2"
					  data-responsive="<?php echo $galryimages; ?> 375, <?php echo $galryimages; ?> 480, <?php echo $galryimages; ?> 800"
					  data-src="<?php echo $galryimages; ?> " data-sub-html="<h4>Category 6</h4>">
					  <a href="">
						  <img class="img-responsive w-100" src="<?php echo $galryimages; ?>">
						  <div class="demo-gallery-poster">
							  <img src="https://sachinchoolur.github.io/lightgallery.js/static/img/zoom.png">
						  </div>
					  </a>
				  </li>
				  <?php } ?>  
			  </ul>
		  </div>
	  </div>
			  <?php 
			  } 
			  }
			  ?>  

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