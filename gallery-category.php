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
global $id,$id1;
//  $id1 = glb_func_chkvl($_REQUEST['pht_cat_id']);
$id1 = glb_func_chkvl($_REQUEST['pht_cat_id']);
 $nm=funcStrUnRplc($id1);
 $txt=explode('_',$nm);
$pt_id=$txt[1];
$pt_nm=$txt[0];
	
?>
<div class="page-banner-area bg-2 ">
</div>
<section class="page-bread">

    <div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
        <div class="page-banner-content">
				<?php
$sqryphtcat_mst="SELECT phtcatm_name,phtcatm_desc,phtcatm_id from phtcat_mst where (phtcatm_id='$pt_id' or phtcatm_name='$pt_nm')  and phtcatm_sts='a'";
					  $srsphtcat_dtl = mysqli_query($conn,$sqryphtcat_mst);

			    while($srowsphtcat_dtl = mysqli_fetch_assoc($srsphtcat_dtl)){
					$pht_name=$srowsphtcat_dtl['phtcatm_name'];
          $pht_nm_url=funcStrRplc($pht_name);
					$pht_desc=$srowsphtcat_dtl['phtcatm_desc'];
					$pht_id=$srowsphtcat_dtl['phtcatm_id'];
                    

				
						?>

            <h1><?php echo $pht_name;?> </h1>
            <ul>
                <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
								<li><a href='gallery.php'></a><?php echo $pht_name; ?></li>
          
               
            </ul>
        </div>
				<?php }?>
    </div>
</section>
<?php 
 if(isset($_REQUEST['pht_cat_id']) && trim($_REQUEST['pht_cat_id'])!="" )
 {
	
  $sqryphtcat_mst1="SELECT phtd_id,phtd_phtcatm_id,phtd_type,phtd_name,phtd_sts,phtd_rank from  vw_phtd_phtm_mst where  phtd_phtcatm_id  ='$pht_id' and 	phtd_sts = 'a'  group by phtd_id  order by 	phtd_rank asc";
					
			$srsphtcat_dtl1 = mysqli_query($conn,$sqryphtcat_mst1);
			$cntrec_phtcat1 = mysqli_num_rows($srsphtcat_dtl1);
			if($cntrec_phtcat1 > 0){
			    
?>

<div class="section-pad-y">
    <div class="container-fluid px-lg-3 px-md-3 px-2">

        <div class="cont">


            <div class="demo-gallery">
                <ul id="" class="list-unstyled row gx-xxl-1 gx-xl-1 gx-lg-1 gx-md-2 gx-0">
                <?php
									while($srowsphtcat_dtl1 = mysqli_fetch_assoc($srsphtcat_dtl1)){
										$pht_cat_id         = $srowsphtcat_dtl1['phtd_id'];
									    //$pht_cat_id         = $srowsphtcat_dtl1['phtd_desc'];
										$pht_name      = $srowsphtcat_dtl1['phtd_name'];
                                        $pht_url=funcStrRplc($pht_name);
                                        $sqrypht_dtl="SELECT phtm_id,phtm_simgnm,phtm_simg,phtm_sts,phtm_prty from  vw_phtd_phtm_mst where  phtm_phtcatm_id  ='$pht_id' and phtm_phtd_id='$pht_cat_id' and	phtm_sts = 'a'   order by 	phtm_prty asc limit 1";
					
                                        $srspht_dtl1 = mysqli_query($conn,$sqrypht_dtl);
                                        $cntrec = mysqli_num_rows($srspht_dtl1);
                                      $srowspht_dtl1 = mysqli_fetch_assoc($srspht_dtl1);
										$bphtimgnm     = $srowspht_dtl1['phtm_simg'];
										$bimgpath      = $u_phtgalspath1.$bphtimgnm;
										if (($bphtimgnm != "") && file_exists($bimgpath)) {
										$galryimages = $rtpth . $bimgpath;
										} else {
											$galryimages   = $rtpth . $gusrglry_fldnm . 'default.jpg';
											
										}
                                        	
										?>

                    <li class="col-xxl-3 col-lg-3 col-md-3 col-6 mb-2"
                        data-responsive="<?php echo $galryimages; ?> 375, <?php echo $galryimages; ?> 480, <?php echo $galryimages; ?> 800 "
                        data-src="<?php echo $galryimages; ?> " data-sub-html="<h4>Category 1</h4>">
                          <!-- <a href="  <?php echo $rtpth.'photo-gallery/'.$pht_url.'_'.$pht_id;?>"> -->
                          <a href="  <?php echo $rtpth.$pht_nm_url.'/'.$pht_url.'_'.$pht_cat_id;?>">
                            <img class="img-responsive w-100" src="<?php echo $galryimages; ?>">
                            <div class="demo-gallery-poster">

                            </div>
                        </a>
                        <h2 class="cat-caption"><?php echo $pht_name;?></h2>
                    </li>
                   <?php
                                    }
                                    ?>


                </ul>

            </div>
        </div>
    </div>

</div>
<?php
                 }     }
            ?>



<?php include_once('footer.php'); ?>