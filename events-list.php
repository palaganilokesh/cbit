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

$evnttoday = date('Y-m-d');
$crntmnty = date('n');
  $sqryevnt_mst = "select 
          evntm_id,evntm_name,evntm_desc,evntm_city,
          evntm_strtdt,evntm_enddt,evntm_venue,evtnm_strttm,
          evntm_endtm,DATE_format(evntm_strtdt, '%D %M %Y') as stdate,
          DATE_format(evntm_enddt, '%D %M %Y') as eddate
        from 
          evnt_mst
        where 
          evntm_sts='a'  and evntm_typ='e'" ;
  
  if(isset($_REQUEST['id']) && trim($_REQUEST['id'])!= ""){
    $evntId			= glb_func_chkvl($_REQUEST['id']);
    $sqryevnt_mst .= " and evntm_id = '$evntId' ";
  }
  // if((isset($_REQUEST['day']) && (trim ($_REQUEST['day'])!= "") && 
  //   isset($_REQUEST['year']) && (trim($_REQUEST['year']) != "") && 
  //   isset($_REQUEST['month']) && trim($_REQUEST['month'])!= "")){
                
  //   $CurrMonth	= $_REQUEST['month'];
  //   $CurrYear	= $_REQUEST['year'];
  //   $CurrDay	= $_REQUEST['day'];
  //   $loc 	   .= "&day=$CurrDay&month=$CurrMonth&year=$CurrYear";
  //   if($CurrDay < 10){
  //       $CurrDay = "0".$CurrDay;
  //   }
  //   if($CurrMonth < 10){
  //       $CurrMonth = "0".$CurrMonth;
  //   }					
  //   $date = glb_func_chkvl($CurrYear ."-".$CurrMonth."-".$CurrDay);
  //   $sqryevnt_mst.=" and '$date' between evntm_strtdt and evntm_enddt ||  '$date' IN (evntm_strtdt,evntm_enddt)";
  //   $evnttoday = $date;
  //   $crntmnty  = $CurrMonth; 	
  // }
  // elseif((isset($_REQUEST['date'])!="") && trim($_REQUEST['date']) != ''){
  //    $month_name = date('m',$_REQUEST['date']); 
  //    $sqryevnt_mst.=" and $month_name between MONTH(evntm_strtdt) and MONTH(evntm_enddt) ||  '$month_name' IN (MONTH(evntm_strtdt),MONTH(evntm_enddt))";
  // }else{
  //   $sqryevnt_mst.="and
  //         (evntm_strtdt >= '$evnttoday' or
  //         evntm_enddt >= '$evnttoday') and
  //         (month(evntm_strtdt) >= '$crntmnty' or
  //         month(evntm_enddt) >= '$crntmnty')";	
  // }
  $pgqry = $sqryevnt_mst; 		
  $_SESSION['seprodscatqry'] =$sqryevnt_mst;
  $sqryevnt_mst	.=	" group by evntm_id order by evntm_prty DESC ";	
  // limit $offset,$rowsprpg
  // echo 	$sqryevnt_mst;		
  $srsevnt_mst  	 =  mysqli_query($conn,$sqryevnt_mst) or die(mysqli_error($conn));
  $cntrec_mst  = mysqli_num_rows($srsevnt_mst);

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
      <h1>Events</h1>
      <ul>
        <li><a href="<?php echo $rtpth; ?>home">Home</a></li>
        <li>Events</li>
      </ul>
    </div>
  </div>
</section>
<?php
if($cntrec_mst > 0){
  ?>
  <div class="campus-information-area section-pad-y">
  <div class="container-fluid px-lg-3 px-md-3 px-2">
    <div class="row justify-content-center">
      <?php

		$cntval = '';
		while($srowevnt_mst = mysqli_fetch_assoc($srsevnt_mst)){
			$db_evntm_nm = $srowevnt_mst['evntm_name'];
      $db_evntm_desc = $srowevnt_mst['evntm_desc'];
			$db_evntm_id = $srowevnt_mst['evntm_id'];
			$db_evntm_vne = $srowevnt_mst['evntm_venue'];
			$db_evntm_strt = $srowevnt_mst['stdate'];
			$db_evntm_end = $srowevnt_mst['eddate'];
			// $db_evntm_lnk = $srowevnt_mst['evntm_img'];
			$u_evntm_nm = funcStrRplc($db_evntm_nm);
			$dsplyNm = $db_evntm_strt;
			if($db_evntm_end !=''){
				$dsplyNm = $db_evntm_strt."-".$db_evntm_end;
			}
			// $urlLnk = $rtpth.'events/'."$u_evntm_nm";
			// if($db_evntm_lnk !=''){
			// 	$urlLnk = 	$db_evntm_lnk;
			// }
			
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
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="single-health-care-card">
          <div class="img">
            <a href="<?php echo $rtpth?>events-details.php?evntmid=<?php echo $db_evntm_id;?>"><img src="<?php echo $imgnm; ?>" alt="Image"></a>
          </div>
          <div class="health-care-content">
            <span class="mb-3 pull-right"><i class="flaticon-date"></i><?php echo $dsplyNm;?></span>
            <a href="<?php echo $rtpth?>events-details.php?evntmid=<?php echo $db_evntm_id;?>">
              <h3><?php echo $u_evntm_nm;?></h3>
            </a>
           
            <p> <?php echo substr($db_evntm_desc, 0, 100); ?>...</p>
            <a href="<?php echo $rtpth?>events-details.php?evntmid=<?php echo $db_evntm_id;?>" class="read-more-btn">Read More <i class="flaticon-next"></i></a>
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