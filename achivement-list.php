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

$sqryqry_achmntm = "SELECT achmntm_id, achmntm_name, achmntm_desc,achmntm_sdesc, achmntm_imgnm,achmntm_lnk, achmntm_prty, achmntm_sts FROM  achmnt_mst WHERE achmntm_sts = 'a' order by achmntm_prty asc ";
$sqry_ach_mst = mysqli_query($conn, $sqryqry_achmntm);
$ach_cnt = mysqli_num_rows($sqry_ach_mst);
  
//   if(isset($_REQUEST['id']) && trim($_REQUEST['id'])!= ""){
//     $evntId			= glb_func_chkvl($_REQUEST['id']);
//     $sqryevnt_mst .= " and evntm_id = '$evntId' ";
//   }
  

$page_title = "Achivements | Chaitanya Bharathi Institute of Technology";
$page_seo_title = "Achivements| Chaitanya Bharathi Institute of Technology";
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
      <h1>Achivements</h1>
      <ul>
        <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
        <li>Achivements</li>
      </ul>
    </div>
  </div>
</section>
<?php
if($ach_cnt > 0){
  ?>
  <div class="campus-information-area section-pad-y">
  <div class="container-fluid px-lg-3 px-md-3 px-2">
    <div class="row justify-content-center">
      <?php
 while ($srowach_mst = mysqli_fetch_assoc($sqry_ach_mst)) {
   $achid = $srowach_mst['achmntm_id'];
   $achttl = $srowach_mst['achmntm_name'];
   $ach_url=funStrUrlEncode($achttl);
  //  echo  $ach_url;
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
 ?>
	
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="single-health-care-card">
          <div class="img">
            <a href="<?php echo $rtpth.'latest-achivements/'.$ach_url.'_'.$achid ?>"><img src="<?php echo $achmntimgpth; ?>" alt="Image"></a>
          </div>
          <div class="health-care-content">
            <!-- <span class="mb-3 pull-right"><i class="flaticon-date"></i><?php echo $dsplyNm;?></span> -->
            <a href="<?php echo $rtpth.'latest-achivements/'.$ach_url.'_'.$achid ?>">
              <h3><?php echo $achttl;?></h3>
            </a>
           
            <!-- <p> <?php echo substr($achsdesc, 0, 100); ?>...</p> -->
            <p> <?php echo $achsdesc;?></p>
            <a href="<?php echo $rtpth.'latest-achivements/'.$ach_url.'_'.$achid ?>" class="read-more-btn">Read More <i class="flaticon-next"></i></a>
          </div>
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

<?php include_once('footer.php'); ?>