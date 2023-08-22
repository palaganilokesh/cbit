<?php	
include_once "includes/inc_nocache.php"; // Clearing the cache information
include_once "includes/inc_membr_session.php"; // checking for session
include_once "includes/inc_usr_functions.php"; // Including user function value
if(isset($_POST['hnsname']) && (trim($_POST['hnsname']) != "") && isset($_POST['hnsemail']) && (trim($_POST['hnsemail']) != "") && isset($_POST['txtaddr']) && (trim($_POST['txtaddr']) != "") && isset($_POST['txtpin']) && (trim($_POST['txtpin']) != "") && isset($_POST['txtphno']) && (trim($_POST['txtphno']) != "")&& isset($_POST['lststate']) && (trim($_POST['lststate']) != "") && isset($_POST['txtcty']) && (trim($_POST['txtcty']) != ""))
{
  $email = glb_func_chkvl($_POST['hnsemail']);
  $name = glb_func_chkvl($_POST['hnsname']);
  $addrs = glb_func_chkvl($_POST['txtaddr']);
  $pincode = glb_func_chkvl($_POST['txtpin']);
  $phno = glb_func_chkvl($_POST['txtphno']);
  $cntryid = glb_func_chkvl($_POST['lstcntry']);
  $stateid = glb_func_chkvl($_POST['lststate']);
  $ctynm = glb_func_chkvl(ucwords($_POST['txtcty']));		
  $othrbcntry = "";
  $othrbcnty = "";	
  $othrbcty = "";
  if($bcntry == "o")
  {
    $bcnty = "";
  }
  $bcty = "NULL";
  $dt = date('Y-m-d');
  $membrid = $_SESSION['sesmbrid'];
  //////////////city/////////////////
  $sqrymbrcnty_mst = "SELECT ctym_id,ctym_name,ctym_sts from 	cty_mst  where ctym_name = '$ctynm' and ctym_cntym_id ='$stateid'";					 								
  $srsmbrcnty_mst = mysqli_query($conn,$sqrymbrcnty_mst) or die(mysql_error());
  $cntcty=mysqli_num_rows($srsmbrcnty_mst);
  if($cntcty >0)
  {
    $rowscnty=mysqli_fetch_assoc($srsmbrcnty_mst);
    $ctyid=$rowscnty['ctym_id'];
    $ctynm =$rowscnty['ctym_name'];
  }
  else
  {
    $sqlcty_mst = "INSERT into cty_mst (ctym_name,ctym_cntym_id,ctym_cntrym_id,ctym_sts,ctym_prty) values('$ctynm','$stateid','$ctryid','a','1')";
    $rwssqlcty_mst=mysqli_query($conn,$sqlcty_mst);
    $ctyid=mysqli_insert_id($conn);
  }
  //////////////city/////////////////
  $updtmbrsts_dtl = "update mbr_dtl set mbrd_dfltbil ='n' where  mbrd_mbrm_id ='$membrid'";
  $rwsupdtmbrsts_mst=mysqli_query($conn,$updtmbrsts_dtl);
  $iqrymbr_dtl = "INSERT into mbr_dtl(mbrd_emailid,mbrd_fstname,mbrd_badrs, mbrd_bmbrcntrym_id,mbrd_bmbrcntym_id,mbrd_bcty_id,mbrd_bctym_id,mbrd_ctynm, mbrd_dfltbil,mbrd_bzip,mbrd_bdayphone, mbrd_mbrm_id,mbrd_crtdon,mbrd_crtdby) values('$email','$name','$addrs','$cntryid','$stateid','$ctyid','$ctyid','$ctynm','y','$pincode','$phno','$membrid','$dt','$membremail')";
  //echo $iqrymbr_dtl;exit;
  $irsmbr_dtl = mysqli_query($conn,$iqrymbr_dtl) or die(mysql_error());
  if($irsmbr_dtl==true)
  {
    $mbmid = mysqli_insert_id($conn);
    //echo $iqrymbr_dtl;exit;
    if( $_POST['btnadddetls'] !='')
    { ?>
      <script language="javascript" type="text/javascript">
        location.href = "<?php echo $rtpth.'my-dashboard'?>";
      </script>
      <?php
    }
    else
    { ?>
      <script language="javascript" type="text/javascript">
        location.href = "<?php echo $rtpth?>my-dashboard";
      </script>
      <?php
    }
    $gmsg="Record saved successfully";
  }
  else
  {
    $gmsg="Record Not Saved";
  }
}//close end if	
?>