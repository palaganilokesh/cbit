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
$ind_loc=$rtpth."home";
global $pht_name,$srowsphtcat_dtl;
$page_title1 = "Photo Gallery";
global $pht_id,$pt_scat_nm, $glry_cat,$glry_mnlnk;
		 $pht_id1 = glb_func_chkvl($_REQUEST['phtid']);
		 $pht_id=funcStrUnRplc( $pht_id1);
		 $glry_mnlnk1 = glb_func_chkvl($_REQUEST['mnlnks']);
		 $glry_mnlnk=funcStrUnRplc( $glry_mnlnk1);
		 $glry_cat1 = glb_func_chkvl($_REQUEST['catid']);
		 $glry_cat=funcStrUnRplc( $glry_cat1);
		 $pt_scat_nm1 = glb_func_chkvl($_REQUEST['scatid']);
		 $pt_scat_nm=funcStrUnRplc( $pt_scat_nm1);
		 $txt=explode('_',$pt_scat_nm );
		 $pt_id=$txt[1];
		 $pt_scat_nm=$txt[0];
		 $sqrydept_mst = "SELECT prodmnlnksm_id,prodmnlnksm_typ,prodmnlnksm_name,prodcatm_bnrimg,prodmnlnksm_sts,prodmnlnksm_prty,prodmnlnksm_bnrimg,prodcatm_id,prodcatm_name,prodcatm_typ,prodcatm_desc,prodcatm_bnrimg";
	if ($_REQUEST['mnlnks'] == 'departments' ||  $pt_scat_nm!='') {
		$sqrydept_mst .= ", prodscatm_id,prodscatm_name,prodscatm_desc,prodscatm_bnrimg,prodscatm_typ";
	}
	$sqrydept_mst .= " from prodmnlnks_mst inner join prodcat_mst on prodcatm_prodmnlnksm_id =prodmnlnksm_id";
	if ($_REQUEST['mnlnks'] == 'departments' || $pt_scat_nm!='') {
		$sqrydept_mst .= " inner join prodscat_mst on prodscatm_prodcatm_id=prodcatm_id";
	}
	$sqrydept_mst .= " where prodmnlnksm_sts='a' and prodcatm_sts = 'a'";
	if (isset($_REQUEST['catid']) && (trim($_REQUEST['catid']) != "")) {
		
		$sqrydept_mst .= " and prodcatm_name = '$glry_cat'";
		$loc = "&catid=$glry_cat";
	}
	if (isset($_REQUEST['scatid']) && (trim($_REQUEST['scatid']) != "")) {

		if($pt_scat_nm=='UG' || $pt_scat_nm=='PG' || $pt_scat_nm=='ug' || $pt_scat_nm=='pg' )
	{
		$pt_scat_nm='';	
	}
	else{
		$pt_scat_nm= $pt_scat_nm;
	}
	if($pt_scat_nm!=''){
		$sqrydept_mst .= " and prodscatm_name = '$pt_scat_nm'";
		$loc .= "&scatid=$pt_scat_nm";
	}
	}
	if (isset($_REQUEST['mnlnks']) && (trim($_REQUEST['mnlnks']) != "")) {

		$sqrydept_mst .= " and prodmnlnksm_name  = '$glry_mnlnk'";
		$loc .= "&mnlnks='$glry_mnlnk'";
	}
	if ($_REQUEST['mnlnks'] == 'departments' ||$pt_scat_nm!='') {
		$sqrydept_mst .= " and prodscatm_sts  = 'a'";
	}

	$sqrydept_mst2 = "group by prodcatm_id order by prodcatm_prty asc";

	$sqrydeptglary_mst  	= $sqrydept_mst . " " . $sqrydept_mst2;
	// echo $sqrydeptglary_mst;
	$srspgcnts_mst 		= mysqli_query($conn, $sqrydeptglary_mst);
	$cnt 		   		= $offset;
	$cnt_dept    	= mysqli_num_rows($srspgcnts_mst);
	$title 		   		= "";
	if ($cnt_dept > 0) {
		$srows_dept_gallery   = mysqli_fetch_assoc($srspgcnts_mst);
		$mnlnks_id	        = $srows_dept_gallery['prodmnlnksm_id'];
		$cattwo_id 	        = $srows_dept_gallery['prodscatm_id'];
		$catone_id	        = $srows_dept_gallery['prodcatm_id'];
		$prodscatm_name		= $srows_dept_gallery['prodscatm_name'];
		$cn_scat_url=funcStrRplc($prodscatm_name);
		$prodscatm_name1		=$prodscatm_name;
		$prodcatm_name		= $srows_dept_gallery['prodcatm_name'];
		$cn_cat_url=funcStrRplc($prodcatm_name);
		$prodcatm_bimg		= $srows_dept_gallery['prodcatm_bnrimg'];
		$prodmnlnksm_typ		= $srows_dept_gallery['prodmnlnksm_typ'];
		$prodmnlnksm_name		= $srows_dept_gallery['prodmnlnksm_name'];
		$cn_mn_url=funcStrRplc($prodmnlnksm_name);
		$prodmnlnksm_name1		=$prodmnlnksm_name;
		$prodscatm_desc  = $srows_dept_gallery['prodscatm_desc'];
		$prodscatm_typ  = $srows_dept_gallery['prodscatm_typ'];
		$prodcat_bnr	    = $srows_dept_gallery['prodcatm_bnrimg'];
		$prodcat_pth	    = $u_cat_bnrfldnm . $prodcat_bnr;
		$prodscat_bnr 	    = $srows_dept_gallery['prodscatm_bnrimg'];
		if ($glry_cat != '' || isset($glry_cat)) {
			$title = "$prodcatm_name";
			$bngimgpth = $u_cat_bnrfldnm . $prodcat_bnr;
			if ($prodcat_bnr != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm ."default-banner.jpg";
			}
		}
		else if ($pt_scat_nm != '' || isset($pt_scat_nm)) {
			$title = "$prodscatm_name";
			$bngimgpth = $u_scat_bnrfldnm . $prodscat_bnr;
			if ($prodscat_bnr != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		} else {
			$title = $prodcatm_name;
			$bngimgpth = $u_cat_bnrfldnm . $prodcatm_bimg;
			if ($prodcatm_bimg != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth .$bngimgpth;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm . "default-banner.jpg";
			}
		}
		if ($_REQUEST['mnlnks'] == 'departments') {
			$title = "$prodscatm_name";
			$bngimgpth = $u_cat_bnrfldnm . $prodcat_bnr;
			if ($prodcat_bnr != "" && file_exists($bngimgpth)) {
				$bnrimgpth = $rtpth . $bngimgpth;
			} else {
				$bnrimgpth = $rtpth . $u_cat_bnrfldnm ."default-banner.jpg";
			}
		}
	} else {
		header("Location:$ind_loc");
		exit();
	}

?>
<style>
.section-title h2 {
    font-size: 20px;
}
</style>
<div class="page-banner-area bg-2" style="background-image:url(<?php echo $bnrimgpth; ?>) ;">
</div>
<section class="page-bread">
    <div class="container-fluid px-lg-3 px-md-3 px-2 py-2">
        <div class="page-banner-content">
				<h1><?php echo $title; ?></h1>
            <ul>
						<?php
				if ($_REQUEST['mnlnks'] == 'departments') {
				?>
					<?php $bdqry="SELECT prodscatm_name from prodscat_mst where prodscatm_prodcatm_id='$catone_id' group by  prodscatm_prodcatm_id order by prodscatm_prty asc limit 1";
				$res=mysqli_query($conn,$bdqry);
				$value=mysqli_fetch_assoc($res);
				$bred_scat_url=$value['prodscatm_name'];
				?>
				<li><a href="<?php echo $rtpth; ?>home">Home</a></li>
				<li><a href="<?php echo $rtpth; ?>departments"><?php echo $prodmnlnksm_name ;?></a></li>
				<li><a href="<?php echo $rtpth . $cn_mn_url . '/' . $cn_cat_url.'/'.$bred_scat_url;?>"><?php echo $prodcatm_name; ?></a></li>
				<li><?php echo $prodscatm_name1; ?></li>
				<?php
				}
				?>
            </ul>
        </div>
    </div>
</section>

<div class="campus-information-area section-pad-y">
       <div class="container-fluid px-lg-3 px-md-3 px-2">
        <div class="row">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-12 order-md-1 order-2">
              
                <div class="campus-content pr-20 ">
								<?php 
 if(isset($_REQUEST['phtid']) && trim($_REQUEST['phtid'])!="" )
 {
	
 $sqryphtcat_mst1="SELECT phtm_id,phtm_simgnm,phtm_simg,	phtm_sts,phtm_prty from  vw_phtd_phtm_mst where  phtm_phtcatm_id  ='$pt_id' and 	phtm_sts = 'a'   order by 	phtm_prty asc";
					
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