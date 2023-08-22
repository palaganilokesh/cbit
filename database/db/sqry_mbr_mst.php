<?php
session_start();
error_reporting(0);
include_once "../includes/inc_config.php"; //Including user session value
include_once "../includes/inc_connection.php"; //Including user session value
include_once "../includes/inc_usr_functions.php"; //Including user session value
if (isset($_SESSION['sesmbremail']) && ($_SESSION['sesmbremail'] != "") || isset($_SESSION['sesmbrid']) && ($_SESSION['sesmbrid'] != ""))
{
  if (isset($_SESSION['cartcode']) && ($_SESSION['cartcode'] != ""))
  {
    ?>
    <script type="text/javascript">
      location.href = "<?php echo $rtpth; ?>checkout";
    </script>
    <?php
  }
  else
  {
    ?>
    <script type="text/javascript">
      location.href = "<?php echo $rtpth; ?>home";
    </script>
    <?php
  }
  exit();
}
elseif (isset($_POST['txtsgnemail']) && isset($_POST['txtsgnpwd']) && (trim($_POST['txtsgnemail']) != "") && (trim($_POST['txtsgnpwd']) != ""))
{
  $uid = glb_func_chkvl($_POST['txtsgnemail']);
  $pwd = md5(trim($_POST['txtsgnpwd']));
  // $sqrymbr_mst = "SELECT mbrm_id,mbrm_emailid,mbrm_usrtyp, mbrd_lstname,mbrd_badrs,mbrd_bmbrcntrym_id, mbrd_bmbrcntym_id,mbrd_bzip, mbrd_bdayphone,mbrd_dfltshp,mbrinfm_id,mbrinfm_email from vw_mbr_mst_bil left join mbrinf_mst on mbrm_id = mbrinfm_mbrm_id where (mbrm_name=binary('".mysqli_real_escape_string($conn, $uid)."') or mbrm_usernm=binary('".mysqli_real_escape_string($conn, $uid)."') or mbrm_emailid=binary('".mysqli_real_escape_string($conn, $uid)."')) and mbrm_pwd=binary('".mysqli_real_escape_string($conn, $pwd)."')";
  $sqrymbr_mst = "SELECT mbrm_id,mbrm_emailid,mbrd_fstname,mbrm_usrtyp, mbrm_vrfsts, mbrd_lstname,mbrd_badrs,mbrd_bmbrcntrym_id, mbrd_bctym_id,mbrd_bmbrcntym_id,mbrd_bzip, mbrd_bdayphone,mbrd_dfltshp from vw_mbr_mst_bil where (mbrm_emailid=binary('" . mysqli_real_escape_string($conn, $uid) . "') or mbrm_phno=binary('" . mysqli_real_escape_string($conn, $uid) . "')) and mbrm_pwd=binary('" . mysqli_real_escape_string($conn, $pwd) . "')";
  // echo $sqrymbr_mst; exit;
  $srsmbr_mst = mysqli_query($conn, $sqrymbr_mst);
  $cntrec = mysqli_num_rows($srsmbr_mst);
  if ($cntrec == 0)
  {
    //if record is equal to zero
    // $gmsg = "<div class='alert alert-danger'>Invalid Credentials. Please try again.</div>";
    echo "n";
  }
  elseif ($cntrec >= 1)
  {
    while ($srowmbr_mst = mysqli_fetch_assoc($srsmbr_mst)) {
      $_SESSION['sesmbremail'] = $srowmbr_mst['mbrm_emailid']; //assing value of user id to admin session
      $_SESSION['sesmbrid'] = $srowmbr_mst['mbrm_id']; //assing value of user id to admin session 
      $_SESSION['sesmbrusrtyp'] = $srowmbr_mst['mbrm_usrtyp']; //assing value of user type to user session 
      $_SESSION['sesmbrusrvrfd'] = $srowmbr_mst['mbrm_vrfsts']; //assing value of user type to user session 
      $_SESSION['sesmbrphn'] = $srowmbr_mst['mbrd_bdayphone']; //assing value of user id to admin session
      $_SESSION['sesmbrdname'] = $srowmbr_mst['mbrd_fstname'] . " " . $srowmbr_mst['mbrd_lstname'];
      // $mbrinfm_email = $srowmbr_mst['mbrinfm_email'];
      if ($srowmbr_mst['mbrd_dfltshp'] == "y") {
        $_SESSION['sesmbrdcity'] = $srowmbr_mst['mbrd_bctym_id'];
        $frstnm = $srowmbr_mst['mbrd_fstname'];
        $lstnm = $srowmbr_mst['mbrd_lstname'];
        $adrs = $srowmbr_mst['mbrd_badrs'];
        $cntry = $srowmbr_mst['mbrd_bmbrcntrym_id'];
        $cty = $srowmbr_mst['mbrd_bctym_id'];
        $cnty = $srowmbr_mst['mbrd_bmbrcntym_id'];
        $zip = $srowmbr_mst['mbrd_bzip'];
        // $mbrinfm_id = $srowmbr_mst['mbrinfm_id'];
      }
    }
    if (isset($_SESSION['prodid']) && (trim($_SESSION['prodid'] != ""))) {
      if ((trim($frstnm) != "") && (trim($adrs) != "") && (trim($cty) != "") && (trim($zip) != ""))
      {
        echo 'c';
      }
      else
      {
        echo 'a';
      }
    }
    else
    { 
      echo 'h';
    }
  }
} elseif (isset($_POST['txtsgnemail1']) && isset($_POST['txtsgnpwd1']) && (trim($_POST['txtsgnemail1']) != "") && (trim($_POST['txtsgnpwd1']) != "")) {
  $uid = glb_func_chkvl($_POST['txtsgnemail1']);
  $pwd = md5(trim($_POST['txtsgnpwd1']));
  // $sqrymbr_mst = "SELECT mbrm_id,mbrm_emailid,mbrm_usrtyp, mbrd_lstname,mbrd_badrs,mbrd_bmbrcntrym_id, mbrd_bmbrcntym_id,mbrd_bzip, mbrd_bdayphone,mbrd_dfltshp,mbrinfm_id,mbrinfm_email from vw_mbr_mst_bil left join mbrinf_mst on mbrm_id = mbrinfm_mbrm_id where (mbrm_name=binary('".mysqli_real_escape_string($conn, $uid)."') or mbrm_usernm=binary('".mysqli_real_escape_string($conn, $uid)."') or mbrm_emailid=binary('".mysqli_real_escape_string($conn, $uid)."')) and mbrm_pwd=binary('".mysqli_real_escape_string($conn, $pwd)."')";
  $sqrymbr_mst = "SELECT mbrm_id,mbrm_emailid,mbrd_fstname,mbrm_usrtyp, mbrm_vrfsts, mbrd_lstname,mbrd_badrs,mbrd_bmbrcntrym_id, mbrd_bctym_id,mbrd_bmbrcntym_id,mbrd_bzip, mbrd_bdayphone,mbrd_dfltshp from vw_mbr_mst_bil where (mbrm_emailid=binary('" . mysqli_real_escape_string($conn, $uid) . "') or mbrm_phno=binary('" . mysqli_real_escape_string($conn, $uid) . "')) and mbrm_pwd=binary('" . mysqli_real_escape_string($conn, $pwd) . "')";
  // echo $sqrymbr_mst; exit;
  $srsmbr_mst = mysqli_query($conn, $sqrymbr_mst);
  $cntrec = mysqli_num_rows($srsmbr_mst);
  if ($cntrec == 0) {
    //if record is equal to zero
    // $gmsg = "<div class='alert alert-danger'>Invalid Credentials. Please try again.</div>";
    echo "n";
  } elseif ($cntrec >= 1) {
    while ($srowmbr_mst = mysqli_fetch_assoc($srsmbr_mst)) {
      $_SESSION['sesmbremail'] = $srowmbr_mst['mbrm_emailid']; //assing value of user id to admin session
      $_SESSION['sesmbrid'] = $srowmbr_mst['mbrm_id']; //assing value of user id to admin session 
      $_SESSION['sesmbrusrtyp'] = $srowmbr_mst['mbrm_usrtyp']; //assing value of user type to user session 
      $_SESSION['sesmbrusrvrfd'] = $srowmbr_mst['mbrm_vrfsts']; //assing value of user type to user session 
      $_SESSION['sesmbrphn'] = $srowmbr_mst['mbrd_bdayphone']; //assing value of user id to admin session
      $_SESSION['sesmbrdname'] = $srowmbr_mst['mbrd_fstname'] . " " . $srowmbr_mst['mbrd_lstname'];
      // $mbrinfm_email = $srowmbr_mst['mbrinfm_email'];
      if ($srowmbr_mst['mbrd_dfltshp'] == "y") {
        $_SESSION['sesmbrdcity'] = $srowmbr_mst['mbrd_bctym_id'];
        $frstnm = $srowmbr_mst['mbrd_fstname'];
        $lstnm = $srowmbr_mst['mbrd_lstname'];
        $adrs = $srowmbr_mst['mbrd_badrs'];
        $cntry = $srowmbr_mst['mbrd_bmbrcntrym_id'];
        $cty = $srowmbr_mst['mbrd_bctym_id'];
        $cnty = $srowmbr_mst['mbrd_bmbrcntym_id'];
        $zip = $srowmbr_mst['mbrd_bzip'];
        // $mbrinfm_id = $srowmbr_mst['mbrinfm_id'];
      }
    }
    if (isset($_SESSION['prodid']) && (trim($_SESSION['prodid'] != ""))) {
      if ((trim($frstnm) != "") && (trim($adrs) != "") && (trim($cty) != "") && (trim($zip) != "")) {
        echo 'c';
      } else {
        echo 'a';
      }
    } else {
      echo 'h';
    }
  }
}
?>