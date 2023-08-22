<?php
global $rflg,$pgrdvl;
//include_once "includes/inc_usr_sessions.php";	
include_once "includes/inc_connection.php";
include_once "includes/inc_usr_functions.php";	
include_once 'includes/inc_paging_functions_dist.php';  //Making paging validation	
	 include_once "includes/inc_folder_path.php";

$page_title = "Gallery | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Gallery | Chaitanya Bharathi Institute of Technology";
$db_seokywrd = "";
$db_seodesc = "";
$current_page = "home";
$body_class = "homepage";
$_SESSION['seslocval']	= $pgrdvl;
include('header.php');
global $pht_name,$srowsphtcat_dtl;
$page_title1 = "Photo Gallery";
global $id;
		 $id = glb_func_chkvl($_REQUEST['phtid']);
	
?>
<div class="page-banner-area bg-2 ">
	
</div>
<section class="page-bread">

    <div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
        <div class="page-banner-content">
				<?php
$sqryphtcat_mst="select phtcatm_name,phtcatm_desc from phtcat_mst where phtcatm_id='$id'  and phtcatm_sts='a'";
					  $srsphtcat_dtl = mysqli_query($conn,$sqryphtcat_mst);

			    while($srowsphtcat_dtl = mysqli_fetch_assoc($srsphtcat_dtl)){
					$pht_name=$srowsphtcat_dtl['phtcatm_name'];
					$pht_desc=$srowsphtcat_dtl['phtcatm_desc'];
				
						?>

            <h1><?php echo $pht_name;?> </h1>
            <ul>
                <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
								<li><a href='gallery.php'></a><?php echo $pht_name; ?></li>
                <!-- <li>Gallery cat name</li> -->
            </ul>
        </div>
				<?php }?>
    </div>
</section>
<?php 
 if(isset($_REQUEST['phtid']) && trim($_REQUEST['phtid'])!="" )
 {
	
 $sqryphtcat_mst1="SELECT phtm_id,phtm_simgnm,phtm_simg,	phtm_sts,phtm_prty from  vw_phtd_phtm_mst where  phtm_phtcatm_id  ='$id' and 	phtm_sts = 'a'   order by 	phtm_prty asc";
					
			$srsphtcat_dtl1 = mysqli_query($conn,$sqryphtcat_mst1);
			$cntrec_phtcat1 = mysqli_num_rows($srsphtcat_dtl1);
			if($cntrec_phtcat1 > 0){
			    
?>
<div class="section-pad-y">
    <div class="container-fluid px-lg-3 px-md-3 px-2">
        <div class="cont">
            <div class="demo-gallery">
                <ul id="lightgallery" class="list-unstyled row gx-xxl-1 gx-xl-1 gx-lg-1 gx-md-2 gx-0">
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
										<li class="col-xxl-3 col-lg-3 col-md-3 col-6 mb-2"
                        data-responsive="<?php echo $galryimages; ?> 375, <?php echo $galryimages; ?> 480, <?php echo $galryimages; ?> 800"
                        data-src="<?php echo $galryimages; ?> "
                        data-sub-html="<p class='text-white'>Category 6</p>">
                        <a href="">
                            <img class="img-responsive w-100" src="<?php echo $galryimages; ?>">
                            <div class="demo-gallery-poster">
														<img src="https://sachinchoolur.github.io/lightgallery.js/static/img/zoom.png">
                            </div>
                        </a>
                        <div class="gal-desc-1 p-2">
                            <p><?php echo $pht_name; ?></p>
                        </div>
                    </li>
                    
                <?php } ?>    
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
 }
 } ?>

<?php include_once('footer.php'); ?>