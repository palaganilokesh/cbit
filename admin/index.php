<?php
session_start();

include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once '../includes/inc_connection.php'; //Make connection with the database
include_once '../includes/inc_config.php'; //Make connection with the database
include_once '../includes/inc_usr_functions.php'; //Make connection with the database

$_SESSION['sesadminid']    = ""; //define the session admin
$_SESSION['sesadmin']      = ""; //define the session admin
$_SESSION['sesadmtyp']     = ""; //define the session type
$_SESSION['seslgntrckid']   = "";
global $gmsg; //message for Invalid User Id or Password	

if (isset($_REQUEST['cp']) && (trim($_REQUEST['cp']) != "")) {
  $gmsg = "<font color='red'><b>Password Changed. <br>  Please enter new password for login.</b></font>";
} //check whether variable is set or not 

if (
  isset($_POST['txtuid']) && (trim($_POST['txtuid']) != "") &&
  isset($_POST['txtpwd']) && (trim($_POST['txtpwd']) != "")
) {

  $uid     = glb_func_chkvl($_POST['txtuid']);
  $pwd     = md5(trim($_POST['txtpwd']));

  $sqrylgn_mst = "select 
							lgnm_id,lgnm_uid,lgnm_typ 
						from 
							lgn_mst 
						where							
							lgnm_uid=binary('" . mysqli_real_escape_string($conn, $uid) . "') and
							lgnm_pwd=binary('" . mysqli_real_escape_string($conn, $pwd) . "') and							
							(lgnm_typ = 'a' or lgnm_typ = 'u' or lgnm_typ = 'd') and 
							lgnm_sts = 'a'"; //select record from database.

  // echo  $sqrylgn_mst; exit;

  $srslgn_mst   =  mysqli_query($conn, $sqrylgn_mst);
  $cntrec     =  mysqli_num_rows($srslgn_mst);
  if ($cntrec == 0) {
    //if record is equal to zero
    $gmsg = "<font color=red><b>Invalid User Id or Password</b></font>";
  } elseif ($cntrec == 1) {
    //if record is equal to one			
    $srowlgn_mst  = mysqli_fetch_assoc($srslgn_mst);
    $db_lgnm_id    = $srowlgn_mst['lgnm_id'];
    $db_lgnm_uid  = $srowlgn_mst['lgnm_uid'];
    $db_lgnm_typ  = $srowlgn_mst['lgnm_typ'];

    $_SESSION['sesadminid']  = $db_lgnm_id; //assign value of user id to admin session
    $_SESSION['sesadmin']   = $db_lgnm_uid; //assign value of user name to admin session
    $_SESSION['sesadmtyp']  = $db_lgnm_typ; //assign value of user type to typ session
    $curdt                  = date('Y-m-d h:i:s');

    $sid                    =  session_id();
    $ipadrs                 =  $_SERVER['REMOTE_ADDR'];

    $iqrylgntrck_mst       =  "insert into lgntrck_mst(lgntrckm_sesid,lgntrckm_ipadrs,
								  		lgntrckm_lgnm_id,lgntrckm_crtdon,lgntrckm_crtdby)values(
								  		'$sid','$ipadrs',$db_lgnm_id,'$curdt','$db_lgnm_uid')";

    $srslgntrck_mst       = mysqli_query($conn, $iqrylgntrck_mst);
    $cntrec_lgntrck      = mysqli_affected_rows($conn);
    if ($cntrec_lgntrck == 1) {
      $db_lgntrck_id = mysqli_insert_id($conn);
      $_SESSION['seslgntrckid'] = $db_lgntrck_id;
    }

    header("Location: main.php");

?>
    <script type="text/javascript">
      location.href = "<?php echo $rtpth . 'admin/main.php'; ?>";
    </script>
<?php


    exit();
  }
}
?>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<script language="javascript" type="text/javascript">
  var rules = new Array();
  rules[0] = 'txtuid:User Name|required|Enter User name';
  rules[1] = 'txtpwd:Password|required|Enter Password';
</script>
<script language="javascript">
  function setfocus() {
    document.getElementById('txtuid').focus();
  }
</script>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Chaitanya Bharathi Institute of Technology | Admin Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="index2.html"><b>Admin</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form onSubmit="return performCheck('frmlgn', rules, 'inline');" method="post" name="frmlgn">
          <div class="input-group mb-3">
        
            <input type="text" class="form-control" placeholder="User Name" name="txtuid" id="txtuid">
          
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          
          </div>
          <!-- <span id="errorsDiv_txtpwd"></span> -->
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="txtpwd" id="txtpwd" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">

              <input name="btnsubmit" type="submit" value="Submit" class="btn btn-primary btn-block">
            </div>
            <!-- /.col -->
          </div>
          <?php
          if ($gmsg != "") {
            echo $gmsg;
          }
          ?>
        </form>

        <!----<div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> ---->
        <!-- /.social-auth-links -->


        <!-- -   <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>- -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

</body>

</html>