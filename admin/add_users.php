<?php


include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***********************************************************
Programm : add_users.php
Package :
Purpose : For add category
Created By : Lokesh palagani
Created On :
Modified By :
Modified On :
Purpose :
Company : Adroit
 ************************************************************/
/*****header link********/
$pagemncat = "Users";
$pagecat = "Users";
$pagenm = "Users";
/*****header link********/
// session_start();
if($ses_admtyp=='wm' || $ses_admtyp=='d'){
  ?>
		<script language="javascript">
			location.href = "../admin/index.php";
		</script>
	<?php
		exit();
}
global $gmsg;
if (isset($_POST['btnadduser']) && (trim($_POST['btnadduser']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "")) {
  include_once "../database/iqry_user_mst.php";
}
$rd_crntpgnm = "view_all_users.php";
$clspn_val = "4";
?>
<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
  var rules = new Array();
  // rules[0] = 'lstprodcat:Category|required|Select Department';

  rules[0] = 'txtname:name|required|Enter User Name';
  rules[1] = 'txtprior:Priority|numeric|Enter Only Numbers';
  // rules[2] = 'txtname:Name|required|Enter User Name';

  function setfocus() {
    document.getElementById('txtname').focus();
  }
</script>
<?php
include_once('script.php');
include_once('../includes/inc_fnct_ajax_validation.php');
?>
<script language="javascript" type="text/javascript">
  function setfocus() {
    document.getElementById('txtname').focus();
  }

  function funcChkDupName() {

    var name,type,dept;
    name = document.getElementById('txtname').value;
    type = document.getElementById('addtype').value;
    dept = document.getElementById('lstprodcat').value;

    if (name != "") {

      var url = "chkduplicate.php?userid="+name+"&usertype="+type+"&userdept="+dept;
      xmlHttp = GetXmlHttpObject(stateChanged);
      xmlHttp.open("GET", url, true);
      xmlHttp.send(null);
    } else {
      document.getElementById('errorsDiv_txtname').value = "";
    }
  }

  function stateChanged() {
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
      var temp = xmlHttp.responseText;
      document.getElementById("errorsDiv_txtname").innerHTML = temp;

      if (temp != 0) {
        document.getElementById('txtname').focus();
      }
    }
  }
  function chkdepartment() {

    var dept;

    dept = document.getElementById('lstprodcat').value;

    if ( dept!='') {

      var url = "chkduplicate.php?usrdepartment="+dept;
      xmlHttp = GetXmlHttpObject(stateChanged);
      xmlHttp.open("GET", url, true);
      xmlHttp.send(null);
    } else {
      document.getElementById('errorsDiv_lstprodcat').value = "";
    }
  }

  function stateChanged() {
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
      var temp = xmlHttp.responseText;
      document.getElementById("errorsDiv_lstprodcat").innerHTML = temp;

      if (temp != 0) {
        document.getElementById('lstprodcat').focus();
      }
    }
  }


  function disptype() {
    var div1 = document.getElementById("div1");
    if (document.frmadduser.addtype.value == 'd') {
      div1.style.display = "block";

    } else if (document.frmadduser.addtype.value == 'wm') {
      div1.style.display = "none";

    }
  }
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Add Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Users</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- Default box -->
  <div class="card">
    <?php
    if ($gmsg != "") {
      echo "<center><div class='col-12'>
			<font face='Arial' size='2' color = 'red'>$gmsg</font>
			</div></center>";
    }
    if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) { ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert" id="delids">
        <strong>Deleted Successfully !</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php
    }
    ?>

    <div class="card-body p-0">
      <form name="frmadduser" id="frmadduser" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onSubmit="return performCheck('frmadduser', rules, 'inline');">

        <div class="col-md-12">
          <div class="row justify-content-center align-items-center">

            <div class="col-md-12">
              <div class="row mb-2 mt-2">
                <div class="col-sm-3">
                  <label>Type</label>
                </div>
                <div class="col-sm-9">
                  <select name="addtype" id="addtype" class="form-control" onchange="disptype()">
                    <option value="wm" selected>Website Management</option>
                    <option value="d">Department</option>
                  </select>

                </div>
              </div>
            </div>
            <div id="div1" class="col-md-12" style="display: none;">
              <div class="col-md-12">
                <div class="row mb-2 mt-2">
                  <div class="col-sm-3">
                    <label>Department *</label>
                  </div>
                  <div class="col-sm-9">

                    <select name="lstprodcat" id="lstprodcat" class="form-control" onchange="chkdepartment()">
                      <option value="">--Select Department--</option>
                      <?php
                      $sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name from prodcat_mst where prodcatm_typ='d' and prodcatm_admtyp='UG' order by prodcatm_name";
                      $rsprodcat_mst = mysqli_query($conn, $sqryprodcat_mst);
                      $cnt_prodcat = mysqli_num_rows($rsprodcat_mst);
                      if ($cnt_prodcat > 0) {   ?>
                        <option disabled>-- UG --</option>
                        <?php while ($rowsprodcat_mst = mysqli_fetch_assoc($rsprodcat_mst)) {
                          $catid = $rowsprodcat_mst['prodcatm_id'];
                          $catname = $rowsprodcat_mst['prodcatm_name'];
                        ?>
                          <option value="<?php echo $catid; ?>"><?php echo $catname; ?></option>
                        <?php
                        }
                      }
                      $sqryprodcat_mst1 = "SELECT prodcatm_id,prodcatm_name from prodcat_mst where prodcatm_typ='d' and prodcatm_admtyp='PG' order by prodcatm_name";
                      $rsprodcat_mst1 = mysqli_query($conn, $sqryprodcat_mst1);
                      $cnt_prodcat1 = mysqli_num_rows($rsprodcat_mst1);
                      if ($cnt_prodcat1 > 0) {   ?>
                        <option disabled>-- PG --</option>
                        <?php while ($rowsprodcat_mst1 = mysqli_fetch_assoc($rsprodcat_mst1)) {
                          $catid = $rowsprodcat_mst1['prodcatm_id'];
                          $catname = $rowsprodcat_mst1['prodcatm_name'];
                        ?>
                          <option value="<?php echo $catid; ?>"><?php echo $catname; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                    <span id="errorsDiv_lstprodcat"></span>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-md-12">
              <div class="row mb-2 mt-2">
                <div class="col-sm-3">
                  <label> User Name *</label>
                </div>
                <div class="col-sm-9">
                  <input name="txtname" type="text" id="txtname" size="45" maxlength="40" class="form-control" onBlur="funcChkDupName()">
                  <!-- onBlur="funcChkDupName()" -->
                  <span id="errorsDiv_txtname"></span>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="row mb-2 mt-2">
                <div class="col-sm-3">
                  <label>Status</label>
                </div>
                <div class="col-sm-9">
                  <select name="lststs" id="lststs" class="form-control">
                    <option value="a" selected>Active</option>
                    <option value="i">Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            <p class="text-center">
              <input type="Submit" class="btn btn-primary" name="btnadduser" id="btnadduser" value="Submit">
              &nbsp;&nbsp;&nbsp;
              <input type="reset" class="btn btn-primary" name="btnprodcatreset" value="Clear" id="btnprodcatreset">
              &nbsp;&nbsp;&nbsp;
              <input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm; ?>'">
            </p>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</section>
<?php include_once "../includes/inc_adm_footer.php"; ?>
<script language="javascript" type="text/javascript">
  CKEDITOR.replace('txtdesc');
</script>