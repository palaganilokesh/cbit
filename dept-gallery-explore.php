<?php
include_once "includes/inc_connection.php";
include_once "includes/inc_usr_functions.php";	
include_once 'includes/inc_paging_functions_dist.php';  //Making paging validation	
	 include_once "includes/inc_folder_path.php";
$page_title = "Department of Civil Engineering | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Department of Civil Engineering | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
include('header.php');
global $pht_name,$srowsphtcat_dtl;
$page_title1 = "Photo Gallery";
global $pht_id,$glry_scat, $glry_cat,$glry_mnlnk;
		 $pht_id = glb_func_chkvl($_REQUEST['phtid']);
		 $glry_mnlnk = glb_func_chkvl($_REQUEST['mnlnks']);
		 $glry_cat = glb_func_chkvl($_REQUEST['catid']);
		 $glry_scat = glb_func_chkvl($_REQUEST['scatid']);
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
            <h1>Department of Civil Engineering</h1>
            <ul>
                <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
                <li>Academics</li>
                <li>Department of Civil Engineering</li>
                <li>Gallery</li>
            </ul>
        </div>
    </div>
</section>
<?php
						include_once $rtpth."catrightblock.php";
						// include_once('catrightblock.php'); ?>
<div class="campus-information-area section-pad-y">
       <div class="container-fluid px-lg-3 px-md-3 px-2">
        <div class="row">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-12 order-md-1 order-2">
              
                <div class="campus-content pr-20 ">
								<?php 
 if(isset($_REQUEST['phtid']) && trim($_REQUEST['phtid'])!="" )
 {
	
 $sqryphtcat_mst1="SELECT phtm_id,phtm_simgnm,phtm_simg,	phtm_sts,phtm_prty from  vw_phtd_phtm_mst where  phtm_phtcatm_id  ='$pht_id' and 	phtm_sts = 'a'   order by 	phtm_prty asc";
					
			$srsphtcat_dtl1 = mysqli_query($conn,$sqryphtcat_mst1);
			$cntrec_phtcat1 = mysqli_num_rows($srsphtcat_dtl1);
			if($cntrec_phtcat1 > 0){
			    
?>
                <div class="cont ">
            <div class="demo-gallery ">
                <ul id="lightgallery" class="list-unstyled row gx-xxl-1 gx-xl-1 gx-lg-1 gx-md-2 gx-0 ">
								<?php
									while($srowsphtcat_dtl1 = mysqli_fetch_assoc($srsphtcat_dtl1)){
										$phtid         = $srowsphtcat_dtl1['phtm_id'];
									//$phtid         = $srowsphtcat_dtl1['phtd_desc'];
										$pht_name      = $srowsphtcat_dtl1['phtm_simgnm'];
										$bphtimgnm     = $srowsphtcat_dtl1['phtm_simg'];
										$bimgpath      = $u_phtgalspath1.$bphtimgnm;
										if (($bphtimgnm != "") && file_exists($bimgpath)) {
											$galryimages = $rtpth . $bimgpath;
										} else {
											$galryimages   = $rtpth . $gusrglry_fldnm . 'default.jpg';
											
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
						
						<?php
						include_once "catrightblock.php";
					 ?>
          
            </div>
					  </div> 
			</div>
</div>
<?php include_once('footer.php'); ?>