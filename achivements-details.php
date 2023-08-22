<?php
// include_once "includes/inc_usr_sessions.php";
include_once 'includes/inc_connection.php';
include_once 'includes/inc_usr_functions.php'; //Use function for validation and more
include_once 'includes/inc_config.php'; //Making paging validation	
include_once 'includes/inc_folder_path.php'; //Making paging validation	

if (isset($_REQUEST['achmtid']) && trim($_REQUEST['achmtid']) != "") {
    $achmtid   = funcStrUnRplc(glb_func_chkvl($_REQUEST['achmtid']));
		$sqryqry_achmntm = "SELECT achmntm_id, achmntm_name, achmntm_desc,achmntm_sdesc, achmntm_imgnm,achmntm_lnk, achmntm_prty, achmntm_sts FROM  achmnt_mst WHERE achmntm_sts = 'a' and achmntm_id='$achmtid' order by achmntm_prty asc ";
  
    $sqry_ach_mst = mysqli_query($conn, $sqryqry_achmntm);
$ach_cnt = mysqli_num_rows($sqry_ach_mst);
    if ($ach_cnt > 0) {
			$srowach_mst = mysqli_fetch_assoc($sqry_ach_mst);
				$achid = $srowach_mst['achmntm_id'];
				$achttl = $srowach_mst['achmntm_name'];
				$achlnk = $srowach_mst['achmntm_lnk'];
				$achimgnm = $srowach_mst['achmntm_imgnm'];
				$achsdesc = $srowach_mst['achmntm_sdesc'];
				$achdesc = $srowach_mst['achmntm_desc'];
				$achimg = $gusrach_fldnm . $achimgnm;
				if (($achimgnm != "") && file_exists($achimg)) {
					$achmntimgpth = $rtpth . $achimg;
				} else {
					$achmntimgpth   =  $rtpth . $u_cat_bnrfldnm . 'default.jpg';
				} 
    }
} else {
    header("Location:" . $rtpth . "Home");
    exit();
}

$page_title = $achttl;
$current_page = "Achivements";

// $page_title = "Events | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Achivements | Chaitanya Bharathi Institute of Technology";
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
            <h1><?php echo $page_title; ?></h1>
            <ul>
                <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
                <li><a href="<?php echo $rtpth; ?>achivement-list.php">Achivements</a></li>
                <li><?php echo $page_title; ?></li>
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
                       
                        
                        <img src="<?php echo $achmntimgpth; ?>" alt="Image">

                        <h2><?php echo $achttl; ?></h2>
                        <?php
				if($achlnk!=''){
					?> 
					<p><a href="<?php echo $achlnk;?>">Click here</a></p>
					<?php
				}
				?>
						<p><?php echo $achlnk;?></p>
                       <p><?php echo $achsdesc;?></p>
                        <p><?php echo $achdesc; ?></p>
                    </div>


                </div>
            </div>
         <!-- removed content -->
        </div>






    </div>
</div>


<?php include_once('footer.php'); ?>