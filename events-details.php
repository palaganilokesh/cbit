<?php
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php';//Use function for validation and more
include_once 'includes/inc_config.php';//Making paging validation	
include_once 'includes/inc_folder_path.php';//Making paging validation	

if(isset($_REQUEST['evntmid']) && trim($_REQUEST['evntmid'])!= ""){
	$evntId			= funcStrUnRplc(glb_func_chkvl($_REQUEST['evntmid']));
	 $sqryevnt_mst = "select 
					evntm_id,evntm_name,evntm_desc,evntm_city,
					evntm_strtdt,evntm_enddt,evntm_venue,evtnm_strttm,
					evntm_endtm,DATE_format(evntm_strtdt, '%D %M %Y') as stdate,
					DATE_format(evntm_enddt, '%D %M %Y') as eddate,
					evntm_fle 
				from 
					evnt_mst
				where 
					evntm_sts='a' and
					evntm_id = '$evntId'" ;
	$sqryevnt_mst	.=	" group by evntm_id";				
	$srsevnt_mst  	 =  mysqli_query($conn,$sqryevnt_mst) or die(mysqli_error($conn));
	$cntrec_mst  = mysqli_num_rows($srsevnt_mst);
	if($cntrec_mst > 0){
		$srowevnt_mst = mysqli_fetch_assoc($srsevnt_mst);
		$db_evntm_nm = $srowevnt_mst['evntm_name'];
		$db_evntm_id = $srowevnt_mst['evntm_id'];
		$db_evntm_vne = $srowevnt_mst['evntm_venue'];
		$db_evntm_strt = $srowevnt_mst['stdate'];
		$db_evntm_end = $srowevnt_mst['eddate'];
		$db_evntm_strtm = $srowevnt_mst['evtnm_strttm'];
		$db_evntm_endtm = $srowevnt_mst['evntm_endtm'];
		$db_evntm_desc = $srowevnt_mst['evntm_desc'];
	}

}else{
	header("Location:".$rtpth."events");
	exit();
}

$page_title = $db_evntm_nm;
	$current_page = "events";

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
								      <li><a href="<?php echo $rtpth;?>events-list.php">Events</a></li>
                    <li><?php echo $page_title;?></li>
            </ul>
        </div>
    </div>
</section>




<div class="campus-information-area section-pad-y">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
<div class="row">
<div class="col-lg-8">
<div class="health-details">
<div class="top-content">
	<?php
$sqryevntimg_dtl = "SELECT
								evntimgd_name,evntimgd_id,evntimgd_img				  		    
							from 
								  evntimg_dtl
							where 
								evntimgd_evntm_id = '$db_evntm_id'
								order by evntimgd_prty desc limit 1";
                // echo $sqryevntimg_dtl;
			$srsevntimg_dtl = mysqli_query($conn,$sqryevntimg_dtl);
			$serchres1		=mysqli_num_rows($srsevntimg_dtl);
			$imgnm  = '';
			if($serchres1 > 0){
				$srowprodimg_dtl=mysqli_fetch_assoc($srsevntimg_dtl);
				$bimg  			= $srowprodimg_dtl['evntimgd_img'];
				$bgimgpth 		= $u_imgevnt_fldnm.$bimg;			
				if(($bimg != '') && file_exists($bgimgpth)){	
					$imgnm = 	$bgimgpth;			
				}else{
                    $imgnm   =  $rtpth . $u_cat_bnrfldnm . 'default.jpg';
				}
			}else{
                $imgnm   =  $rtpth . $u_cat_bnrfldnm . 'default.jpg';
			}
      ?>
<img src="<?php echo $imgnm;?>" alt="Image">

<h2><?php echo $db_evntm_nm;?></h2>
<?php 
if($db_evntm_strt!=''){
	?>
<p>Event Date: <?php echo $db_evntm_strt;?>
	<?php
}
if($db_evntm_end!=''){
	?>
	-<?php echo $db_evntm_end;?></p>
	<?php
}
?>

<?php 
if($db_evntm_strtm!=''){
	?>
<p>Event Time: <?php echo $db_evntm_strtm;?>
	<?php
}
if($db_evntm_endtm!=''){
	?>
	-<?php echo $db_evntm_endtm;?></p>
	<?php
}
?>
<?php 
if($db_evntm_vne!=''){
	?>
<p>Event Venue: <?php echo $db_evntm_vne;?></p>
	<?php
}
?>
<p><?php echo $db_evntm_desc;?></p>

<!-- <p><?php echo $db_evntm_end;?></p> -->
<!-- <p>Event Time: <?php echo $db_evntm_strtm.' -- '.$db_evntm_endtm?></p> -->
<!-- <p><?php echo $db_evntm_endtm;?></p> -->
<!-- <p>Event Venue: <?php echo $db_evntm_vne;?></p> -->

</div>


</div>
</div>
<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-12 order-md-1 order-2">
              
			  <div class="campus-content pr-20 ">
							  <?php 
if(isset($_REQUEST['evntmid']) && trim($_REQUEST['evntmid'])!="" )
{
  
$sqryphtcat_mst1="SELECT evntimgd_name,evntimgd_id,evntimgd_img,evntimgd_sts				  		    
from  evntimg_dtl
where evntimgd_evntm_id = '$db_evntm_id' and evntimgd_sts='a' order by evntimgd_prty asc";
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

<!-- <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-12 order-md-2 order-1 ">
<div class="about-us-sideLinks">
 <div class="faq-left-content ">
     <div class="accordion" id="academicsLinks">

                        </div>
                    </div>
                </div>


            </div> -->
</div>
  





    </div>
</div>


<?php include_once('footer.php'); ?>